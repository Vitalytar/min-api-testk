<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Account;
use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;

/**
 * Class MakeTransactionController
 *
 * @package App\Controller
 */
class MakeTransactionController extends AbstractController
{
    private const CURRENCY_CONVERTER_API_KEY = 'fb814239e1dacde898e7f168f36728ef';
    private const CURRENCY_CONVERTER_BASE_URL = 'http://data.fixer.io/api/latest'; // Not HTTPS due to free plan

    /**
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface     $validator
     * @param HttpClientInterface    $client
     */
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ValidatorInterface $validator,
        protected HttpClientInterface $client
    ) {}

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    #[Route('/make/transaction', name: 'make_transaction', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        $requestParams = json_decode($request->getContent(), true);
        $violations = $this->fieldsValidation($requestParams);

        if ($violations->count()) {
            return $this->prepareResponse(true, (string) $violations, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $senderAmount = $amount = (float) $requestParams['amount'];
        $currency = (string) $requestParams['currency'];
        $accountEntity = $this->entityManager->getRepository(Account::class);
        $senderAccount = $accountEntity->find((int) $requestParams['senderAccountId']);
        $receiverAccount = $accountEntity->find((int) $requestParams['receiverAccountId']);

        if (!$senderAccount || !$receiverAccount) {
            return $this->prepareResponse(true, 'One of the accounts was not found!', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($receiverAccount->getAccountCurrency() !== $currency) {
            return $this->prepareResponse(true, 'Receiver account currency is different', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $senderData = ['error' => false, 'amount' => $senderAmount];

        if ($senderAccount->getAccountCurrency() !== $currency) {
            $senderData = $this->convertCurrency($senderAccount->getAccountCurrency(), $currency, $amount);
        }

        if (!$senderData['error']) {
            $senderAmount = $senderData['amount'];

            if ($senderAmount > $senderAccount->getFunds()) {
                return $this->prepareResponse(true, 'Not enough funds on sender account', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $newTransaction = (new Transaction())->setCurrency($currency)
                ->setTransactionAmount($amount)
                ->setReceiverAccount($receiverAccount)
                ->setSenderAccount($senderAccount);

            $this->entityManager->persist($newTransaction);
            $senderAccount->setFunds($senderAccount->getFunds() - $senderAmount);
            $receiverAccount->setFunds($receiverAccount->getFunds() + $amount);
            $this->entityManager->flush();
            $this->entityManager->clear();


            return $this->prepareResponse(false, 'Transaction successful', Response::HTTP_OK);
        } else {
            return $this->prepareResponse(false, 'Transaction failed', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $isError
     * @param $message
     * @param $statusCode
     *
     * @return JsonResponse
     */
    private function prepareResponse($isError, $message, $statusCode): JsonResponse
    {
        return $this->json(
            ['error' => $isError, 'message' => "$message"],
            $statusCode,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * @param $currency
     * @param $targetCurrency
     * @param $amount
     *
     * @return array|true[]
     */
    private function convertCurrency($currency, $targetCurrency, $amount): array
    {
        try {
            $currencyRates = $this->getCurrencyRates();

            if ($currencyRates) {
                if ($currency !== 'EUR') {
                    $eurAmount = $amount / $currencyRates[$targetCurrency];
                    $amountToDeduct = $eurAmount * $currencyRates[$currency];
                } else {
                    $amountToDeduct = $amount / $currencyRates[$targetCurrency];
                }

                return ['error' => false, 'amount' => $amountToDeduct];
            }
        } catch (ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface) {
            return ['error' => true];
        }

        return ['error' => true];
    }

    private function getCurrencyRates()
    {
        try {
            $response = $this->client->request(
                'GET',
                self::CURRENCY_CONVERTER_BASE_URL,
                [
                    'query' => [
                        'access_key' => self::CURRENCY_CONVERTER_API_KEY
                    ]
                ]
            );

            if ($response->getStatusCode() !== Response::HTTP_OK) {
                return false;
            }

            $ratesResponse = json_decode($response->getContent(), true);

            if ($ratesResponse && $ratesResponse['success']) {
                return $ratesResponse['rates'];
            }
        } catch (TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface) {
            return false;
        }

        return false;
    }

    /**
     * @param $postArgs
     *
     * @return ConstraintViolationListInterface
     */
    private function fieldsValidation($postArgs): ConstraintViolationListInterface
    {
        $senderAccountId = $postArgs['senderAccountId'] ?? '';

        $constraints = new Assert\Collection([
            'senderAccountId' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'number'])
            ],
            'receiverAccountId' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'number']),
                new Assert\NotIdenticalTo($senderAccountId)
            ],
            'amount' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'number']),
                new Assert\Positive()
            ],
            'currency' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'string']),
                new Assert\Length(['min' => 3, 'max' => 3]),
                new Assert\Currency(),
                new Assert\NoSuspiciousCharacters()
            ]
        ]);

        return $this->validator->validate($postArgs, $constraints);
    }
}

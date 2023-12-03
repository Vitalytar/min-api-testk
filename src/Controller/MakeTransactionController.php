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

/**
 * Class MakeTransactionController
 *
 * @package App\Controller
 */
class MakeTransactionController extends AbstractController
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(protected EntityManagerInterface $entityManager) {}

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    #[Route('/make/transaction', name: 'make_transaction', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        $requestParams = json_decode($request->getContent());
        $senderId = $requestParams->senderAccountId;
        $receiverId = $requestParams->receiverAccountId;

        if (!is_numeric($requestParams->amount)) {
            return $this->prepareResponse(true, 'Amount is invalid!', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $amount = (float)$requestParams->amount;
        $currency = $requestParams->currency;
        $accountEntity = $this->entityManager->getRepository(Account::class);

        if ($senderId === $receiverId) {
            return $this->prepareResponse(
                true,
                'You can\'t transfer funds from account to the same account!',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $senderAccount = $accountEntity->find($senderId);
        $receiverAccount = $accountEntity->find($receiverId);

        if (!$senderAccount || !$receiverAccount) {
            return $this->prepareResponse(true, 'One of the accounts was not found!', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $newTransaction = (new Transaction())->setCurrency($currency)
            ->setTransactionAmount($amount)
            ->setReceiverAccount($receiverAccount)
            ->setSenderAccount($senderAccount);

        $this->entityManager->persist($newTransaction);
        $senderAccount->setFunds($senderAccount->getFunds() - $amount);
        $receiverAccount->setFunds($receiverAccount->getFunds() + $amount);
        $this->entityManager->flush();
        $this->entityManager->clear();


        return $this->prepareResponse(false, 'Transaction successful!', Response::HTTP_OK);
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
            ['error' => $isError, 'message' => $message],
            $statusCode,
            ['Content-Type' => 'application/json']
        );
    }
}

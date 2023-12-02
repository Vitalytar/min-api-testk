<?php

declare(strict_types=1);

namespace App\Controller;

use ApiPlatform\Metadata\Operation;
use Symfony\Component\HttpKernel\Attribute\AsController;
use App\Repository\ClientRepository;
use ApiPlatform\State\ProviderInterface;

#[AsController]
class AccountsRetrieving implements ProviderInterface
{
    public function __construct(protected ClientRepository $clientRepository) {}

    /**
     * @param Operation $operation
     * @param array     $uriVariables
     * @param array     $context
     *
     * @return object|array|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $clientId = $uriVariables['clientId'];
        $clientAccounts = $this->clientRepository->findOneBy(['client_id' => $clientId]);

        if (!$clientAccounts) {
            return ['ERROR! Client accounts with provided ID were not found!'];
        }

        $resultedData = [];
        $clientName = $clientAccounts->getClientName();

        foreach ($clientAccounts->getAccounts() as $account) {
            $resultedData[] = [
                'client_name' => $clientName,
                'account_id' => $account->getId(),
                'account_name' => $account->getAccountName(),
                'funds' => $account->getFunds(),
                'account_currency' => $account->getAccountCurrency()
            ];
        }

        return $resultedData;
    }
}

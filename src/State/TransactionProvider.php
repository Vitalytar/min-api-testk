<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\TransactionRepository;
use App\Repository\AccountRepository;

/**
 * Class TransactionProvider
 *
 * @package App\State
 */
class TransactionProvider implements ProviderInterface
{
    /**
     * @param TransactionRepository $transactionRepository
     * @param AccountRepository     $accountRepository
     */
    public function __construct(
        protected TransactionRepository $transactionRepository,
        protected AccountRepository $accountRepository
    ) {}

    /**
     * @param Operation $operation
     * @param array     $uriVariables
     * @param array     $context
     *
     * @return object|array|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $account = $this->accountRepository->find($uriVariables['id']);

        if (!empty($context['filters'])) {
            $account = $this->transactionRepository->findTransactionsByAccountId($account, $context['filters']);
        } else {
            $account = $this->transactionRepository->findTransactionsByAccountId($account);
        }

        return $account;
    }
}

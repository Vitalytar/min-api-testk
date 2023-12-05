<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use App\State\TransactionProvider;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ApiResource(
    operations: [new Get(uriTemplate: '/account-transactions/{id}')],
    provider: TransactionProvider::class
)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Account $sender_account = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Account $receiver_account = null;

    #[ORM\Column]
    private ?float $transaction_amount = null;

    #[ORM\Column(length: 3)]
    private ?string $currency = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSenderAccount(): ?Account
    {
        return $this->sender_account;
    }

    public function setSenderAccount(?Account $sender_account): static
    {
        $this->sender_account = $sender_account;

        return $this;
    }

    public function getReceiverAccount(): ?Account
    {
        return $this->receiver_account;
    }

    public function setReceiverAccount(?Account $receiver_account): static
    {
        $this->receiver_account = $receiver_account;

        return $this;
    }

    public function getTransactionAmount(): ?float
    {
        return $this->transaction_amount;
    }

    public function setTransactionAmount(float $transaction_amount): static
    {
        $this->transaction_amount = $transaction_amount;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TransactionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionsRepository::class)]
#[ApiResource]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $transaction_id = null;

    #[ORM\Column]
    private ?int $sender_account_id = null;

    #[ORM\Column]
    private ?int $receiver_account_id = null;

    #[ORM\Column(length: 255)]
    private ?string $transaction_hash = null;

    #[ORM\Column(length: 255)]
    private ?string $sent_amount = null;

    #[ORM\Column(length: 255)]
    private ?string $received_amount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransactionId(): ?int
    {
        return $this->transaction_id;
    }

    public function setTransactionId(int $transaction_id): static
    {
        $this->transaction_id = $transaction_id;

        return $this;
    }

    public function getSenderAccountId(): ?int
    {
        return $this->sender_account_id;
    }

    public function setSenderAccountId(int $sender_account_id): static
    {
        $this->sender_account_id = $sender_account_id;

        return $this;
    }

    public function getReceiverAccountId(): ?int
    {
        return $this->receiver_account_id;
    }

    public function setReceiverAccountId(int $receiver_account_id): static
    {
        $this->receiver_account_id = $receiver_account_id;

        return $this;
    }

    public function getTransactionHash(): ?string
    {
        return $this->transaction_hash;
    }

    public function setTransactionHash(string $transaction_hash): static
    {
        $this->transaction_hash = $transaction_hash;

        return $this;
    }

    public function getSentAmount(): ?string
    {
        return $this->sent_amount;
    }

    public function setSentAmount(string $sent_amount): static
    {
        $this->sent_amount = $sent_amount;

        return $this;
    }

    public function getReceivedAmount(): ?string
    {
        return $this->received_amount;
    }

    public function setReceivedAmount(string $received_amount): static
    {
        $this->received_amount = $received_amount;

        return $this;
    }
}

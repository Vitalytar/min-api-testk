<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $transaction_id = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Account $sender_account_id = null;

    #[ORM\ManyToOne(inversedBy: 'transactions_receiver')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Account $receiver_account_id = null;

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

    public function getSenderAccountId(): ?Account
    {
        return $this->sender_account_id;
    }

    public function setSenderAccountId(?Account $sender_account_id): static
    {
        $this->sender_account_id = $sender_account_id;

        return $this;
    }

    public function getReceiverAccountId(): ?Account
    {
        return $this->receiver_account_id;
    }

    public function setReceiverAccountId(?Account $receiver_account_id): static
    {
        $this->receiver_account_id = $receiver_account_id;

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

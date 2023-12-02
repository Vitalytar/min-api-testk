<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $account_id = null;

    #[ORM\Column(length: 255)]
    private ?string $account_name = null;

    #[ORM\Column]
    private ?float $funds = null;

    #[ORM\Column(length: 3)]
    private ?string $account_currency = null;

    #[ORM\ManyToOne(inversedBy: 'accounts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client_id = null;

    #[ORM\OneToMany(mappedBy: 'sender_account_id', targetEntity: Transaction::class)]
    private Collection $transactions;

    #[ORM\OneToMany(mappedBy: 'receiver_account_id', targetEntity: Transaction::class)]
    private Collection $transactions_receiver;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->transactions_receiver = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountId(): ?int
    {
        return $this->account_id;
    }

    public function setAccountId(int $account_id): static
    {
        $this->account_id = $account_id;

        return $this;
    }

    public function getAccountName(): ?string
    {
        return $this->account_name;
    }

    public function setAccountName(string $account_name): static
    {
        $this->account_name = $account_name;

        return $this;
    }

    public function getFunds(): ?float
    {
        return $this->funds;
    }

    public function setFunds(float $funds): static
    {
        $this->funds = $funds;

        return $this;
    }

    public function getAccountCurrency(): ?string
    {
        return $this->account_currency;
    }

    public function setAccountCurrency(string $account_currency): static
    {
        $this->account_currency = $account_currency;

        return $this;
    }

    public function getClientId(): ?Client
    {
        return $this->client_id;
    }

    public function setClientId(?Client $client_id): static
    {
        $this->client_id = $client_id;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): static
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setSenderAccountId($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getSenderAccountId() === $this) {
                $transaction->setSenderAccountId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactionsReceiver(): Collection
    {
        return $this->transactions_receiver;
    }

    public function addTransactionsReceiver(Transaction $transactionsReceiver): static
    {
        if (!$this->transactions_receiver->contains($transactionsReceiver)) {
            $this->transactions_receiver->add($transactionsReceiver);
            $transactionsReceiver->setReceiverAccountId($this);
        }

        return $this;
    }

    public function removeTransactionsReceiver(Transaction $transactionsReceiver): static
    {
        if ($this->transactions_receiver->removeElement($transactionsReceiver)) {
            // set the owning side to null (unless already changed)
            if ($transactionsReceiver->getReceiverAccountId() === $this) {
                $transactionsReceiver->setReceiverAccountId(null);
            }
        }

        return $this;
    }
}

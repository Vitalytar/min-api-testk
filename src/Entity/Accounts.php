<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AccountsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountsRepository::class)]
#[ApiResource]
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
    private ?int $funds = null;

    #[ORM\Column(length: 3)]
    private ?string $account_currency = null;

    #[ORM\Column]
    private ?int $client_id = null;

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

    public function getFunds(): ?int
    {
        return $this->funds;
    }

    public function setFunds(int $funds): static
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

    public function getClientId(): ?int
    {
        return $this->client_id;
    }

    public function setClientId(int $client_id): static
    {
        $this->client_id = $client_id;

        return $this;
    }
}

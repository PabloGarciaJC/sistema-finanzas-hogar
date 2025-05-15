<?php

namespace App\Entity;

use App\Repository\PeriodRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeriodRepository::class)]
class Period
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $month = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(type: 'string', length: 6, options: ['default' => 'Open'])]
    private string $status = 'Open';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonth(): ?string
    {
        return $this->month;
    }

    public function setMonth(string $month): self
    {
        $this->month = $month;
        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        // Opcional: validar que sea 'Open' o 'Closed'
        if (!in_array($status, ['Open', 'Closed'])) {
            throw new \InvalidArgumentException("Invalid status");
        }
        $this->status = $status;
        return $this;
    }
}

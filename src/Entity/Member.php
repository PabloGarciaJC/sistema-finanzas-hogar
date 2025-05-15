<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $company = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private ?string $salary = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Income::class, orphanRemoval: true)]
    private Collection $incomes;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Credit::class, orphanRemoval: true)]
    private Collection $credits;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Saving::class, orphanRemoval: true)]
    private Collection $savings;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Goal::class, orphanRemoval: true)]
    private Collection $goals;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: MonthlySummary::class, orphanRemoval: true)]
    private Collection $monthlySummaries;

    public function __construct()
    {
        $this->incomes = new ArrayCollection();
        $this->credits = new ArrayCollection();
        $this->savings = new ArrayCollection();
        $this->goals = new ArrayCollection();
        $this->monthlySummaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;
        return $this;
    }

    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(string $salary): self
    {
        $this->salary = $salary;
        return $this;
    }

    /** @return Collection<int, Income> */
    public function getIncomes(): Collection
    {
        return $this->incomes;
    }

    public function addIncome(Income $income): self
    {
        if (!$this->incomes->contains($income)) {
            $this->incomes[] = $income;
            $income->setMember($this);
        }
        return $this;
    }

    public function removeIncome(Income $income): self
    {
        if ($this->incomes->removeElement($income)) {
            if ($income->getMember() === $this) {
                $income->setMember(null);
            }
        }
        return $this;
    }

    /** @return Collection<int, Credit> */
    public function getCredits(): Collection
    {
        return $this->credits;
    }

    public function addCredit(Credit $credit): self
    {
        if (!$this->credits->contains($credit)) {
            $this->credits[] = $credit;
            $credit->setMember($this);
        }
        return $this;
    }

    public function removeCredit(Credit $credit): self
    {
        if ($this->credits->removeElement($credit)) {
            if ($credit->getMember() === $this) {
                $credit->setMember(null);
            }
        }
        return $this;
    }

    /** @return Collection<int, Saving> */
    public function getSavings(): Collection
    {
        return $this->savings;
    }

    public function addSaving(Saving $saving): self
    {
        if (!$this->savings->contains($saving)) {
            $this->savings[] = $saving;
            $saving->setMember($this);
        }
        return $this;
    }

    public function removeSaving(Saving $saving): self
    {
        if ($this->savings->removeElement($saving)) {
            if ($saving->getMember() === $this) {
                $saving->setMember(null);
            }
        }
        return $this;
    }

    /** @return Collection<int, Goal> */
    public function getGoals(): Collection
    {
        return $this->goals;
    }

    public function addGoal(Goal $goal): self
    {
        if (!$this->goals->contains($goal)) {
            $this->goals[] = $goal;
            $goal->setMember($this);
        }
        return $this;
    }

    public function removeGoal(Goal $goal): self
    {
        if ($this->goals->removeElement($goal)) {
            if ($goal->getMember() === $this) {
                $goal->setMember(null);
            }
        }
        return $this;
    }

    /** @return Collection<int, MonthlySummary> */
    public function getMonthlySummaries(): Collection
    {
        return $this->monthlySummaries;
    }

    public function addMonthlySummary(MonthlySummary $summary): self
    {
        if (!$this->monthlySummaries->contains($summary)) {
            $this->monthlySummaries[] = $summary;
            $summary->setMember($this);
        }
        return $this;
    }

    public function removeMonthlySummary(MonthlySummary $summary): self
    {
        if ($this->monthlySummaries->removeElement($summary)) {
            if ($summary->getMember() === $this) {
                $summary->setMember(null);
            }
        }
        return $this;
    }
}

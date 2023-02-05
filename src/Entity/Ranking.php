<?php

namespace App\Entity;

use App\Repository\RankingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RankingRepository::class)]
class Ranking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberOfTries = null;

    #[ORM\ManyToOne(inversedBy: 'rankings')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'rankings')]
    private ?Riddle $riddle = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasGuessed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberOfTries(): ?int
    {
        return $this->numberOfTries;
    }

    public function setNumberOfTries(?int $numberOfTries): self
    {
        $this->numberOfTries = $numberOfTries;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRiddle(): ?Riddle
    {
        return $this->riddle;
    }

    public function setRiddle(?Riddle $riddle): self
    {
        $this->riddle = $riddle;

        return $this;
    }

    public function isHasGuessed(): ?bool
    {
        return $this->hasGuessed;
    }

    public function setHasGuessed(?bool $hasGuessed): self
    {
        $this->hasGuessed = $hasGuessed;

        return $this;
    }
}

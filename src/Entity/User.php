<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Regex(
        pattern: '/yazidfesse/i',
        message: 'Non Pierre...Non',
        match: false
    )]
    #[Assert\Regex(
        pattern: '/yazid fesse/i',
        message: 'Non Pierre...Non',
        match: false
    )]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberOfCoins = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberOfGoldenTickets = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberOfDraw = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberOfChocoPaid = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberOfChocoEaten = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isParticipating = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isGolden = null;

    #[ORM\Column(nullable: true)]
    private ?int $NumberOfParticipation = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Riddle::class)]
    private Collection $riddles;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Ranking::class)]
    private Collection $rankings;

    public function __construct()
    {
        $this->riddles = new ArrayCollection();
        $this->rankings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNumberOfCoins(): ?int
    {
        return $this->numberOfCoins;
    }

    public function setNumberOfCoins(?int $numberOfCoins): self
    {
        $this->numberOfCoins = $numberOfCoins;

        return $this;
    }

    public function getNumberOfGoldenTickets(): ?int
    {
        return $this->numberOfGoldenTickets;
    }

    public function setNumberOfGoldenTickets(?int $numberOfGoldenTickets): self
    {
        $this->numberOfGoldenTickets = $numberOfGoldenTickets;

        return $this;
    }

    public function getNumberOfDraw(): ?int
    {
        return $this->numberOfDraw;
    }

    public function setNumberOfDraw(?int $numberOfDraw): self
    {
        $this->numberOfDraw = $numberOfDraw;

        return $this;
    }

    public function getNumberOfChocoPaid(): ?int
    {
        return $this->numberOfChocoPaid;
    }

    public function setNumberOfChocoPaid(?int $numberOfChocoPaid): self
    {
        $this->numberOfChocoPaid = $numberOfChocoPaid;

        return $this;
    }

    public function getNumberOfChocoEaten(): ?int
    {
        return $this->numberOfChocoEaten;
    }

    public function setNumberOfChocoEaten(?int $numberOfChocoEaten): self
    {
        $this->numberOfChocoEaten = $numberOfChocoEaten;

        return $this;
    }

    public function isIsParticipating(): ?bool
    {
        return $this->isParticipating;
    }

    public function setIsParticipating(?bool $isParticipating): self
    {
        $this->isParticipating = $isParticipating;

        return $this;
    }

    public function isIsGolden(): ?bool
    {
        return $this->isGolden;
    }

    public function setIsGolden(?bool $isGolden): self
    {
        $this->isGolden = $isGolden;

        return $this;
    }

    public function getNumberOfParticipation(): ?int
    {
        return $this->NumberOfParticipation;
    }

    public function setNumberOfParticipation(?int $NumberOfParticipation): self
    {
        $this->NumberOfParticipation = $NumberOfParticipation;

        return $this;
    }

    /**
     * @return Collection<int, Riddle>
     */
    public function getRiddles(): Collection
    {
        return $this->riddles;
    }

    public function addRiddle(Riddle $riddle): self
    {
        if (!$this->riddles->contains($riddle)) {
            $this->riddles->add($riddle);
            $riddle->setAuthor($this);
        }

        return $this;
    }

    public function removeRiddle(Riddle $riddle): self
    {
        if ($this->riddles->removeElement($riddle)) {
            // set the owning side to null (unless already changed)
            if ($riddle->getAuthor() === $this) {
                $riddle->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ranking>
     */
    public function getRankings(): Collection
    {
        return $this->rankings;
    }

    public function addRanking(Ranking $ranking): self
    {
        if (!$this->rankings->contains($ranking)) {
            $this->rankings->add($ranking);
            $ranking->setUser($this);
        }

        return $this;
    }

    public function removeRanking(Ranking $ranking): self
    {
        if ($this->rankings->removeElement($ranking)) {
            // set the owning side to null (unless already changed)
            if ($ranking->getUser() === $this) {
                $ranking->setUser(null);
            }
        }

        return $this;
    }
}

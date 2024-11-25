<?php

namespace App\Entity;

use App\Repository\DeveloperRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DeveloperRepository::class)]
class Developer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Имя не должно быть пустым.")]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Фамилия не должна быть пустой.")]
    private ?string $surname = null;

    #[ORM\Column(length: 255)]
    private ?string $fullname = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $birthdate = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Должность не должна быть пустой.")]
    private ?string $position = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(message: "Введите корректный адрес электронной почты.")]
    #[Assert\NotBlank(message: "Email не должен быть пустым.")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Телефон не должен быть пустым.")]
    private ?string $phone = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isActive = true;

    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'developers')]
    private Collection $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return string
     */
    public function getActive(): string
    {
        return $this->isActive ? 'Active' : 'Inactive';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): static
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function setBirthdate(?string $birthdate): static
    {
        $this->birthdate = $birthdate;
        return $this;
    }

    public function getBirthdate(): ?string
    {
        return $this->birthdate;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->addDeveloper($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            $project->removeDeveloper($this);
        }

        return $this;
    }

    public function getAge(): int
    {
        if ($this->birthdate) {
            $now = new \DateTime();
            return $now->diff($this->birthdate)->y;
        }
        // Возраст 0, если дата рождения не установлена
        return 0;
    }

}

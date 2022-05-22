<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
)]
#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $text;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'boolean')]
    private $status = false;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'questions')]
    private $category;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'questions')]
    private $user;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Aswer::class)]
    private $aswers;

    public function __construct()
    {
        $this->aswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString() {
        return $this->title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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

    /**
     * @return Collection<int, Aswer>
     */
    public function getAswers(): Collection
    {
        return $this->aswers;
    }

    public function addAswer(Aswer $aswer): self
    {
        if (!$this->aswers->contains($aswer)) {
            $this->aswers[] = $aswer;
            $aswer->setQuestion($this);
        }

        return $this;
    }

    public function removeAswer(Aswer $aswer): self
    {
        if ($this->aswers->removeElement($aswer)) {
            // set the owning side to null (unless already changed)
            if ($aswer->getQuestion() === $this) {
                $aswer->setQuestion(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show_book"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Groups({"show_book"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"show_book"})
     */
    private $resume;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"show_book"})
     */
    private $pagesCount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"show_book"})
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     * @Groups({"show_book"})
     */
    private $isbn;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"show_book"})
     */
    private $inSell;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, cascade={"persist"})
     * @Groups({"show_book"})
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, cascade={"persist"})
     * @Groups({"show_book"})
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getPagesCount(): ?int
    {
        return $this->pagesCount;
    }

    public function setPagesCount(int $pagesCount): self
    {
        $this->pagesCount = $pagesCount;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function setIsbn(?string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getInSell(): ?bool
    {
        return $this->inSell;
    }

    public function setInSell(bool $inSell): self
    {
        $this->inSell = $inSell;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime();
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}

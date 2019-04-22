<?php

namespace App\Entity;

use App\Entity\Traits\BlameableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 */
class News
{
    use TimestampableEntity;
    use BlameableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=8192)
     * @Assert\NotBlank()
     * @Assert\Length(max="8192")
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NewsComment", mappedBy="news", orphanRemoval=true)
     * @ORM\OrderBy({"createdAt": "desc"})
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection|NewsComment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(NewsComment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setNews($this);
        }

        return $this;
    }

    public function removeComment(NewsComment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getNews() === $this) {
                $comment->setNews(null);
            }
        }

        return $this;
    }
}

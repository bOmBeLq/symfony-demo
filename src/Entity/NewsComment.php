<?php

namespace App\Entity;

use App\Entity\Traits\BlameableEntityNullable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsCommentRepository")
 */
class NewsComment
{
    use TimestampableEntity;
    use BlameableEntityNullable;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\News", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $news;

    /**
     * @ORM\Column(type="string", length=8192)
     * @Assert\NotBlank()
     * @Assert\Length(max="8192")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Assert\Length(max="64")
     */
    private $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNews(): ?News
    {
        return $this->news;
    }

    public function setNews(?News $news): self
    {
        $this->news = $news;

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


    public function getAuthor(): ?string
    {
        return $this->getCreatedBy() ?: $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }


}

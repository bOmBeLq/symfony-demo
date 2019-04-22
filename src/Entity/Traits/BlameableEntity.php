<?php


namespace App\Entity\Traits;


use App\Entity\User;
use Gedmo\Mapping\Annotation as Gedmo;

trait BlameableEntity
{
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     * @Gedmo\Blameable(on="create")
     */
    private $createdBy;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     * @Gedmo\Blameable(on="update")
     */
    private $updatedBy;

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     * @return self
     */
    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return User
     */
    public function getUpdatedBy(): User
    {
        return $this->updatedBy;
    }

    /**
     * @param User $updatedBy
     * @return self
     */
    public function setUpdatedBy(User $updatedBy): self
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }
}
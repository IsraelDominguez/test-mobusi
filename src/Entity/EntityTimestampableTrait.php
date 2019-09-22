<?php namespace App\Entity;

trait EntityTimestampableTrait
{
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     * @return Component
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return Component
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     *
     * Events
     */
    /** @ORM\PrePersist */
    function onPrePersist() {
        //using Doctrine DateTime here
        $this->createdAt = new \DateTime();
    }

    /** @ORM\PreUpdate */
    function onPreUpdate($args) {
        $this->updateAt = new \DateTime();
    }
}
<?php

namespace App\Entity;

use App\AdComponents\AdComponentInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\AdRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Ad
{
    const STATUS_PUBLISHED = 'published';
    const STATUS_STOPPED = 'stopped';
    const STATUS_PUBLISHING = 'publishing';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="This field is required")
     * @ORM\Column(type="string", length=255)
     * @Groups({"api_rest"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Advertiser", inversedBy="advertiser")
     *
     */
    protected $advertiser;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Publisher", mappedBy="publishers")
     */
    private $publishers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Component", mappedBy="ad", cascade={"persist"})
     */
    private $components;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"api_rest"})
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"api_rest"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"api_rest"})
     */
    private $createdAt;

    public function __construct() {
        $this->publishers = new ArrayCollection();
        $this->components = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Ad
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Ad
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdvertiser()
    {
        return $this->advertiser;
    }

    /**
     * @param mixed $advertiser
     * @return Ad
     */
    public function setAdvertiser($advertiser)
    {
        $this->advertiser = $advertiser;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPublishers(): \Doctrine\Common\Collections\Collection
    {
        return $this->publishers;
    }

    /**
     * @param ArrayCollection $publishers
     * @return Ad
     */
    public function setPublishers(ArrayCollection $publishers): Ad
    {
        $this->publishers = $publishers;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * @return Ad
     */
    public function addComponent(AdComponentInterface $component): Ad
    {
        $this->components->add($component);
        return $this;
    }
    /**
     * @param mixed $components
     * @return Ad
     */
    public function setComponents($components)
    {
        $this->components = $components;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Ad
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     * @return Ad
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
     * @return Ad
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

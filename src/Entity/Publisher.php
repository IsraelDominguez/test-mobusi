<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PublisherRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Publisher
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"ad"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"ad"})
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Ad", mappedBy="publishers")
     */
    private $ads;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    public function __construct()
    {
        $this->ads = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Publisher
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
     * @return Publisher
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param Ad $ad
     */
    public function addAd(Ad $ad) {
        $this->ads[] = $ad;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAds(): \Doctrine\Common\Collections\Collection
    {
        return $this->ads;
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
     * @return Publisher
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
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdRepository")
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
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Advertiser", inversedBy="advertiser")
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
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    public function __construct() {
        $this->publishers = new ArrayCollection();
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

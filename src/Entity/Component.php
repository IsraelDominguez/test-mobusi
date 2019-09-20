<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ComponentRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 */
class Component
{
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
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ad", inversedBy="components")
     */
    protected $ad;

    /**
     * @Assert\NotBlank(message="This field is required")
     * @ORM\Column(type="float")
     */
    protected $posX;
    /**
     * @Assert\NotBlank(message="This field is required")
     * @ORM\Column(type="float")
     */
    protected $posY;
    /**
     * @Assert\NotBlank(message="This field is required")
     * @ORM\Column(type="float")
     */
    protected $posZ;
    /**
     * @Assert\NotBlank(message="This field is required")
     * @ORM\Column(type="float")
     */
    protected $height;
    /**
     * @Assert\NotBlank(message="This field is required")
     * @ORM\Column(type="float")
     */
    protected $width;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

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

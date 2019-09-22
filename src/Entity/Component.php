<?php

namespace App\Entity;

use App\AdComponents\AdComponentInterface;
use App\AdComponents\AdComponentTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ComponentRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 */
abstract class Component implements AdComponentInterface
{

    use AdComponentTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="This field is required")
     * @Assert\Type("string")
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ad", inversedBy="components")
     */
    protected $ad;

    /**
     * @Assert\NotBlank(message="This field is required")
     * @Assert\Type("int")
     * @ORM\Column(type="float")
     */
    protected $posX;
    /**
     * @Assert\NotBlank(message="This field is required")
     * @Assert\Type("int")
     * @ORM\Column(type="float")
     */
    protected $posY;
    /**
     * @Assert\NotBlank(message="This field is required")
     * @Assert\Type("int")
     * @ORM\Column(type="float")
     */
    protected $posZ;
    /**
     * @Assert\NotBlank(message="This field is required")
     * @Assert\Type("int")
     * @ORM\Column(type="float")
     */
    protected $height;
    /**
     * @Assert\NotBlank(message="This field is required")
     * @Assert\Type("int")
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


    public function setEntityFromJson($json)
    {
        $this->name = $json->name ?? null;
        $this->posX = $json->posX ?? null;
        $this->posY = $json->posY ?? null;
        $this->posZ = $json->posZ ?? null;
        $this->height = $json->height ?? null;
        $this->width = $json->width ?? null;
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
     * @return Component
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
     * @return Component
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAd()
    {
        return $this->ad;
    }

    /**
     * @param mixed $ad
     * @return Component
     */
    public function setAd($ad)
    {
        $this->ad = $ad;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosX()
    {
        return $this->posX;
    }

    /**
     * @param mixed $posX
     * @return Component
     */
    public function setPosX($posX)
    {
        $this->posX = $posX;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosY()
    {
        return $this->posY;
    }

    /**
     * @param mixed $posY
     * @return Component
     */
    public function setPosY($posY)
    {
        $this->posY = $posY;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosZ()
    {
        return $this->posZ;
    }

    /**
     * @param mixed $posZ
     * @return Component
     */
    public function setPosZ($posZ)
    {
        $this->posZ = $posZ;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     * @return Component
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     * @return Component
     */
    public function setWidth($width)
    {
        $this->width = $width;
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

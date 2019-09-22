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
    use EntityTimestampableTrait;

    const STATUS_PUBLISHED = 'published';
    const STATUS_STOPPED = 'stopped';
    const STATUS_PUBLISHING = 'publishing';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Groups({"ad","publisher"})
     */
    private $id;

    /**
     * @Assert\NotBlank(message="This field is required")
     * @ORM\Column(type="string", length=255)
     * @Groups({"publisher", "ad"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Advertiser", inversedBy="advertiser")
     * @Groups({"ad","publisher"})
     */
    protected $advertiser;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Publisher", inversedBy="ads")
     * @ORM\JoinTable(name="publisher_ad")
     * @Groups({"ad"})
     */
    private $publishers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Component", mappedBy="ad", cascade={"persist"})
     * @Groups({"ad"})
     */
    private $components;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"api_rest"})
     * @Groups({"ad"})
     */
    private $status;

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
     * @param Publisher $publisher
     */
    public function addPublisher(Publisher $publisher)
    {
        $publisher->addAd($this); // synchronously updating inverse side
        $this->publishers[] = $publisher;
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
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'status' => $this->getStatus()
        ];
    }
}

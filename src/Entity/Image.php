<?php

namespace App\Entity;

use App\AdComponents\AdComponentInterface;
use App\AdComponents\AdComponentTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image extends Component implements AdComponentInterface
{

    use AdComponentTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500)
     * @Assert\Type("string")
     * @Assert\Url
     * @Assert\NotBlank(message="This field is required")
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Choice(choices={"jpg", "png"}, message="MimeType must be 'jpg' or 'png'")
     * @Assert\NotBlank(message="This field is required")
     */
    private $mimeType;

    /**
     * @ORM\Column(type="float")
     * @Assert\Type("long")
     * @Assert\NotBlank(message="This field is required")
     */
    private $size;


    public function setEntityFromJson($json)
    {
        parent::setEntityFromJson($json);

        $this->path = $json->path ?? null;
        $this->size = $json->size ?? null;
        $this->mimeType = $json->mimetype ?? null;
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
     * @return Image
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param mixed $mimeType
     * @return Image
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     * @return Image
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

}

<?php

namespace App\Entity;

use App\AdComponents\AdComponentInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image extends Component implements AdComponentInterface
{

    use MediaComponentTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"ad"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Choice(choices={"jpg", "png"}, message="MimeType must be 'jpg' or 'png'")
     * @Assert\NotBlank(message="This field is required")
     * @Groups({"ad"})
     */
    private $mimeType;

    /**
     * @Groups({"ad"})
     */
    private $type = "image";

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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Image
     */
    public function setType(string $type): Image
    {
        $this->type = $type;
        return $this;
    }

}

<?php

namespace App\Entity;

use App\AdComponents\AdComponentInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 */
class Video extends Component implements AdComponentInterface
{

    use MediaComponentTrait;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank(message="This field is required")
     * @Assert\Choice(choices={"mp4", "webm"}, message="MimeType must be 'mp4' or 'webm'")
     * @Groups({"ad"})
     */
    private $mimeType;

    /**
     * @Groups({"ad"})
     */
    private $type = "video";

    public function setEntityFromJson($json)
    {
        parent::setEntityFromJson($json);

        $this->path = $json->path ?? null;
        $this->size = $json->size ?? null;
        $this->mimeType = $json->mimetype ?? null;
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
     * @return Video
     */
    public function setType(string $type): Video
    {
        $this->type = $type;
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
     * @return Video
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
        return $this;
    }

}

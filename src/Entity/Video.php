<?php

namespace App\Entity;

use App\AdComponents\AdComponentInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 */
class Video extends Component implements AdComponentInterface
{

    use MediaComponentTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank(message="This field is required")
     * @Assert\Choice(choices={"mp4", "webm"}, message="MimeType must be 'mp4' or 'webm'")
     */
    private $mimeType;

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
     * @return Video
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}

<?php

namespace App\Entity;

use App\AdComponents\AdComponentInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TextRepository")
 */
class Text extends Component implements AdComponentInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"ad"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=140)
     * @Assert\Length(min=1, max=140, minMessage="The min length is 1", maxMessage="The max length is 140")
     * @Assert\NotBlank(message="This field is required")
     * @Groups({"ad"})
     */
    private $text;

    /**
     * @Groups({"ad"})
     */
    private $type = "text";

    public function setEntityFromJson($json)
    {
        parent::setEntityFromJson($json);
        $this->text = $json->text ?? null;
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
     * @return Text
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     * @return Text
     */
    public function setText($text)
    {
        $this->text = $text;
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
     * @return Text
     */
    public function setType(string $type): Text
    {
        $this->type = $type;
        return $this;
    }
}

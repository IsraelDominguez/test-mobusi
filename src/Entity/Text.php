<?php

namespace App\Entity;

use App\AdComponents\AdComponentInterface;
use App\AdComponents\AdComponentTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TextRepository")
 */
class Text extends Component implements AdComponentInterface
{
    use AdComponentTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=140)
     * @Assert\Length(min=1, max=140, minMessage="The min length is 1", maxMessage="The max length is 140")
     * @Assert\NotBlank(message="This field is required")
     */
    private $text;

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
}

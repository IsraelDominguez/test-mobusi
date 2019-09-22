<?php namespace App\Entity;

trait MediaComponentTrait
{
    /**
     * @ORM\Column(type="string", length=500)
     * @Assert\Type("string")
     * @Assert\Url
     * @Assert\NotBlank(message="This field is required")
     * @Groups({"ad"})
     */
    private $path;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="This field is required")
     * @Assert\Type("int")
     * @Groups({"ad"})
     */
    private $size;

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     * @return Video
     */
    public function setPath($path)
    {
        $this->path = $path;
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
     * @return Video
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }
}
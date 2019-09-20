<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image extends Component
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Choice(choices={"jpg", "png"}, message="MimeType must be 'jpg' or 'png'")
     */
    private $mimeType;

    /**
     * @ORM\Column(type="float")
     */
    private $size;

}

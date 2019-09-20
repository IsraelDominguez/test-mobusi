<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 */
class Video
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
     * @Assert\Choice(choices={"mp4", "webm"}, message="MimeType must be 'mp4' or 'webm'")
     */
    private $mimeType;

    /**
     * @ORM\Column(type="float")
     */
    private $size;
}

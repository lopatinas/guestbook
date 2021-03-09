<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="App\Repository\FileRepository")
 * @ORM\HasLifecycleCallbacks
 */
class File
{
    /**
     * @var integer|null
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected ?int $id;

    /**
     * @var Message|null
     * @ORM\ManyToOne(targetEntity="App\Entity\Message")
     */
    protected ?Message $message;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255)
     */
    protected ?string $fileName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255)
     */
    protected ?string $path;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Message|null
     */
    public function getMessage(): ?Message
    {
        return $this->message;
    }

    /**
     * @param Message|null $message
     *
     * @return File
     */
    public function setMessage(?Message $message): File
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * @param string|null $fileName
     *
     * @return File
     */
    public function setFileName(?string $fileName): File
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     *
     * @return File
     */
    public function setPath(?string $path): File
    {
        $this->path = $path;

        return $this;
    }
}

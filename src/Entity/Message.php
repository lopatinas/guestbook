<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

/**
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Message
{
    /**
     * @var integer|null
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    protected ?int $id;

    /**
     * @var Message|null
     * @ORM\ManyToOne(targetEntity="App\Entity\Message", inversedBy="children")
     */
    protected ?Message $parent;

    /**
     * @var Message[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="parent")
     */
    protected $children;

    /**
     * @var User|null
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    protected ?User $author;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=1000)
     */
    protected ?string $text;

    /**
     * @var File[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\File", mappedBy="message")
     */
    protected $attachments;

    /**
     * @var DateTimeImmutable|null
     * @ORM\Column(type="datetime_immutable")
     */
    protected ?DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->attachments = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new DateTimeImmutable();
    }

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
    public function getParent(): ?Message
    {
        return $this->parent;
    }

    /**
     * @param Message|null $parent
     *
     * @return Message
     */
    public function setParent(?Message $parent): Message
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Message[]|ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Message $child
     *
     * @return $this
     */
    public function addChild(Message $child): Message
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
        }

        return $this;
    }

    /**
     * @param Message $child
     *
     * @return $this
     */
    public function removeChild(Message $child): Message
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
        }

        return $this;
    }

    /**
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User|null $author
     *
     * @return Message
     */
    public function setAuthor(?User $author): Message
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     *
     * @return Message
     */
    public function setText(?string $text): Message
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return File[]|ArrayCollection
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param File $file
     *
     * @return $this
     */
    public function addAttachment(File $file): Message
    {
        if (!$this->attachments->contains($file)) {
            $this->attachments->add($file);
        }

        return $this;
    }

    /**
     * @param File $file
     *
     * @return $this
     */
    public function removeAttachment(File $file): Message
    {
        if ($this->attachments->contains($file)) {
            $this->attachments->removeElement($file);
        }

        return $this;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeImmutable|null $createdAt
     *
     * @return Message
     */
    public function setCreatedAt(?DateTimeImmutable $createdAt): Message
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}

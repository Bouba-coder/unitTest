<?php

namespace App\Entity;

use App\Repository\TasksRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TasksRepository::class)
 */
class Tasks
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $create_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_users;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="todolist")
     * @ORM\JoinColumn(nullable=false)
     */
    private $app_user;

    public function __construct(string $name, string $content, \DateTimeInterface $create_date)
    {
        $this->name = $name;
        $this->content = $content;
        $this->create_date = $create_date;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->create_date;
    }

    public function setCreateDate(\DateTimeInterface $create_date): self
    {
        $this->create_date = $create_date;

        return $this;
    }

    public function getIdUsers(): ?int
    {
        return $this->id_users;
    }

    public function setIdUsers(int $id_users): self
    {
        $this->id_users = $id_users;

        return $this;
    }

    //isvalidName
    public function isValidName(): bool
    {
        return !empty($this->name) && is_string($this->name);
    }

    public function isValidNameString(): bool
    {
        return is_string($this->name);
    }

    //isvalidContent
    public function isValidContent(): bool
    {
        return !empty($this->content) && is_string($this->content);
    }

    public function getAppUser(): ?User
    {
        return $this->app_user;
    }

    public function setAppUser(?User $app_user): self
    {
        $this->app_user = $app_user;

        return $this;
    }




}

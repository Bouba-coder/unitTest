<?php

namespace App\Entity;

use Carbon\Carbon;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private Carbon $birthday;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="app_user", orphanRemoval=true)
     */
    private $todolist;

    public function __construct(string $firstname, string $lastname, string $email, string $password, Carbon $birthday)
    {
        $this->todolist = new ArrayCollection();

        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->birthday = $birthday;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }
    public function isValid(): bool
    {
        return !empty($this->email)
            && filter_var($this->email, FILTER_VALIDATE_EMAIL)
            && !empty($this->firstname)
            && !empty($this->lastname)
            && !empty($this->password)
            && strlen($this->password) > 7
            && strlen($this->password) < 40
            && !is_null($this->birthday)
            && $this->birthday->addYears(13)->isBefore(Carbon::now());
    }

    /**
     * @return Collection|Task[]
     */
    public function getTodolist(): Collection
    {
        return $this->todolist;
    }

    public function addTodolist(Tasks $todolist): self
    {
        if (!$this->todolist->contains($todolist))
        {
            $this->todolist[] = $todolist;
            $todolist->setAppUser($this);
        }

        return $this;
    }

    public function removeTodolist(Tasks $todolist): self
    {
        if ($this->todolist->removeElement($todolist))
        {
            // set the owning side to null (unless already changed)
            if ($todolist->getAppUser() === $this) {
                $todolist->setAppUser(null);
            }
        }

        return $this;
    }

    public function isUniqueTasksTitle(){
       
        $taken = array();
        foreach($this->getTodolist() as $key => $item)
        {
          if(!in_array($item->getName(), $taken))
          {
            $taken[] = $item->getName();
          }
        }
        return sizeof($taken) == sizeof($this->getTodolist());
    }
    
}

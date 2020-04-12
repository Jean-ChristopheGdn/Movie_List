<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserListRepository")
 */
class UserList
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $list_name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="userLists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Movies", inversedBy="userLists")
     */
    private $user_list_movies;

    public function __construct()
    {
        $this->user_list_movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getListName(): ?string
    {
        return $this->list_name;
    }

    public function setListName(string $list_name): self
    {
        $this->list_name = $list_name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection|Movies[]
     */
    public function getUserListMovies(): Collection
    {
        return $this->user_list_movies;
    }

    public function addUserListMovie(Movies $userListMovie): self
    {
        if (!$this->user_list_movies->contains($userListMovie)) {
            $this->user_list_movies[] = $userListMovie;
        }

        return $this;
    }

    public function removeUserListMovie(Movies $userListMovie): self
    {
        if ($this->user_list_movies->contains($userListMovie)) {
            $this->user_list_movies->removeElement($userListMovie);
        }

        return $this;
    }
}

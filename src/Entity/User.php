<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    public function __construct() {
        $this->created = new \DateTime('now');
        $this->userRoles = new ArrayCollection();
        $this->warnings = new ArrayCollection();
        $this->bans = new ArrayCollection();
        $this->avatar = 'default-avatar.png';
        $this->threads = new ArrayCollection();
        $this->replies = new ArrayCollection();
        $this->sessions = new ArrayCollection();
    }
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UserRole", inversedBy="users")
     */
    private $userRoles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserRole")
     * @ORM\JoinColumn(nullable=false)
     */
    private $primaryRole;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dob;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastIpAddress;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Warning", mappedBy="receiver", orphanRemoval=true)
     */
    private $warnings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ban", mappedBy="receiver", orphanRemoval=true)
     */
    private $bans;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Thread", mappedBy="author")
     */
    private $threads;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reply", mappedBy="author")
     */
    private $replies;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Session", mappedBy="user", orphanRemoval=true)
     */
    private $sessions;

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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return [
            'ROLE_USER',
        ($this->getPrimaryRole()->getName() != "User") ? strtoupper('ROLE_' . $this->getPrimaryRole()->getName()) : ''
        ];
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|UserRole[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(UserRole $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->addUser($this);
        }

        return $this;
    }

    public function removeUserRole(UserRole $userRole): self
    {
        if ($this->userRoles->contains($userRole)) {
            $this->userRoles->removeElement($userRole);
            $userRole->removeUser($this);
        }

        return $this;
    }

    public function getPrimaryRole(): ?UserRole
    {
        return $this->primaryRole;
    }

    public function setPrimaryRole(?UserRole $primaryRole): self
    {
        $this->primaryRole = $primaryRole;

        return $this;
    }

    public function getPermissions() {
        $_permissions = [];

        foreach($this->getUserRoles() as $role) {
            foreach($role->getPermissions() as $permission) {
                $_permissions[] = $permission->getName();
            }
        }

        return $_permissions;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(?\DateTimeInterface $dob): self
    {
        $this->dob = $dob;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getLastIpAddress(): ?string
    {
        return $this->lastIpAddress;
    }

    public function setLastIpAddress(?string $lastIpAddress): self
    {
        $this->lastIpAddress = $lastIpAddress;

        return $this;
    }

    /**
     * @return Collection|Warning[]
     */
    public function getWarnings(): Collection
    {
        return $this->warnings;
    }

    public function addWarning(Warning $warning): self
    {
        if (!$this->warnings->contains($warning)) {
            $this->warnings[] = $warning;
            $warning->setReceiver($this);
        }

        return $this;
    }

    public function removeWarning(Warning $warning): self
    {
        if ($this->warnings->contains($warning)) {
            $this->warnings->removeElement($warning);
            // set the owning side to null (unless already changed)
            if ($warning->getReceiver() === $this) {
                $warning->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ban[]
     */
    public function getBans(): Collection
    {
        return $this->bans;
    }

    public function addBan(Ban $ban): self
    {
        if (!$this->bans->contains($ban)) {
            $this->bans[] = $ban;
            $ban->setReceiver($this);
        }

        return $this;
    }

    public function removeBan(Ban $ban): self
    {
        if ($this->bans->contains($ban)) {
            $this->bans->removeElement($ban);
            // set the owning side to null (unless already changed)
            if ($ban->getReceiver() === $this) {
                $ban->setReceiver(null);
            }
        }

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Thread[]
     */
    public function getThreads(): Collection
    {
        return $this->threads;
    }

    public function addThread(Thread $thread): self
    {
        if (!$this->threads->contains($thread)) {
            $this->threads[] = $thread;
            $thread->setAuthor($this);
        }

        return $this;
    }

    public function removeThread(Thread $thread): self
    {
        if ($this->threads->contains($thread)) {
            $this->threads->removeElement($thread);
            // set the owning side to null (unless already changed)
            if ($thread->getAuthor() === $this) {
                $thread->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reply[]
     */
    public function getReplies(): Collection
    {
        return $this->replies;
    }

    public function addReply(Reply $reply): self
    {
        if (!$this->replies->contains($reply)) {
            $this->replies[] = $reply;
            $reply->setAuthor($this);
        }

        return $this;
    }

    public function removeReply(Reply $reply): self
    {
        if ($this->replies->contains($reply)) {
            $this->replies->removeElement($reply);
            // set the owning side to null (unless already changed)
            if ($reply->getAuthor() === $this) {
                $reply->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setUser($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->contains($session)) {
            $this->sessions->removeElement($session);
            // set the owning side to null (unless already changed)
            if ($session->getUser() === $this) {
                $session->setUser(null);
            }
        }

        return $this;
    }
}

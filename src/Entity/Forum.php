<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ForumRepository")
 */
class Forum
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserRole")
     */
    private $minRole;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="forums")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Forum", inversedBy="subforums")
     */
    private $subforum;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Forum", mappedBy="subforum")
     */
    private $subforums;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Thread", mappedBy="forum", orphanRemoval=true)
     */
    private $threads;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->subforums = new ArrayCollection();
        $this->created = new \DateTime('now');
        $this->threads = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getMinRole(): ?UserRole
    {
        return $this->minRole;
    }

    public function setMinRole(?UserRole $minRole): self
    {
        $this->minRole = $minRole;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSubforum(): ?self
    {
        return $this->subforum;
    }

    public function setSubforum(?self $subforum): self
    {
        $this->subforum = $subforum;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSubforums(): Collection
    {
        return $this->subforums;
    }

    public function addSubforum(self $subforum): self
    {
        if (!$this->subforums->contains($subforum)) {
            $this->subforums[] = $subforum;
            $subforum->setSubforum($this);
        }

        return $this;
    }

    public function removeSubforum(self $subforum): self
    {
        if ($this->subforums->contains($subforum)) {
            $this->subforums->removeElement($subforum);
            // set the owning side to null (unless already changed)
            if ($subforum->getSubforum() === $this) {
                $subforum->setSubforum(null);
            }
        }

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
            $thread->setForum($this);
        }

        return $this;
    }

    public function removeThread(Thread $thread): self
    {
        if ($this->threads->contains($thread)) {
            $this->threads->removeElement($thread);
            // set the owning side to null (unless already changed)
            if ($thread->getForum() === $this) {
                $thread->setForum(null);
            }
        }

        return $this;
    }

    public function getLatestThread(): ?Thread {

        $thread_times = [];
        $threadlist = [];

        foreach ($this->getThreads() as $thread) {
            $thread_times[] = $thread->getCreated()->getTimestamp();
            $threadlist[$thread->getCreated()->getTimestamp()] = $thread;
        }

        if(count($threadlist) > 0) {
            asort($thread_times);

            $latest_thread = array_reverse($thread_times);
            return $threadlist[$latest_thread[0]];
        }

        return null;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}

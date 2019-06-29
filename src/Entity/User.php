<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Veuillez indiquer un email !")
     * @Assert\Email(message="Veuillez indiquer un format d'email correct !")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Veuillez indiquer un mot de passe !", groups={"registration"})
     * @Assert\Length(
     *     min="6",
     *     minMessage="Votre mot de passe doit contenir au moins 8 caractères !",
     *     max="12",
     *     maxMessage="Votre mot de passe doit contenir au maximum 12 caractères !",
     *     groups={"registration"}
     * )
     */
    private $password;

    /**
     *  @Assert\EqualTo(
     *     propertyPath="password",
     *     message="Vos 2 mot de passe ne correspondent pas !"
     * )
     */
    public $passwordConfirm;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer un prénom !")
     * @Assert\Length(
     *     min="2",
     *     max="50",
     *     minMessage="Votre prénom doit faire au minimum 2 caractères !",
     *     maxMessage="Votre prénom doit faire au maximum 50 caractères !"
     * )
     * @Assert\Regex(
     *     pattern = "/^[a-z\-îïâéèç]+$/i",
     *     message="Le prénom doit contenir que des lettres !"
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer un nom !")
     * @Assert\Length(
     *     min="2",
     *     max="50",
     *     minMessage="Votre nom doit faire au minimum 2 caractères !",
     *     maxMessage="Votre nom doit faire au maximum 50 caractères !"
     * )
     * @Assert\Regex(
     *     pattern = "/^[a-z\-îïâéèç]+$/i",
     *     message="Le nom doit contenir que des lettres !"
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(message="Veuillez indiquer une URL valide !")
     */
    private $avatar;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Properties", mappedBy="author", orphanRemoval=true)
     */
    private $properties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comments", mappedBy="author", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContactForProperty", mappedBy="author", orphanRemoval=true)
     */
    private $contactForProperties;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $active;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->contactForProperties = new ArrayCollection();
    }

    /**
     * Initialize Automatically CreatedAt when User Register
     * @ORM\PrePersist()
     * @throws \Exception
     */
    public function initializeCreatedAt()
    {
        if(empty($this->createdAt))
        {
            $this->createdAt = new \DateTime();
        }
    }

    /**
     * Generate a slug for User
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @return string
     */
    public function initializeSlug()
    {
        $slugify = new Slugify();

        if(empty($this->slug))
        {
            $this->slug = $slugify->slugify($this->fullName());
        }
    }

    /**
     * LastName and FirstName
     * @return string
     */
    public function fullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * Set Active in false
     * @ORM\PrePersist()
     * @return void
     */
    public function initializeUserActive()
    {
        if(empty($this->active))
        {
            $this->active = false;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
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

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Properties[]
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Properties $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
            $property->setAuthor($this);
        }

        return $this;
    }

    public function removeProperty(Properties $property): self
    {
        if ($this->properties->contains($property)) {
            $this->properties->removeElement($property);
            // set the owning side to null (unless already changed)
            if ($property->getAuthor() === $this) {
                $property->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ContactForProperty[]
     */
    public function getContactForProperties(): Collection
    {
        return $this->contactForProperties;
    }

    public function addContactForProperty(ContactForProperty $contactForProperty): self
    {
        if (!$this->contactForProperties->contains($contactForProperty)) {
            $this->contactForProperties[] = $contactForProperty;
            $contactForProperty->setAuthor($this);
        }

        return $this;
    }

    public function removeContactForProperty(ContactForProperty $contactForProperty): self
    {
        if ($this->contactForProperties->contains($contactForProperty)) {
            $this->contactForProperties->removeElement($contactForProperty);
            // set the owning side to null (unless already changed)
            if ($contactForProperty->getAuthor() === $this) {
                $contactForProperty->setAuthor(null);
            }
        }

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}

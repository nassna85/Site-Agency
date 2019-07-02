<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropertiesRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Properties
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
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer une ville !")
     * @Assert\Regex(
     *     pattern="/^[a-z\-îïâéèç ]+$/i",
     *     htmlPattern="/^[a-zA-Z\-îïâéèç ]+$/",
     *     message="Le champ ville ne doit contenir que des lettres"
     * )
     * @Assert\Length(
     *     min="2",
     *     max="255",
     *     minMessage="Le champ ville doit contenir au minimum 2 caractères !",
     *     maxMessage="Le champ ville doit contenir au maximum 255 caractères !"
     * )
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer une ville !")
     * @Assert\Length(
     *     min="5",
     *     max="255",
     *     minMessage="Votre adresse doit faire au minimum 2 caractères !",
     *     maxMessage="Votre adresse doit faire au maximum 255 caractères !"
     * )
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer un code postale !")
     * @Assert\Length(
     *     min="4",
     *     max="10",
     *     minMessage="Le code postale doit contenir au minimum 4 caractères !",
     *     maxMessage="Le code postale doit contenir au maximum 10 caractères !"
     * )
     */
    private $postalCode;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez indiquer un prix !")
     * @Assert\Regex(
     *     pattern = "/^[0-9\.]+$/",
     *     message="Le prix doit être un chiffre !"
     * )
     * @Assert\GreaterThan(
     *     value="0",
     *     message="Le prix doit être supérieur à 0 !"
     * )
     */
    private $price;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $sold;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez indiquer une surface en m2 !")
     * @Assert\Regex(
     *     pattern = "/^[0-9]+$/",
     *     message="La surface doit être un chiffre !"
     * )
     * @Assert\GreaterThan(
     *     value="0",
     *     message="La surface doit être supérieur à 0 !"
     * )
     */
    private $area;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez indiquer le nombre de chambre !")
     * @Assert\Regex(
     *     pattern = "/^[0-9]+$/",
     *     message="Le nombre de chambres doit être un chiffre !"
     * )
     * @Assert\GreaterThan(
     *     value="0",
     *     message="Le nombre de chambres doit être supérieur à 0 !"
     * )
     */
    private $bedrooms;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez indiquer le nombre de douche !")
     * @Assert\Regex(
     *     pattern = "/^[0-9]+$/",
     *     message="Le nombre de douches doit être un chiffre !"
     * )
     * @Assert\GreaterThan(
     *     value="0",
     *     message="Le nombre de douches doit être supérieur à 0 !"
     * )
     */
    private $shower;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez ajouter une image principale !")
     * @Assert\Url(
     *     protocols={"http", "https"},
     *     message="Veuillez indiquer une URL valide !"
     * )
     */
    private $coverImage;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Veuillez indiquer une description de votre bien !")
     * @Assert\Length(
     *     min="50",
     *     minMessage="Votre description doit contenir au minimum 50 caractères !"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $approved;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $action;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="property", orphanRemoval=true)
     * @Assert\Valid()
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContactForProperty", mappedBy="property", orphanRemoval=true)
     */
    private $contactForProperties;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Options", inversedBy="properties")
     */
    private $options;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->contactForProperties = new ArrayCollection();
        $this->options = new ArrayCollection();
    }

    /**
     * Initialize CreatedAt automatically
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
     * Initialize Sold Property in false
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function initializeSold()
    {
        if(empty($this->sold))
        {
            $this->sold = false;
        }
    }

    /**
     * Initialize Approved in false
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function initializeApproved()
    {
        if(empty($this->approved))
        {
            $this->approved = false;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function setArea(int $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getShower(): ?int
    {
        return $this->shower;
    }

    public function setShower(int $shower): self
    {
        $this->shower = $shower;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getApproved(): ?bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved): self
    {
        $this->approved = $approved;

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

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProperty($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getProperty() === $this) {
                $image->setProperty(null);
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
            $contactForProperty->setProperty($this);
        }

        return $this;
    }

    public function removeContactForProperty(ContactForProperty $contactForProperty): self
    {
        if ($this->contactForProperties->contains($contactForProperty)) {
            $this->contactForProperties->removeElement($contactForProperty);
            // set the owning side to null (unless already changed)
            if ($contactForProperty->getProperty() === $this) {
                $contactForProperty->setProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Options[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Options $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
        }

        return $this;
    }

    public function removeOption(Options $option): self
    {
        if ($this->options->contains($option)) {
            $this->options->removeElement($option);
        }

        return $this;
    }
}

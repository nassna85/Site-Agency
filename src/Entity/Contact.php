<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer un nom !")
     * @Assert\Length(
     *     min="2",
     *     max="50",
     *     minMessage="Votre nom doit comporter au moins 2 caractères !",
     *     maxMessage="Votre nom doit comporter au maximum 50 caractères !"
     * )
     * @Assert\Regex(
     *     pattern="/^[a-z\-îïâéèç ]+$/i",
     *     message="Le nom doit comporter uniquement des lettres !"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer une adresse email !")
     * @Assert\Email(message="Veuillez indiquer une adresse email valide !")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern="/[0-9]+$/i",
     *     message="Entrez un numéro valide. '488896745' Pas d'espaces ni de séparations !"
     * )
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Veuillez indiquer un message !")
     * @Assert\Length(
     *     min="10",
     *     minMessage="Votre message doit comporter au moins 10 caractères !"
     * )
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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
}

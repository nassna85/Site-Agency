<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class PropertiesSearch
{

    private $action;

    private $type;

    /**
     * @Assert\Regex(
     *     pattern="/^[0-9\.]+$/",
     *     message="Le prix maximum doit être un chiffre"
     * )
     * @var
     */
    private $maxPrice;

    /**
     * @Assert\Regex(
     *     pattern="/^[0-9\.]+$/",
     *     message="Le nombre de chambres minimum doit être un chiffre"
     * )
     * @var
     */
    private $minBedroom;

    /**
     * @Assert\Regex(
     *     pattern="/^[0-9\.]+$/",
     *     message="La surface minimum doit être un chiffre"
     * )
     * @var
     */
    private $minArea;

    public $properties;


    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
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

    public function getMaxPrice(): ?string
    {
        return $this->maxPrice;
    }

    public function setMaxPrice(string $maxPrice): self
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    public function getMinBedroom(): ?string
    {
        return $this->minBedroom;
    }

    public function setMinBedroom(string $minBedroom): self
    {
        $this->minBedroom = $minBedroom;

        return $this;
    }

    public function getMinArea(): ?string
    {
        return $this->minArea;
    }

    public function setMinArea(string $minArea): self
    {
        $this->minArea = $minArea;

        return $this;
    }
}

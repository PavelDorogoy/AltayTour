<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TourRepository")
 * @ORM\Table(name="`tours`")
 */
class Tour
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $countPerson;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $instructor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TouristRoute")
     * @ORM\JoinColumn(nullable=false)
     */
    private $route;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCountPerson(): ?int
    {
        return $this->countPerson;
    }

    public function setCountPerson(int $countPerson): self
    {
        $this->countPerson = $countPerson;

        return $this;
    }

    public function getInstructor(): ?User
    {
        return $this->instructor;
    }

    public function setInstructor(?User $instructor): self
    {
        $this->instructor = $instructor;

        return $this;
    }

    public function getRoute(): ?TouristRoute
    {
        return $this->route;
    }

    public function setRoute(?TouristRoute $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getRoute()->getName().":  ".$this->getDate()->format('d.m.Y');
    }
}

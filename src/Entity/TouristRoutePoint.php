<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TouristRoutePointRepository")
 * @ORM\Table(name="`route_points`")
 */
class TouristRoutePoint
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $day;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lon;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TouristRoute")
     * @ORM\JoinColumn(nullable=false)
     */
    private $route;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(int $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

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

    public function getLon(): ?float
    {
        return $this->lon;
    }

    public function setLon(?float $lon): self
    {
        $this->lon = $lon;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): self
    {
        $this->lat = $lat;

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
}

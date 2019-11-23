<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TouristRoutePhotoAlbumRepository")
 * @ORM\Table(name="`route_photo_albums`")
 */
class TouristRoutePhotoAlbum
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $name;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $photosJSON = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TouristRoute")
     * @ORM\JoinColumn(nullable=false)
     */
    private $route;

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

    public function getPhotosJSON(): ?array
    {
        return $this->photosJSON;
    }

    public function setPhotosJSON(?array $photosJSON): self
    {
        $this->photosJSON = $photosJSON;

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

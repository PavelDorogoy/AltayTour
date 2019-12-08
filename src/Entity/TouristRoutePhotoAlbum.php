<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TouristRoutePhotoAlbumRepository")
 * @ORM\Table(name="`route_photo_albums`")
 * @Vich\Uploadable
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
     * @ORM\ManyToOne(targetEntity="App\Entity\TouristRoute")
     * @ORM\JoinColumn(nullable=false)
     */
    private $route;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TouristRoutePhotoAlbumImage", cascade={"persist"})
     * @ORM\JoinTable(name="album_images",
     *      joinColumns={@ORM\JoinColumn(name="album_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
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

    public function getRoute(): ?TouristRoute
    {
        return $this->route;
    }

    public function setRoute(?TouristRoute $route): self
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @return Collection|TouristRoutePhotoAlbumImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }
}

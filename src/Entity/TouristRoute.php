<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TouristRouteRepository")
 * @ORM\Table(name="`routes`")
 * @Vich\Uploadable
 */
class TouristRoute
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $annotation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="float")
     */
    private $distance;

    /**
     * @ORM\Column(type="integer")
     */
    private $days;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TouristRouteType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bg_logo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @var File
     * @Vich\UploadableField(mapping="upload_images", fileNameProperty="logo")
     * @Assert\Image(
     *     minWidth = 400,
     *     minHeight = 400,
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/png"},
     *     mimeTypesMessage = "Картинка должны быть в одном из форматов: JPEG, JPG, PNG",
     *     maxSize = "5Mi"
     * )
     */
    private $imageFile;
    /**
     * @var File
     * @Vich\UploadableField(mapping="upload_images", fileNameProperty="bg_logo")
     * @Assert\Image(
     *     minWidth = 600,
     *     minHeight = 400,
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/png"},
     *     mimeTypesMessage = "Картинка должны быть в одном из форматов: JPEG, JPG, PNG",
     *     maxSize = "10Mi"
     * )
     */
    private $bgImageFile;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAnnotation(): ?string
    {
        return $this->annotation;
    }

    public function setAnnotation(string $annotation): self
    {
        $this->annotation = $annotation;

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

    public function getDistance(): ?float
    {
        return $this->distance;
    }

    public function setDistance(float $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getDays(): ?int
    {
        return $this->days;
    }

    public function setDays(int $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getType(): ?TouristRouteType
    {
        return $this->type;
    }

    public function setType(?TouristRouteType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getBgLogo(): ?string
    {
        return $this->bg_logo;
    }

    public function setBgLogo(?string $bg_logo): self
    {
        $this->bg_logo = $bg_logo;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(File $imageFile): self
    {
        if ($imageFile) {
            $this->updatedAt = new \DateTime('now');
        }
        $this->imageFile = $imageFile;

        return $this;
    }

    public function getBgImageFile(): ?File
    {
        return $this->bgImageFile;
    }

    public function setBgImageFile(File $bgImageFile): self
    {
        if ($bgImageFile) {
            $this->updatedAt = new \DateTime('now');
        }
        $this->bgImageFile = $bgImageFile;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}

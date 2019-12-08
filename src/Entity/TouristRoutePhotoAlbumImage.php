<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TouristRoutePhotoAlbumImageRepository")
 * @ORM\Table(name="`route_photo_albums_image`")
 * @Vich\Uploadable
 */
class TouristRoutePhotoAlbumImage
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
    private $image;

    /**
     * @var File
     * @Vich\UploadableField(mapping="upload_images", fileNameProperty="image")
     * @Assert\Image(
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/png"},
     *     mimeTypesMessage = "Картинка должны быть в одном из форматов: JPEG, JPG, PNG"
     * )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(File $imageFile = null): self
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }
}

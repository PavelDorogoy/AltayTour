<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipmentReservationRepository")
 * @ORM\Table(name="`equipment_reservations`")
 */
class EquipmentReservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TourReservation")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $reservation_tour;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $equipment;

    /**
     * @ORM\Column(type="integer")
     */
    private $count;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservationTour(): ?TourReservation
    {
        return $this->reservation_tour;
    }

    public function setReservationTour(?TourReservation $reservation_tour): self
    {
        $this->reservation_tour = $reservation_tour;

        return $this;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(?Equipment $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }
}

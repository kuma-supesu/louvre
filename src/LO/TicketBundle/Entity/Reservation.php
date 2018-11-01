<?php
namespace LO\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reservation
 * @ORM\Entity
 * @ORM\Table(name="reservation")
 */

class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *  @Assert\Date()
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var \int
     *
     * @ORM\Column(name="totalTicket", type="integer")
     */
    private $totalTicket;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set booking
     *
     * @param Assert\Date $date
     *
     * @return reservation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get booking
     *
     * @return Assert\Date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set totalTicket
     *
     * @param integer $totalTicket
     *
     * @return reservation
     */
    public function setTotalTicket($totalTicket)
    {
        $this->totalTicket = $totalTicket;

        return $this;
    }

    /**
     * Get totalTicket
     *
     * @return integer
     */
    public function getTotalTicket()
    {
        return $this->totalTicket;
    }
}
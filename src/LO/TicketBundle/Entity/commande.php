<?php

namespace LO\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="LO\TicketBundle\Repository\commandeRepository")
 */
class commande
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
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date")
     */
    private $birthday;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="booking", type="date")
     */
    private $booking;


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
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return commande
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

        /**
     * Set nbTicket
     *
     * @param integer $nbTicket
     *
     * @return commande
     */
    public function setNbTicket($nbTicket)
    {
        $this->nbTicket = $nbTicket;

        return $this;
    }

    /**
     * Get nbTicket
     *
     * @return int
     */
    public function getNbTicket()
    {
        return $this->nbTicket;
    }

    /**
     * Set booking
     *
     * @param \DateTime $booking
     *
     * @return commande
     */
    public function setBooking($booking)
    {
        $this->booking = $booking;

        return $this;
    }

    /**
     * Get booking
     *
     * @return \DateTime
     */
    public function getBooking()
    {
        return $this->booking;
    }

    /**
     * Set ticket
     *
     * @param \LO\TicketBundle\Entity\Ticket $ticket
     *
     * @return commande
     */
}

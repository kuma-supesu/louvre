<?php

namespace LO\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use LO\TicketBundle\Entity\Ticket as Ticket;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commande
 * @ORM\Entity
 * @ORM\Table(name="commande")
 */
class Commande
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
     *  @Assert\DateTime()
     *
     * @ORM\Column(name="booking", type="datetime")
     */
    private $booking;

    /**
     * @var \string
     *
     * @ORM\Column(name="booking_code", type="string")
     */
    private $booking_code;

    /**
     * @var \string
     *
     * @ORM\Column(name="email", type="string")
     */
    private $email;

    /**
     * @var \int
     *
     * @ORM\Column(name="ticket_number", type="integer")
     */
    private $ticket_number;

    /**
     * @ORM\OneToMany(targetEntity="Ticket", mappedBy="commande", cascade={"persist", "remove"})
     */
    private $ticket;

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
     * @param Assert\DateTime $booking
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
     * @return Assert\DateTime
     */
    public function getBooking()
    {
        return $this->booking;
    }

    /**
     * Set bookingCode
     *
     * @param string $bookingCode
     *
     * @return commande
     */
    public function setBookingCode($bookingCode)
    {
        $this->booking_code = $bookingCode;

        return $this;
    }

    /**
     * Get bookingCode
     *
     * @return string
     */
    public function getBookingCode()
    {
        return $this->booking_code;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return commande
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set ticketNumber
     *
     * @param integer $ticketNumber
     *
     * @return commande
     */
    public function setTicketNumber($ticketNumber)
    {
        $this->ticket_number = $ticketNumber;

        return $this;
    }

    /**
     * Get ticketNumber
     *
     * @return integer
     */
    public function getTicketNumber()
    {
        return $this->ticket_number;
    }

    /**
     * Set ticket
     *
     * @param \LO\TicketBundle\Entity\Ticket $ticket
     *
     * @return Ticket
     */
    public function setTicket(Ticket $ticket = null)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return \LO\TicketBundle\Entity\Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }
}

<?php

namespace LO\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use LO\TicketBundle\Entity\Ticket as Ticket;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @Assert\Date()
     *
     * @ORM\Column(name="booking", type="date")
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
     *
     * @Assert\Email(
     *     message = "Cet Email '{{ value }}' n'est pas valide",
     *     checkMX = true
     *     )
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="day", type="boolean")
     */
    private $day;

    /**
     * @var \int
     * @Assert\Range(
     *      min = 1,
     *      max = 100,
     *      minMessage = "Vous devez commander {{ limit }} ticket minimum",
     *      maxMessage = "Vous ne pouvez pas commander plus de {{ limit }} tickets"
     * )
     * @ORM\Column(name="ticket_number", type="integer")
     */
    private $ticket_number;

    /**
     * @var integer
     *
     * @ORM\Column(name="paid", type="integer")
     */
    private $paid;

    /**
     * @ORM\OneToMany(targetEntity="Ticket", mappedBy="commande", cascade={"persist", "remove"})
     */
    private $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

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
     * @param Assert\Date $booking
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
     * Get booking
     *
     * @return Assert\string
     */
    public function getBookingISO8601()
    {
        return $this->booking->format('d-m-Y');
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
     * Set day
     *
     * @param boolean $day
     *
     * @return Ticket
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return boolean
     */
    public function getDay()
    {
        return $this->day;
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
     * Set paid
     *
     * @param integer $paid
     *
     * @return Ticket
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return integer
     */
    public function getPaid()
    {
        return $this->paid;
    }


    /**
     * Set ticket
     *
     * @param \LO\TicketBundle\Entity\Ticket $ticket
     *
     * @return Ticket
     */
    public function addTicket(Ticket $ticket = null)
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
        }

        $ticket->setCommande($this);
        $this->tickets->add($ticket);
        return $this;
    }

    /**
     * Get ticket
     *
     * @return \LO\TicketBundle\Entity\Ticket
     */
    public function getTickets()
    {
        if ($this->tickets->isEmpty()) {
        return [];
    }
        return $this->tickets->toArray();
    }

    public function getReduc()
    {
        $tickets = $this->getTickets();
        foreach ($tickets as $reduc) {
            return $reduc->getReduc();
        }
    }

    public function getTotal()
    {
        $total = 0;
        $tickets = $this->getTickets();
        foreach ($tickets as $ticket) {
            $total += $ticket->getTarif();
        }
            return $total;
    }
}
<?php

namespace LO\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use LO\TicketBundle\Entity\Commande as Commande;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="LO\TicketBundle\Repository\TicketRepository")
 */
class Ticket
{

    /**
     * @ORM\ManyToOne(targetEntity="LO\TicketBundle\Entity\Commande")
     * @ORM\JoinColumn(nullable=true)
*/
    private $commande;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="f_name", type="string", length=255)
     */
    private $fname;

    /**
     * @var string
     *
     * @ORM\Column(name="l_name", type="string", length=255)
     */
    private $lname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date")
     */
    private $birthday;

    /**
     * @var array
     *
     * @ORM\Column(name="country", type="array")
     */
    private $country;

    /**
     * @var boolean
     *
     * @ORM\Column(name="reduc", type="boolean")
     */
    private $reduc;

    /**
     * @var boolean
     *
     * @ORM\Column(name="day", type="boolean")
     */
    private $day;

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
     * Set fname
     *
     * @param string $fname
     *
     * @return Ticket
     */
    public function setFname($fname)
    {
        $this->fname = $fname;

        return $this;
    }

    /**
     * Get fname
     *
     * @return string
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * Set lname
     *
     * @param string $lname
     *
     * @return Ticket
     */
    public function setLname($lname)
    {
        $this->lname = $lname;

        return $this;
    }

    /**
     * Get lname
     *
     * @return string
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return Ticket
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
     * Set country
     *
     * @param array $country
     *
     * @return Ticket
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return array
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set reduc
     *
     * @param boolean $reduc
     *
     * @return Ticket
     */
    public function setReduc($reduc)
    {
        $this->reduc = $reduc;

        return $this;
    }

    /**
     * Get reduc
     *
     * @return boolean
     */
    public function getReduc()
    {
        return $this->reduc;
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
     * Set commande
     *
     * @param \LO\TicketBundle\Entity\Commande $commande
     *
     * @return Ticket
     */
    public function setCommande(Commande $commande = null)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \LO\TicketBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }

}
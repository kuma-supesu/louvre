<?php

namespace LO\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use LO\TicketBundle\Entity\Commande as Commande;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ticket
 * @ORM\Entity
 * @ORM\Table(name="ticket")
 */
class Ticket
{
    /**
     * @ORM\ManyToOne(targetEntity="Commande", inversedBy="ticket")
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
     *@Assert\Type(
     *     type="alpha",
     *     message="Ceci '{{ value }}' n'est pas un {{ type }}."
     * )
     *
     * @ORM\Column(name="f_name", type="string", length=255)
     *
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $fname;

    /**
     * @var string
     *
     *@Assert\Type(
     *     type="alpha",
     *     message="Ceci '{{ value }}' n'est pas un {{ type }}."
     * )
     *
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     *
     * @ORM\Column(name="l_name", type="string", length=255)
     */
    private $lname;

    /**
     * @var \Date
     *
     * @Assert\Date()
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
     * @param \Date $birthday
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
     * @return \Date
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Get birthday
     *
     * @return \Date
     */
    public function getBirthdayISO8601()
    {
        return $this->birthday->format('d-m-Y');
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

    public function getTarif()
    {
        $cout = 0;
        if ( $this->getReduc() === true){
            $cout+= 10;
        }
        if ($this->calculAge() >= 4 && $this->calculAge() < 12 && $this->getReduc() === false) {
            $cout += 8 ;
        }
        if ($this->calculAge() >= 12 && $this->calculAge() < 60 && $this->getReduc() === false) {
            $cout += 16 ;
        }
        if ($this->calculAge() >= 60 && $this->getReduc() === false) {
            $cout += 12 ;
        }
        if ($this->getCommande()->getDay() === true) {
            return $cout / 2;
        }
        return $cout;
    }

    public function getTypeTarif()
    {
        if ($this->getReduc() === true){
            $type = 'Réduction';
        }
        if ($this->calculAge() <= 4 && $this->getReduc() === false) {
            $type = 'Moins de 4 ans';
        }
        if ($this->calculAge() >= 4 && $this->calculAge() < 12 && $this->getReduc() === false) {
            $type = 'Junior';
        }
        if ($this->calculAge() >= 12 && $this->calculAge() < 60 && $this->getReduc() === false) {
            $type = 'Normal';
        }
        if ($this->calculAge() >= 60 && $this->getReduc() === false) {
            $type = 'Senior';
        }
        return $type;
    }

    protected function calculAge() {
        $birthday = $this->getBirthday();
        $year = $birthday->format('Y');
        $now = new \DateTime();
        $today = $now->format('Y');
        $age = $today - $year;
        return $age;
    }
}
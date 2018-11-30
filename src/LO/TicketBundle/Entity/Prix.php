<?php

namespace LO\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Prix
 * @ORM\Entity
 * @ORM\Table(name="prix")
 */

class Prix
{
    /**
     * @var \int
     *
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var \string
     *
     * @ORM\Column(name="typetarif", type="string")
     *
     */
    private $typeTarif;

    /**
     * @var \int
     *
     * @ORM\Column(name="tarif", type="integer")
     */
    private $tarif;

    /**
     * @var \int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get typetarif
     *
     * @return string
     */
    public function getTypeTarif()
    {
        return $this->typeTarif;
    }

    /**
 * Get tarif
 *
 * @return integer
 */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

}
<?php

namespace PaulBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Pays
 *
 * @ORM\Table(name="pays")
 * @ORM\Entity(repositoryClass="PaulBundle\Repository\PaysRepository")
 */
class Pays
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="drapeau", type="string")
     * @Assert\File(maxSize="6000000")
     */
    private $drapeau;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Athlete", mappedBy="pays")
     */
    private $athletes;

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Pays
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set drapeau
     *
     * @param string $drapeau
     *
     * @return Pays
     */
    public function setDrapeau($drapeau)
    {
        $this->drapeau = $drapeau;

        return $this;
    }

    /**
     * Get drapeau
     *
     * @return string
     */
    public function getDrapeau()
    {
        return $this->drapeau;
    }

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
     * Add athlete
     *
     * @param \PaulBundle\Entity\Athlete $athlete
     *
     * @return Discipline
     */
    public function addAthlete(\PaulBundle\Entity\Athlete $athlete)
    {
        $this->athletes[] = $athlete;
        return $this;
    }
    /**
     * Remove athlete
     *
     * @param \PaulBundle\Entity\Athlete $athlete
     */
    public function removeAthlete(\PaulBundle\Entity\Athlete $athlete)
    {
        $this->athletes->removeElement($athlete);
    }
    /**
     * Get athletes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAthletes()
    {
        return $this->athletes;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->athletes = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

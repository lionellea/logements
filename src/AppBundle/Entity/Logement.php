<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Cocur\Slugify\Slugify;
/**
 * Logement
 *
 * @ORM\Table(name="logement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LogementRepository")
 */
class Logement 
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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    
    /**
     * @var int
     *
     * @ORM\Column(name="nombre", type="integer")
     */
    private $nombre;
    
    /**
     * @var int
     *
     * @ORM\Column(name="nombre_piece", type="integer")
     */
    private $nombreDePiece;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_enreg", type="datetime", nullable=true)
     */
    private $dateEnreg;

    
    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Quartier")
    * @ORM\JoinColumn(nullable=false) 
    */
    private $quartier; 
    
     /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateEnreg = new \DateTime('now');
    }
    
    
    public function __toString() {
        return $this->type;
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
     * Set type
     *
     * @param string $type
     *
     * @return Logement
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set nombre
     *
     * @param integer $nombre
     *
     * @return Logement
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return integer
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set dateEnreg
     *
     * @param \DateTime $dateEnreg
     *
     * @return Logement
     */
    public function setDateEnreg($dateEnreg)
    {
        $this->dateEnreg = $dateEnreg;

        return $this;
    }

    /**
     * Get dateEnreg
     *
     * @return \DateTime
     */
    public function getDateEnreg()
    {
        return $this->dateEnreg;
    }

    /**
     * Set quartier
     *
     * @param \AppBundle\Entity\Quartier $quartier
     *
     * @return Logement
     */
    public function setQuartier(\AppBundle\Entity\Quartier $quartier)
    {
        $this->quartier = $quartier;

        return $this;
    }

    /**
     * Get quartier
     *
     * @return \AppBundle\Entity\Quartier
     */
    public function getQuartier()
    {
        return $this->quartier;
    }

    /**
     * Set nombreDePiece
     *
     * @param integer $nombreDePiece
     *
     * @return Logement
     */
    public function setNombreDePiece($nombreDePiece)
    {
        $this->nombreDePiece = $nombreDePiece;

        return $this;
    }

    /**
     * Get nombreDePiece
     *
     * @return integer
     */
    public function getNombreDePiece()
    {
        return $this->nombreDePiece;
    }
}

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
 * Terrain
 *
 * @ORM\Table(name="terrain")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TerrainRepository")
 * @Vich\Uploadable
 */
class Terrain
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $superficie;
    
     /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_enreg", type="datetime", nullable=true)
     */
    private $dateEnreg;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max=255)
     * @var string
     */
    private $image;
 
    
    /**
     * @Assert\File(
     *     maxSizeMessage = "L'image ne doit pas dépasser 10Mb.",
     *     maxSize = "10024k",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/gif", "image/png"},
     *     mimeTypesMessage = "Les images doivent être au format JPG, GIF ou PNG."
     * )
     * @Vich\UploadableField(mapping="image-terrain", fileNameProperty="image")
     */
    private $imageFile;
    
    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Quartier")
    * @ORM\JoinColumn(nullable=false) 
    */
    private $quartier; 
    

    public function __construct()
    {
        $this->dateEnreg = new \DateTime('now');
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
     * Set superficie
     *
     * @param string $superficie
     *
     * @return Terrain
     */
    public function setSuperficie($superficie)
    {
        $this->superficie = $superficie;

        return $this;
    }

    /**
     * Get superficie
     *
     * @return string
     */
    public function getSuperficie()
    {
        return $this->superficie;
    }

    /**
     * Set dateEnreg
     *
     * @param \DateTime $dateEnreg
     *
     * @return Terrain
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
     * Set image
     *
     * @param string $image
     *
     * @return Terrain
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imgFile
     *
     * @return Actualite
    */
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->dateEnreg = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }
    
    /**
     * Set quartier
     *
     * @param \AppBundle\Entity\Quartier $quartier
     *
     * @return Terrain
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
}

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
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 * @Vich\Uploadable
 */
class Image
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
     * @ORM\Column(name="Date_enreg", type="datetime", nullable=true)
     */
    private $dateEnreg;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $libele;
    
    /**
     * @var int
     *
     * @ORM\Column(name="nombre", type="integer")
     */
    private $nombre;

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
     * @Vich\UploadableField(mapping="image", fileNameProperty="image")
     */
    private $imageFile;
    
    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Logement")
    * @ORM\JoinColumn(nullable=false) 
    */
    private $logement; 

    
    function getSlug() {
        $slugify = new Slugify();
        return $slugify->slugify(microtime());
    }
    /**
     * Constructor
     */
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
     * Set dateEnreg
     *
     * @param \DateTime $dateEnreg
     *
     * @return Image
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
     * @return Image
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
     * Set logement
     *
     * @param \AppBundle\Entity\Logement $logement
     *
     * @return Image
     */
    public function setLogement(\AppBundle\Entity\Logement $logement)
    {
        $this->logement = $logement;

        return $this;
    }

    /**
     * Get logement
     *
     * @return \AppBundle\Entity\Logement
     */
    public function getLogement()
    {
        return $this->logement;
    }
    
    

    /**
     * Set libele
     *
     * @param string $libele
     *
     * @return Image
     */
    public function setLibele($libele)
    {
        $this->libele = $libele;

        return $this;
    }

    /**
     * Get libele
     *
     * @return string
     */
    public function getLibele()
    {
        return $this->libele;
    }

    /**
     * Set nombre
     *
     * @param integer $nombre
     *
     * @return Image
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
}

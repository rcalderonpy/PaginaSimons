<?php

namespace ContabilidadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Entidad
 *
 * @ORM\Table(name="entidad")
 * @ORM\Entity(repositoryClass="ContabilidadBundle\Repository\EntidadRepository")
 * @UniqueEntity(fields={"ruc"}, message="Entidad Duplicada: Ya existe el RUC ingresado")
 */
class Entidad
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
     * @ORM\Column(name="nombre", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="4", min="Debe contener al menos 4 caracteres", max="250")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="ruc", type="string", length=20, unique=true)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^\d{5,8}$/", message="RUC: Debe ser un número")
     * @Assert\Range(min="10000", max="89999999", maxMessage="RUC: Fuera del rango permitido")
     */
    private $ruc;

    /**
     * @var string
     *
     * @ORM\Column(name="dv", type="string", length=5)
     * @Assert\Length(min="1", max="1")
     * @Assert\Regex(pattern="/^\d{1}$/", message="DV: Debe ser un número entre el 0 y el 9")
     */
    private $dv;

    /**
     * @ORM\OneToMany(targetEntity="ContabilidadBundle\Entity\Ventac", mappedBy ="entidad", cascade={"persist", "remove"})
     */
    private $ventac;

    public function __construct()
    {
        $this->ventac= new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNombre();
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Entidad
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set ruc
     *
     * @param string $ruc
     *
     * @return Entidad
     */
    public function setRuc($ruc)
    {
        $this->ruc = $ruc;

        return $this;
    }

    /**
     * Get ruc
     *
     * @return string
     */
    public function getRuc()
    {
        return $this->ruc;
    }

    /**
     * Set dv
     *
     * @param string $dv
     *
     * @return Entidad
     */
    public function setDv($dv)
    {
        $this->dv = $dv;

        return $this;
    }

    /**
     * Get dv
     *
     * @return string
     */
    public function getDv()
    {
        return $this->dv;
    }

    /**
     * Add ventac
     *
     * @param \ContabilidadBundle\Entity\Ventac $ventac
     *
     * @return Entidad
     */
    public function addVentac(\ContabilidadBundle\Entity\Ventac $ventac)
    {
        $this->ventac[] = $ventac;

        return $this;
    }

    /**
     * Remove ventac
     *
     * @param \ContabilidadBundle\Entity\Ventac $ventac
     */
    public function removeVentac(\ContabilidadBundle\Entity\Ventac $ventac)
    {
        $this->ventac->removeElement($ventac);
    }

    /**
     * Get ventac
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVentac()
    {
        return $this->ventac;
    }
}

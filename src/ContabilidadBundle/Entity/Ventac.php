<?php

namespace ContabilidadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Ventac
 *
 * @ORM\Table(name="ventac")
 * @ORM\Entity(repositoryClass="ContabilidadBundle\Repository\VentacRepository")
 */
class Ventac
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
     * @var Sucursal
     * @ORM\ManyToOne(targetEntity="ContabilidadBundle\Entity\Sucursal", cascade={"persist"})
     * @ORM\JoinColumn(name="sucursal_id", referencedColumnName="id")
     * @Assert\NotNull()
     */
    private $sucursal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     * @Assert\NotNull()
     * @Assert\DateTime(format="d-/M/y", message="No es un formato válido")
     *
     */
    private $fecha;

    /**
     * @var Entidad
     *
     * @ORM\ManyToOne(targetEntity="ContabilidadBundle\Entity\Entidad", inversedBy="ventac")
     * @ORM\JoinColumn(name="entidad_id", referencedColumnName="id")
     * @Assert\NotNull()
     *
     */
    private $entidad;

    /**
     * @var \stdClass
     * @ORM\ManyToOne(targetEntity="ContabilidadBundle\Entity\Cliente")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     * @Assert\NotNull()
     */
    private $cliente;

    /**
     * @var string

     * @ORM\Column(name="nsuc", type="string", length=5)
     * @Assert\NotBlank()
     * @Assert\Length(max="3")
     * @Assert\Regex(pattern="/^\d*$/")
     *
     */
    private $nsuc;

    /**
     * @var string

     * @ORM\Column(name="npe", type="string", length=5)
     * @Assert\NotBlank()
     * @Assert\Length(max="3")
     * @Assert\Regex(pattern="/^\d*$/")
     */
    private $npe;

    /**
     * @var string

     * @ORM\Column(name="ncomp", type="string", length=20)
     * @Assert\NotBlank()
     * @Assert\Length(max="7")
     */
    private $ncomp;

    /**
     * @var \stdClass
     * @ORM\ManyToOne(targetEntity="ContabilidadBundle\Entity\Moneda", cascade={"persist"})
     * @ORM\JoinColumn(name="moneda_id", referencedColumnName="id")
     */
    private $moneda;

    /**
     * @var float
     *
     * @ORM\Column(name="cotiz", type="float")
     */
    private $cotiz=0.00;

    /**
     * @var bool
     *
     * @ORM\Column(name="anul", type="boolean")
     */
    private $anul;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="string", length=1000)
     */
    private $comentario;

    /**
     * @var \stdClass
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="timbrado", type="string", length=20)
     * @Assert\NotBlank()
     * @Assert\Length(max="8", min="8")
     * @Assert\Regex(pattern="/^\d{8}$/")
     */
    private $timbrado;

    /**
     * @var string
     *
     * @ORM\Column(name="condicion", type="string", length=20)
     */
    private $condicion;


    /**
     * @ORM\OneToMany(targetEntity="ContabilidadBundle\Entity\Ventad", mappedBy ="ventac", cascade={"remove", "persist"})
     */
    private $ventad;



    public function __construct()
    {
        $this->ventad = new ArrayCollection();
        $this->setFecha(new \DateTime());

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
     * Set suc
     *
     * @param \stdClass $suc
     *
     * @return VentaSin
     */
    public function setSucursal($sucursal)
    {
        $this->sucursal = $sucursal;

        return $this;
    }

    /**
     * Get sucursal
     *
     * @return \stdClass
     */
    public function getSucursal()
    {
        return $this->sucursal;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return VentaSin
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set empresa
     *
     * @param \stdClass $empresa
     *
     * @return VentaSin
     */
    public function setEntidad($entidad)
    {
        $this->entidad = $entidad;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \stdClass
     */
    public function getEntidad()
    {
        return $this->entidad;
    }

    /**
     * Set cliente
     *
     * @param \stdClass $cliente
     *
     * @return VentaSin
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \stdClass
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @return string
     */
    public function getNsuc()
    {
        return $this->nsuc;
    }

    /**
     * @param string $nsuc
     * @return VentaSin
     */
    public function setNsuc($nsuc)
    {
        $this->nsuc = $nsuc;
        return $this;
    }

    /**
     * @return string
     */
    public function getNpe()
    {
        return $this->npe;
    }

    /**
     * @param string $npe
     * @return VentaSin
     */
    public function setNpe($npe)
    {
        $this->npe = $npe;
        return $this;
    }

    /**
     * @return string
     */
    public function getNcomp()
    {
        return $this->ncomp;
    }

    /**
     * @param string $ncomp
     * @return VentaSin
     */
    public function setNcomp($ncomp)
    {
        $this->ncomp = $ncomp;
        return $this;
    }



    /**
     * Set moneda
     *
     * @param \stdClass $moneda
     *
     * @return VentaSin
     */
    public function setMoneda($moneda)
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * Get moneda
     *
     * @return \stdClass
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * Set cotiz
     *
     * @param float $cotiz
     *
     * @return VentaSin
     */
    public function setCotiz($cotiz)
    {
        $this->cotiz = $cotiz;

        return $this;
    }

    /**
     * Get cotiz
     *
     * @return float
     */
    public function getCotiz()
    {
        return $this->cotiz;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     *
     * @return VentaSin
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set usuario
     *
     * @param \stdClass $usuario
     *
     * @return VentaSin
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \stdClass
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set timbrado
     *
     * @param string $timbrado
     *
     * @return VentaSin
     */
    public function setTimbrado($timbrado)
    {
        $this->timbrado = $timbrado;

        return $this;
    }

    /**
     * Get timbrado
     *
     * @return string
     */
    public function getTimbrado()
    {
        return $this->timbrado;
    }

    /**
     * Set condicion
     *
     * @param string $condicion
     *
     * @return VentaSin
     */
    public function setCondicion($condicion)
    {
        $this->condicion = $condicion;

        return $this;
    }

    /**
     * Get condicion
     *
     * @return string
     */
    public function getCondicion()
    {
        return $this->condicion;
    }

    /**
     * @return boolean
     */
    public function isAnul()
    {
        return $this->anul;
    }

    /**
     * @param boolean $anul
     * @return Ventac
     */
    public function setAnul($anul)
    {
        $this->anul = $anul;
        return $this;
    }




    /**
     * Get anul
     *
     * @return boolean
     */
    public function getAnul()
    {
        return $this->anul;
    }



    /**
     * Add ventad
     *
     * @param \ContabilidadBundle\Entity\Ventad $ventad
     *
     * @return Ventac
     */
    public function addVentad(\ContabilidadBundle\Entity\Ventad $ventad)
    {
        $this->ventad[] = $ventad;

        return $this;
    }

    /**
     * Remove ventad
     *
     * @param \ContabilidadBundle\Entity\Ventad $ventad
     */
    public function removeVentad(\ContabilidadBundle\Entity\Ventad $ventad)
    {
        $this->ventad->removeElement($ventad);
    }

    /**
     * Get ventad
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVentad()
    {
        return $this->ventad;
    }
}

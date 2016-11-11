<?php

namespace ContabilidadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * VentaSin
 *
 * @ORM\Table(name="venta_sin")
 * @ORM\Entity(repositoryClass="ContabilidadBundle\Repository\VentaSinRepository")
 */
class VentaSin
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
     */
    private $fecha;

    /**
     * @var Entidad
     *
     * @ORM\ManyToOne(targetEntity="ContabilidadBundle\Entity\Entidad", cascade={"persist"})
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
     *
     */
    private $nsuc;

    /**
     * @var string

     * @ORM\Column(name="npe", type="string", length=5)
     * @Assert\NotBlank()
     * @Assert\Length(max="3")
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
    private $cotiz;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="string", length=1000)
     */
    private $comentario;

    /**
     * @var integer
     *
     * @ORM\Column(name="g10", type="integer")
     */
    private $g10;

    /**
     * @var int
     *
     * @ORM\Column(name="g5", type="integer")
     */
    private $g5;

    /**
     * @var int
     *
     * @ORM\Column(name="iva10", type="integer")
     */
    private $iva10;

    /**
     * @var int
     *
     * @ORM\Column(name="iva5", type="integer")
     */
    private $iva5;

    /**
     * @var int
     *
     * @ORM\Column(name="exe", type="integer")
     */
    private $exe;

    /**
     * @var int
     *
     * @ORM\Column(name="retencion", type="integer")
     */
    private $retencion;

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
     */
    private $timbrado;

    /**
     * @var string
     *
     * @ORM\Column(name="condicion", type="string", length=20)
     */
    private $condicion;


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
     * Set g10
     *
     * @param float $g10
     *
     * @return VentaSin
     */
    public function setG10($g10)
    {
        $this->g10 = $g10;

        return $this;
    }

    /**
     * Get g10
     *
     * @return float
     */
    public function getG10()
    {
        return $this->g10;
    }

    /**
     * Set g5
     *
     * @param float $g5
     *
     * @return VentaSin
     */
    public function setG5($g5)
    {
        $this->g5 = $g5;

        return $this;
    }

    /**
     * Get g5
     *
     * @return float
     */
    public function getG5()
    {
        return $this->g5;
    }

    /**
     * Set iva10
     *
     * @param float $iva10
     *
     * @return VentaSin
     */
    public function setIva10($iva10)
    {
        $this->iva10 = $iva10;

        return $this;
    }

    /**
     * Get iva10
     *
     * @return float
     */
    public function getIva10()
    {
        return $this->iva10;
    }

    /**
     * Set iva5
     *
     * @param float $iva5
     *
     * @return VentaSin
     */
    public function setIva5($iva5)
    {
        $this->iva5 = $iva5;

        return $this;
    }

    /**
     * Get iva5
     *
     * @return float
     */
    public function getIva5()
    {
        return $this->iva5;
    }

    /**
     * Set exe
     *
     * @param float $exe
     *
     * @return VentaSin
     */
    public function setExe($exe)
    {
        $this->exe = $exe;

        return $this;
    }

    /**
     * Get exe
     *
     * @return float
     */
    public function getExe()
    {
        return $this->exe;
    }

    /**
     * Set retencion
     *
     * @param integer $retencion
     *
     * @return VentaSin
     */
    public function setRetencion($retencion)
    {
        $this->retencion = $retencion;

        return $this;
    }

    /**
     * Get retencion
     *
     * @return int
     */
    public function getRetencion()
    {
        return $this->retencion;
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
}


<?php

namespace ContabilidadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Comprac
 *
 * @ORM\Table(name="comprac")
 * @ORM\Entity(repositoryClass="ContabilidadBundle\Repository\CompracRepository")
 * @UniqueEntity(fields={"nsuc", "npe", "ncomp", "tipocomp", "entidad"}, message="Compra Duplicada: Ya existen los datos ingresados")
 */
class Comprac
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @var Tipocomp
     * @ORM\ManyToOne(targetEntity="ContabilidadBundle\Entity\Parametro")
     * @ORM\JoinColumn(name="parametro_id", referencedColumnName="id")
     * @Assert\NotNull()
     */
    private $tipocomp;

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
     * @var \int

     * @Assert\NotNull()
     * @Assert\Regex(pattern="/^\d{1,2}$/", message="Día: Debe ser un número")
     * @Assert\Range(min="1", max="31", maxMessage="<b>Día:</b> Debe ser un día de mes válido")
     *
     */
    private $dia;

    /**
     * @var Entidad
     *
     * @ORM\ManyToOne(targetEntity="ContabilidadBundle\Entity\Entidad")
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
     * @Assert\Regex(pattern="/^\d{3}$/", message="SUC: Debe tener 3 dígitos")
     *
     */
    private $nsuc;

    /**
     * @var string

     * @ORM\Column(name="npe", type="string", length=5)
     * @Assert\NotBlank()
     * @Assert\Length(max="3")
     * @Assert\Regex(pattern="/^\d{3}$/", message="PE: Debe tener 3 dígitos")
     */
    private $npe;

    /**
     * @var string

     * @ORM\Column(name="ncomp", type="string", length=20)
     * @Assert\NotBlank()
     * @Assert\Length(max="7")
     * @Assert\Regex(pattern="/^\d{7}$/", message="PE: Debe tener 7 dígitos")
     */
    private $ncomp;

    /**
     * @var \stdClass
     * @ORM\ManyToOne(targetEntity="ContabilidadBundle\Entity\Moneda", cascade={"persist"})
     * @ORM\JoinColumn(name="moneda_id", referencedColumnName="id")
     */
    private $moneda;

    /**
     * @var decimal
     *
     * @ORM\Column(name="cotiz", type="decimal", scale=2)
     * @Assert\NotNull()
     */

    private $cotiz;

    /**
     * @var bool
     *
     * @ORM\Column(name="anul", type="boolean")
     */
    private $anul;

    /**
     * @var int
     *
     * @ORM\Column(name="afecta", type="smallint")
     */
    private $afecta;


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
     * @ORM\OneToMany(targetEntity="ContabilidadBundle\Entity\Comprad", mappedBy ="comprac", cascade={"remove", "persist"})
     */
    private $comprad;



    public function __construct()
    {
        $this->comprad = new ArrayCollection();
        $this->setFecha(new \DateTime());
        $this->setCotiz(0);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Comprac
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Sucursal
     */
    public function getSucursal()
    {
        return $this->sucursal;
    }

    /**
     * @param Sucursal $sucursal
     * @return Comprac
     */
    public function setSucursal($sucursal)
    {
        $this->sucursal = $sucursal;
        return $this;
    }

    /**
     * @return Tipocomp
     */
    public function getTipocomp()
    {
        return $this->tipocomp;
    }

    /**
     * @param Tipocomp $tipocomp
     * @return Comprac
     */
    public function setTipocomp($tipocomp)
    {
        $this->tipocomp = $tipocomp;
        return $this;
    }




    /**
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     * @return Comprac
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * @return Entidad
     */
    public function getEntidad()
    {
        return $this->entidad;
    }

    /**
     * @param Entidad $entidad
     * @return Comprac
     */
    public function setEntidad($entidad)
    {
        $this->entidad = $entidad;
        return $this;
    }

    /**
     * @return \stdClass
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param \stdClass $cliente
     * @return Comprac
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
        return $this;
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
     * @return Comprac
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
     * @return Comprac
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
     * @return Comprac
     */
    public function setNcomp($ncomp)
    {
        $this->ncomp = $ncomp;
        return $this;
    }

    /**
     * @return \stdClass
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * @param \stdClass $moneda
     * @return Comprac
     */
    public function setMoneda($moneda)
    {
        $this->moneda = $moneda;
        return $this;
    }

    /**
     * @return float
     */
    public function getCotiz()
    {
        return $this->cotiz;
    }

    /**
     * @param float $cotiz
     * @return Comprac
     */
    public function setCotiz($cotiz)
    {
        $this->cotiz = $cotiz;
        return $this;
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
     * @return Comprac
     */
    public function setAnul($anul)
    {
        $this->anul = $anul;
        return $this;
    }

    /**
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param string $comentario
     * @return Comprac
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
        return $this;
    }

    /**
     * @return \stdClass
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param \stdClass $usuario
     * @return Comprac
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimbrado()
    {
        return $this->timbrado;
    }

    /**
     * @param string $timbrado
     * @return Comprac
     */
    public function setTimbrado($timbrado)
    {
        $this->timbrado = $timbrado;
        return $this;
    }

    /**
     * @return string
     */
    public function getCondicion()
    {
        return $this->condicion;
    }

    /**
     * @param string $condicion
     * @return Comprac
     */
    public function setCondicion($condicion)
    {
        $this->condicion = $condicion;
        return $this;
    }

    

    /**
     * Add comprad
     *
     * @param \ContabilidadBundle\Entity\Comprad $comprad
     *
     * @return Comprac
     */
    public function addComprad(Comprad $comprad)
    {
        $this->comprad[] = $comprad;

        return $this;
    }

    /**
     * Remove comprad
     *
     * @param \ContabilidadBundle\Entity\Comprad $comprad
     */
    public function removeComprad(Comprad $comprad)
    {
        $this->comprad->removeElement($comprad);
    }

    /**
     * Get comprad
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComprad()
    {
        return $this->comprad;
    }

    /**
     * @return int
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * @param int $dia
     * @return Comprac
     */
    public function setDia($dia)
    {
        $this->dia = $dia;
        return $this;
    }

    /**
     * Set afecta
     *
     * @param integer $afecta
     *
     * @return Comprad
     */
    public function setAfecta($afecta)
    {
        $this->afecta = $afecta;

        return $this;
    }

    /**
     * Get afecta
     *
     * @return int
     */
    public function getAfecta()
    {
        return $this->afecta;
    }
}

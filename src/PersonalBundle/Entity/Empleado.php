<?php

namespace PersonalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PersonalBundle\Entity\Empresa;

/**
 * Empleado
 *
 * @ORM\Table(name="empleado")
 * @ORM\Entity(repositoryClass="PersonalBundle\Repository\EmpleadoRepository")
 */
class Empleado
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
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="PersonalBundle\Entity\Empresa")
     * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     */
    private $empresa;

    /**
     * @var string
     *
     * @ORM\Column(name="documento", type="string", length=15)
     */
    private $documento;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=50)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string", length=1)
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="estadocivil", type="string", length=1)
     */
    private $estadocivil;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechanac", type="datetime")
     */
    private $fechanac;

    /**
     * @var string
     *
     * @ORM\Column(name="nacionalidad", type="string", length=20)
     */
    private $nacionalidad;

    /**
     * @var string
     *
     * @ORM\Column(name="domicilio", type="string", length=100)
     */
    private $domicilio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechamenor", type="datetime")
     */
    private $fechamenor;

    /**
     * @var int
     *
     * @ORM\Column(name="hijosmenores", type="integer")
     */
    private $hijosmenores;

    /**
     * @var string
     *
     * @ORM\Column(name="cargo", type="string", length=100)
     */
    private $cargo;

    /**
     * @var string
     *
     * @ORM\Column(name="profesion", type="string", length=100)
     */
    private $profesion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaentrada", type="datetime")
     */
    private $fechaentrada;

    /**
     * @var string
     *
     * @ORM\Column(name="horariotrabajo", type="string", length=20)
     */
    private $horariotrabajo;

    /**
     * @var string
     *
     * @ORM\Column(name="menorescapa", type="string", length=20)
     */
    private $menorescapa;

    /**
     * @var string
     *
     * @ORM\Column(name="menoresescolar", type="string")
     */
    private $menoresescolar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechasalida", type="datetime")
     */
    private $fechasalida;

    /**
     * @var string
     *
     * @ORM\Column(name="motivosalida", type="string", length=100)
     */
    private $motivosalida;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string")
     */
    private $estado;



    // GETTERS Y SETTERS
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
     * Set nropatronal
     *
     * @param integer $nropatronal
     *
     * @return Empleado
     */
    public function setNropatronal($nropatronal)
    {
        $this->nropatronal = $nropatronal;

        return $this;
    }

    /**
     * Get nropatronal
     *
     * @return int
     */
    public function getNropatronal()
    {
        return $this->nropatronal;
    }

    /**
     * Set documento
     *
     * @param string $documento
     *
     * @return Empleado
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Empleado
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
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Empleado
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     *
     * @return Empleado
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set estadocivil
     *
     * @param string $estadocivil
     *
     * @return Empleado
     */
    public function setEstadocivil($estadocivil)
    {
        $this->estadocivil = $estadocivil;

        return $this;
    }

    /**
     * Get estadocivil
     *
     * @return string
     */
    public function getEstadocivil()
    {
        return $this->estadocivil;
    }

    /**
     * Set fechanac
     *
     * @param \DateTime $fechanac
     *
     * @return Empleado
     */
    public function setFechanac($fechanac)
    {
        $this->fechanac = $fechanac;

        return $this;
    }

    /**
     * Get fechanac
     *
     * @return \DateTime
     */
    public function getFechanac()
    {
        return $this->fechanac;
    }

    /**
     * Set nacionalidad
     *
     * @param string $nacionalidad
     *
     * @return Empleado
     */
    public function setNacionalidad($nacionalidad)
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    /**
     * Get nacionalidad
     *
     * @return string
     */
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    /**
     * Set domicilio
     *
     * @param string $domicilio
     *
     * @return Empleado
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio
     *
     * @return string
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Set fechamenor
     *
     * @param \DateTime $fechamenor
     *
     * @return Empleado
     */
    public function setFechamenor($fechamenor)
    {
        $this->fechamenor = $fechamenor;

        return $this;
    }

    /**
     * Get fechamenor
     *
     * @return \DateTime
     */
    public function getFechamenor()
    {
        return $this->fechamenor;
    }

    /**
     * Set hijosmenores
     *
     * @param integer $hijosmenores
     *
     * @return Empleado
     */
    public function setHijosmenores($hijosmenores)
    {
        $this->hijosmenores = $hijosmenores;

        return $this;
    }

    /**
     * Get hijosmenores
     *
     * @return int
     */
    public function getHijosmenores()
    {
        return $this->hijosmenores;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     *
     * @return Empleado
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set profesion
     *
     * @param string $profesion
     *
     * @return Empleado
     */
    public function setProfesion($profesion)
    {
        $this->profesion = $profesion;

        return $this;
    }

    /**
     * Get profesion
     *
     * @return string
     */
    public function getProfesion()
    {
        return $this->profesion;
    }

    /**
     * Set fechaentrada
     *
     * @param \DateTime $fechaentrada
     *
     * @return Empleado
     */
    public function setFechaentrada($fechaentrada)
    {
        $this->fechaentrada = $fechaentrada;

        return $this;
    }

    /**
     * Get fechaentrada
     *
     * @return \DateTime
     */
    public function getFechaentrada()
    {
        return $this->fechaentrada;
    }

    /**
     * @return string
     */
    public function getHorariotrabajo()
    {
        return $this->horariotrabajo;
    }

    /**
     * @param string $horariotrabajo
     * @return Empleado
     */
    public function setHorariotrabajo($horariotrabajo)
    {
        $this->horariotrabajo = $horariotrabajo;
        return $this;
    }

    /**
     * @return string
     */
    public function getMenorescapa()
    {
        return $this->menorescapa;
    }

    /**
     * @param string $menorescapa
     * @return Empleado
     */
    public function setMenorescapa($menorescapa)
    {
        $this->menorescapa = $menorescapa;
        return $this;
    }

    /**
     * @return string
     */
    public function getMenoresescolar()
    {
        return $this->menoresescolar;
    }

    /**
     * @param string $menoresescolar
     * @return Empleado
     */
    public function setMenoresescolar($menoresescolar)
    {
        $this->menoresescolar = $menoresescolar;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFechasalida()
    {
        return $this->fechasalida;
    }

    /**
     * @param \DateTime $fechasalida
     * @return Empleado
     */
    public function setFechasalida($fechasalida)
    {
        $this->fechasalida = $fechasalida;
        return $this;
    }

    /**
     * @return string
     */
    public function getMotivosalida()
    {
        return $this->motivosalida;
    }

    /**
     * @param string $motivosalida
     * @return Empleado
     */
    public function setMotivosalida($motivosalida)
    {
        $this->motivosalida = $motivosalida;
        return $this;
    }

    /**
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     * @return Empleado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }


}


<?php

namespace ContabilidadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Periodo
 *
 * @ORM\Table(name="periodo")
 * @ORM\Entity(repositoryClass="ContabilidadBundle\Repository\PeriodoRepository")
 */
class Periodo
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
     * @Assert\Length(max="2", min="2")
     * @Assert\NotBlank()
     * @Assert\Range(min="01", max="12")
     * @Assert\Regex(pattern="/^\d{2}/")
     *
     * @ORM\Column(name="mes", type="string", length=5)
     */
    private $mes;

    /**
     * @var string
     *
     * @ORM\Column(name="ano", type="string", length=5)
     * @Assert\Length(max="4", min="4")
     * @Assert\NotBlank()
     * @Assert\Range(min="1900", max="2100")
     * @Assert\Regex(pattern="/^\d{4}/")
     *
     */
    private $ano;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="ContabilidadBundle\Entity\Cliente")
     * @ORM\JoinColumn(fieldName="cliente_id", referencedColumnName="id")
     */
    private $cliente;

    /**
     * @var bool
     *
     * @ORM\Column(name="bloqueado", type="boolean")
     *
     */
    private $bloqueado=false;



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
     * Set mes
     *
     * @param string $mes
     *
     * @return Periodo
     */
    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    /**
     * Get mes
     *
     * @return string
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set año
     *
     * @param string $año
     *
     * @return Periodo
     */
    public function setAno($ano)
    {
        $this->ano = $ano;

        return $this;
    }

    /**
     * Get año
     *
     * @return string
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set cliente
     *
     * @param \stdClass $cliente
     *
     * @return Periodo
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
     * Set bloqueado
     *
     * @param boolean $bloqueado
     *
     * @return Periodo
     */
    public function setBloqueado($bloqueado)
    {
        $this->bloqueado = $bloqueado;

        return $this;
    }

    /**
     * Get bloqueado
     *
     * @return bool
     */
    public function getBloqueado()
    {
        return $this->bloqueado;
    }
}


<?php

namespace ContabilidadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanCta
 *
 * @ORM\Table(name="plan_cta")
 * @ORM\Entity(repositoryClass="ContabilidadBundle\Repository\PlanCtaRepository")
 */
class PlanCta
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
     * @ORM\Column(name="codigo", type="string", length=20, unique=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="cuenta", type="string", length=150)
     */
    private $cuenta;

    /**
     * @var bool
     *
     * @ORM\Column(name="imputable", type="boolean")
     */
    private $imputable;


    /**
     * @var renta
     *
     * @ORM\Column(name="renta", type="smallint")
     */
    private $renta=0;

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
     * Set codigo
     *
     * @param string $codigo
     *
     * @return PlanCta
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set cuenta
     *
     * @param string $cuenta
     *
     * @return PlanCta
     */
    public function setcuenta($cuenta)
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * Get cuenta
     *
     * @return string
     */
    public function getcuenta()
    {
        return $this->cuenta;
    }

    /**
     * Set imputable
     *
     * @param boolean $imputable
     *
     * @return PlanCta
     */
    public function setImputable($imputable)
    {
        $this->imputable = $imputable;

        return $this;
    }

    /**
     * Get imputable
     *
     * @return bool
     */
    public function getImputable()
    {
        return $this->imputable;
    }

    /**
     * @return renta
     */
    public function getRenta()
    {
        return $this->renta;
    }

    /**
     * @param renta $renta
     * @return PlanCta
     */
    public function setRenta($renta)
    {
        $this->renta = $renta;
        return $this;
    }
}


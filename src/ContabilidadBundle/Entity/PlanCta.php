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
     * @ORM\Column(name="cuentaç", type="string", length=150)
     */
    private $cuentaç;

    /**
     * @var bool
     *
     * @ORM\Column(name="imputable", type="boolean")
     */
    private $imputable;


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
     * Set cuentaç
     *
     * @param string $cuentaç
     *
     * @return PlanCta
     */
    public function setCuentaç($cuentaç)
    {
        $this->cuentaç = $cuentaç;

        return $this;
    }

    /**
     * Get cuentaç
     *
     * @return string
     */
    public function getCuentaç()
    {
        return $this->cuentaç;
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
}


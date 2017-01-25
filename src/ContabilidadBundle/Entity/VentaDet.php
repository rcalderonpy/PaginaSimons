<?php

namespace ContabilidadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VentaDet
 *
 * @ORM\Table(name="venta_det")
 * @ORM\Entity(repositoryClass="ContabilidadBundle\Repository\VentaDetRepository")
 */
class VentaDet
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
     * @ORM\ManyToOne(targetEntity="ContabilidadBundle\Entity\VentaCab")
     * @ORM\JoinColumn(name="ventaCab_id", referencedColumnName="id")
     */
    private $venta;

    /**
     * @var \stdClass
     * @ORM\ManyToOne(targetEntity="ContabilidadBundle\Entity\PlanCta")
     * @ORM\JoinColumn(name="planCta_id", referencedColumnName="id")
     */
    private $ncuenta;

    /**
     * @var float
     *
     * @ORM\Column(name="g10", type="float")
     */
    private $g10;

    /**
     * @var float
     *
     * @ORM\Column(name="g5", type="float")
     */
    private $g5;

    /**
     * @var float
     *
     * @ORM\Column(name="iva10", type="float")
     */
    private $iva10;

    /**
     * @var float
     *
     * @ORM\Column(name="iva5", type="float")
     */
    private $iva5;

    /**
     * @var float
     *
     * @ORM\Column(name="exe", type="float")
     */
    private $exe;

    /**
     * @var int
     *
     * @ORM\Column(name="afecta", type="smallint")
     */
    private $afecta;


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
     * Set venta
     *
     * @param \stdClass $venta
     *
     * @return VentaDet
     */
    public function setVenta($venta)
    {
        $this->venta = $venta;

        return $this;
    }

    /**
     * Get venta
     *
     * @return \stdClass
     */
    public function getVenta()
    {
        return $this->venta;
    }

    /**
     * Set ncuenta
     *
     * @param string $ncuenta
     *
     * @return VentaDet
     */
    public function setNcuenta($ncuenta)
    {
        $this->ncuenta = $ncuenta;

        return $this;
    }

    /**
     * Get ncuenta
     *
     * @return string
     */
    public function getNcuenta()
    {
        return $this->ncuenta;
    }

    /**
     * Set g10
     *
     * @param float $g10
     *
     * @return VentaDet
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
     * @return VentaDet
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
     * @return VentaDet
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
     * @return VentaDet
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
     * @return VentaDet
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
     * Set afecta
     *
     * @param integer $afecta
     *
     * @return VentaDet
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


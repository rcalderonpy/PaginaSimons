<?php

namespace ContabilidadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comprad
 *
 * @ORM\Table(name="comprad")
 * @ORM\Entity(repositoryClass="ContabilidadBundle\Repository\CompradRepository")
 */
class Comprad
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
     * @var \stdClass
     * @ORM\ManyToOne(targetEntity="ContabilidadBundle\Entity\Comprac", inversedBy="comprad", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="comprac_id", referencedColumnName="id")
     */
    private $comprac;

    /**
     * @var \stdClass
     * @ORM\ManyToOne(targetEntity="ContabilidadBundle\Entity\Cuenta")
     * @ORM\JoinColumn(name="cuenta_id", referencedColumnName="id")
     */
    private $cuenta;

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


    public function _toString(){
        return (string) $this->getCuenta();
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
     * Set Comprac
     *
     * @param \stdClass $Comprac
     *
     * @return Comprad
     */
    public function setComprac($comprac)
    {
        $this->comprac = $comprac;

        return $this;
    }

    /**
     * Get Comprac
     *
     * @return \stdClass
     */
    public function getComprac()
    {
        return $this->comprac;
    }

    /**
     * Set cuenta
     *
     * @param string $cuenta
     *
     * @return Comprad
     */
    public function setCuenta($cuenta)
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * Get cuenta
     *
     * @return string
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * Set g10
     *
     * @param float $g10
     *
     * @return Comprad
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
     * @return Comprad
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
     * @return Comprad
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
     * @return Comprad
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
     * @return Comprad
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

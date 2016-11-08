<?php

namespace PersonalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PersonalBundle\Entity\Empresa;
use PersonalBundle\Entity\Empleado;


/**
 * Sueldo
 *
 * @ORM\Table(name="sueldo")
 * @ORM\Entity(repositoryClass="PersonalBundle\Repository\SueldoRepository")
 */
class Sueldo
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
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="PersonalBundle\Entity\Empleado")
     * @ORM\JoinColumn(name="empleado_id", referencedColumnName="id")
     */
    private $empleado;

    /**
     * @var string
     *
     * @ORM\Column(name="formadepago", type="string", length=1)
     */
    private $formadepago;

    /**
     * @var int
     *
     * @ORM\Column(name="importeunitario", type="integer")
     */
    private $importeunitario;

    /**
     * @var int
     *
     * @ORM\Column(name="h_ene", type="integer")
     */
    private $hEne;

    /**
     * @var int
     *
     * @ORM\Column(name="s_ene", type="integer")
     */
    private $sEne;

    /**
     * @var int
     *
     * @ORM\Column(name="h_feb", type="integer")
     */
    private $hFeb;

    /**
     * @var int
     *
     * @ORM\Column(name="s_feb", type="integer")
     */
    private $sFeb;

    /**
     * @var int
     *
     * @ORM\Column(name="h_mar", type="integer")
     */
    private $hMar;

    /**
     * @var int
     *
     * @ORM\Column(name="s_mar", type="integer")
     */
    private $sMar;

    /**
     * @var int
     *
     * @ORM\Column(name="h_abr", type="integer")
     */
    private $hAbr;

    /**
     * @var int
     *
     * @ORM\Column(name="s_abr", type="integer")
     */
    private $sAbr;

    /**
     * @var int
     *
     * @ORM\Column(name="h_may", type="integer")
     */
    private $hMay;

    /**
     * @var int
     *
     * @ORM\Column(name="s_may", type="integer")
     */
    private $sMay;

    /**
     * @var int
     *
     * @ORM\Column(name="h_jun", type="integer")
     */
    private $hJun;

    /**
     * @var int
     *
     * @ORM\Column(name="s_jun", type="integer")
     */
    private $sJun;

    /**
     * @var int
     *
     * @ORM\Column(name="h_jul", type="integer")
     */
    private $hJul;

    /**
     * @var int
     *
     * @ORM\Column(name="s_jul", type="integer")
     */
    private $sJul;

    /**
     * @var int
     *
     * @ORM\Column(name="h_ago", type="integer")
     */
    private $hAgo;

    /**
     * @var int
     *
     * @ORM\Column(name="s_ago", type="integer")
     */
    private $sAgo;

    /**
     * @var int
     *
     * @ORM\Column(name="h_set", type="integer")
     */
    private $hSet;

    /**
     * @var int
     *
     * @ORM\Column(name="s_set", type="integer")
     */
    private $sSet;

    /**
     * @var int
     *
     * @ORM\Column(name="h_oct", type="integer")
     */
    private $hOct;

    /**
     * @var int
     *
     * @ORM\Column(name="s_oct", type="integer")
     */
    private $sOct;

    /**
     * @var int
     *
     * @ORM\Column(name="h_nov", type="integer")
     */
    private $hNov;

    /**
     * @var int
     *
     * @ORM\Column(name="s_nov", type="integer")
     */
    private $sNov;

    /**
     * @var int
     *
     * @ORM\Column(name="h_dic", type="integer")
     */
    private $hDic;

    /**
     * @var int
     *
     * @ORM\Column(name="s_dic", type="integer")
     */
    private $sDic;

    /**
     * @var int
     *
     * @ORM\Column(name="h_50", type="integer")
     */
    private $h50;

    /**
     * @var int
     *
     * @ORM\Column(name="s_50", type="integer")
     */
    private $s50;

    /**
     * @var int
     *
     * @ORM\Column(name="h_100", type="integer")
     */
    private $h100;

    /**
     * @var int
     *
     * @ORM\Column(name="s_100", type="integer")
     */
    private $s100;

    /**
     * @var int
     *
     * @ORM\Column(name="aguinaldo", type="integer")
     */
    private $aguinaldo;

    /**
     * @var int
     *
     * @ORM\Column(name="beneficios", type="integer")
     */
    private $beneficios;

    /**
     * @var int
     *
     * @ORM\Column(name="bonificaciones", type="integer")
     */
    private $bonificaciones;

    /**
     * @var int
     *
     * @ORM\Column(name="vacaciones", type="integer")
     */
    private $vacaciones;

    /**
     * @var int
     *
     * @ORM\Column(name="total_h", type="integer")
     */
    private $totalH;

    /**
     * @var int
     *
     * @ORM\Column(name="total_s", type="integer")
     */
    private $totalS;

    /**
     * @var int
     *
     * @ORM\Column(name="totalgeneral", type="integer")
     */
    private $totalgeneral;


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
     * Set empresa
     *
     * @param \stdClass $empresa
     *
     * @return Sueldo
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \stdClass
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set empleado
     *
     * @param \stdClass $empleado
     *
     * @return Sueldo
     */
    public function setEmpleado($empleado)
    {
        $this->empleado = $empleado;

        return $this;
    }

    /**
     * Get empleado
     *
     * @return \stdClass
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }

    /**
     * Set formadepago
     *
     * @param string $formadepago
     *
     * @return Sueldo
     */
    public function setFormadepago($formadepago)
    {
        $this->formadepago = $formadepago;

        return $this;
    }

    /**
     * Get formadepago
     *
     * @return string
     */
    public function getFormadepago()
    {
        return $this->formadepago;
    }

    /**
     * Set importeunitario
     *
     * @param integer $importeunitario
     *
     * @return Sueldo
     */
    public function setImporteunitario($importeunitario)
    {
        $this->importeunitario = $importeunitario;

        return $this;
    }

    /**
     * Get importeunitario
     *
     * @return int
     */
    public function getImporteunitario()
    {
        return $this->importeunitario;
    }

    /**
     * Set hEne
     *
     * @param integer $hEne
     *
     * @return Sueldo
     */
    public function setHEne($hEne)
    {
        $this->hEne = $hEne;

        return $this;
    }

    /**
     * Get hEne
     *
     * @return int
     */
    public function getHEne()
    {
        return $this->hEne;
    }

    /**
     * Set sEne
     *
     * @param integer $sEne
     *
     * @return Sueldo
     */
    public function setSEne($sEne)
    {
        $this->sEne = $sEne;

        return $this;
    }

    /**
     * Get sEne
     *
     * @return int
     */
    public function getSEne()
    {
        return $this->sEne;
    }

    /**
     * Set hFeb
     *
     * @param integer $hFeb
     *
     * @return Sueldo
     */
    public function setHFeb($hFeb)
    {
        $this->hFeb = $hFeb;

        return $this;
    }

    /**
     * Get hFeb
     *
     * @return int
     */
    public function getHFeb()
    {
        return $this->hFeb;
    }

    /**
     * Set sFeb
     *
     * @param integer $sFeb
     *
     * @return Sueldo
     */
    public function setSFeb($sFeb)
    {
        $this->sFeb = $sFeb;

        return $this;
    }

    /**
     * Get sFeb
     *
     * @return int
     */
    public function getSFeb()
    {
        return $this->sFeb;
    }

    /**
     * Set hMar
     *
     * @param integer $hMar
     *
     * @return Sueldo
     */
    public function setHMar($hMar)
    {
        $this->hMar = $hMar;

        return $this;
    }

    /**
     * Get hMar
     *
     * @return int
     */
    public function getHMar()
    {
        return $this->hMar;
    }

    /**
     * Set sMar
     *
     * @param integer $sMar
     *
     * @return Sueldo
     */
    public function setSMar($sMar)
    {
        $this->sMar = $sMar;

        return $this;
    }

    /**
     * Get sMar
     *
     * @return int
     */
    public function getSMar()
    {
        return $this->sMar;
    }

    /**
     * Set hAbr
     *
     * @param integer $hAbr
     *
     * @return Sueldo
     */
    public function setHAbr($hAbr)
    {
        $this->hAbr = $hAbr;

        return $this;
    }

    /**
     * Get hAbr
     *
     * @return int
     */
    public function getHAbr()
    {
        return $this->hAbr;
    }

    /**
     * Set sAbr
     *
     * @param integer $sAbr
     *
     * @return Sueldo
     */
    public function setSAbr($sAbr)
    {
        $this->sAbr = $sAbr;

        return $this;
    }

    /**
     * Get sAbr
     *
     * @return int
     */
    public function getSAbr()
    {
        return $this->sAbr;
    }

    /**
     * Set hMay
     *
     * @param integer $hMay
     *
     * @return Sueldo
     */
    public function setHMay($hMay)
    {
        $this->hMay = $hMay;

        return $this;
    }

    /**
     * Get hMay
     *
     * @return int
     */
    public function getHMay()
    {
        return $this->hMay;
    }

    /**
     * Set sMay
     *
     * @param integer $sMay
     *
     * @return Sueldo
     */
    public function setSMay($sMay)
    {
        $this->sMay = $sMay;

        return $this;
    }

    /**
     * Get sMay
     *
     * @return int
     */
    public function getSMay()
    {
        return $this->sMay;
    }

    /**
     * Set hJun
     *
     * @param integer $hJun
     *
     * @return Sueldo
     */
    public function setHJun($hJun)
    {
        $this->hJun = $hJun;

        return $this;
    }

    /**
     * Get hJun
     *
     * @return int
     */
    public function getHJun()
    {
        return $this->hJun;
    }

    /**
     * Set sJun
     *
     * @param integer $sJun
     *
     * @return Sueldo
     */
    public function setSJun($sJun)
    {
        $this->sJun = $sJun;

        return $this;
    }

    /**
     * Get sJun
     *
     * @return int
     */
    public function getSJun()
    {
        return $this->sJun;
    }

    /**
     * Set hJul
     *
     * @param integer $hJul
     *
     * @return Sueldo
     */
    public function setHJul($hJul)
    {
        $this->hJul = $hJul;

        return $this;
    }

    /**
     * Get hJul
     *
     * @return int
     */
    public function getHJul()
    {
        return $this->hJul;
    }

    /**
     * Set sJul
     *
     * @param integer $sJul
     *
     * @return Sueldo
     */
    public function setSJul($sJul)
    {
        $this->sJul = $sJul;

        return $this;
    }

    /**
     * Get sJul
     *
     * @return int
     */
    public function getSJul()
    {
        return $this->sJul;
    }

    /**
     * Set hAgo
     *
     * @param integer $hAgo
     *
     * @return Sueldo
     */
    public function setHAgo($hAgo)
    {
        $this->hAgo = $hAgo;

        return $this;
    }

    /**
     * Get hAgo
     *
     * @return int
     */
    public function getHAgo()
    {
        return $this->hAgo;
    }

    /**
     * Set sAgo
     *
     * @param integer $sAgo
     *
     * @return Sueldo
     */
    public function setSAgo($sAgo)
    {
        $this->sAgo = $sAgo;

        return $this;
    }

    /**
     * Get sAgo
     *
     * @return integer
     */
    public function getSAgo()
    {
        return $this->sAgo;
    }

    /**
     * Set hSet
     *
     * @param integer $hSet
     *
     * @return Sueldo
     */
    public function setHSet($hSet)
    {
        $this->hSet = $hSet;

        return $this;
    }

    /**
     * Get hSet
     *
     * @return int
     */
    public function getHSet()
    {
        return $this->hSet;
    }

    /**
     * Set sSet
     *
     * @param integer $sSet
     *
     * @return Sueldo
     */
    public function setSSet($sSet)
    {
        $this->sSet = $sSet;

        return $this;
    }

    /**
     * Get sSet
     *
     * @return int
     */
    public function getSSet()
    {
        return $this->sSet;
    }

    /**
     * Set hOct
     *
     * @param integer $hOct
     *
     * @return Sueldo
     */
    public function setHOct($hOct)
    {
        $this->hOct = $hOct;

        return $this;
    }

    /**
     * Get hOct
     *
     * @return int
     */
    public function getHOct()
    {
        return $this->hOct;
    }

    /**
     * Set sOct
     *
     * @param integer $sOct
     *
     * @return Sueldo
     */
    public function setSOct($sOct)
    {
        $this->sOct = $sOct;

        return $this;
    }

    /**
     * Get sOct
     *
     * @return int
     */
    public function getSOct()
    {
        return $this->sOct;
    }

    /**
     * Set hNov
     *
     * @param integer $hNov
     *
     * @return Sueldo
     */
    public function setHNov($hNov)
    {
        $this->hNov = $hNov;

        return $this;
    }

    /**
     * Get hNov
     *
     * @return int
     */
    public function getHNov()
    {
        return $this->hNov;
    }

    /**
     * Set sNov
     *
     * @param integer $sNov
     *
     * @return Sueldo
     */
    public function setSNov($sNov)
    {
        $this->sNov = $sNov;

        return $this;
    }

    /**
     * Get sNov
     *
     * @return int
     */
    public function getSNov()
    {
        return $this->sNov;
    }

    /**
     * Set hDic
     *
     * @param integer $hDic
     *
     * @return Sueldo
     */
    public function setHDic($hDic)
    {
        $this->hDic = $hDic;

        return $this;
    }

    /**
     * Get hDic
     *
     * @return int
     */
    public function getHDic()
    {
        return $this->hDic;
    }

    /**
     * Set sDic
     *
     * @param integer $sDic
     *
     * @return Sueldo
     */
    public function setSDic($sDic)
    {
        $this->sDic = $sDic;

        return $this;
    }

    /**
     * Get sDic
     *
     * @return int
     */
    public function getSDic()
    {
        return $this->sDic;
    }

    /**
     * Set h50
     *
     * @param integer $h50
     *
     * @return Sueldo
     */
    public function setH50($h50)
    {
        $this->h50 = $h50;

        return $this;
    }

    /**
     * Get h50
     *
     * @return int
     */
    public function getH50()
    {
        return $this->h50;
    }

    /**
     * Set s50
     *
     * @param integer $s50
     *
     * @return Sueldo
     */
    public function setS50($s50)
    {
        $this->s50 = $s50;

        return $this;
    }

    /**
     * Get s50
     *
     * @return int
     */
    public function getS50()
    {
        return $this->s50;
    }

    /**
     * Set h100
     *
     * @param integer $h100
     *
     * @return Sueldo
     */
    public function setH100($h100)
    {
        $this->h100 = $h100;

        return $this;
    }

    /**
     * Get h100
     *
     * @return int
     */
    public function getH100()
    {
        return $this->h100;
    }

    /**
     * Set s100
     *
     * @param integer $s100
     *
     * @return Sueldo
     */
    public function setS100($s100)
    {
        $this->s100 = $s100;

        return $this;
    }

    /**
     * Get s100
     *
     * @return int
     */
    public function getS100()
    {
        return $this->s100;
    }

    /**
     * Set aguinaldo
     *
     * @param integer $aguinaldo
     *
     * @return Sueldo
     */
    public function setAguinaldo($aguinaldo)
    {
        $this->aguinaldo = $aguinaldo;

        return $this;
    }

    /**
     * Get aguinaldo
     *
     * @return int
     */
    public function getAguinaldo()
    {
        return $this->aguinaldo;
    }

    /**
     * Set beneficios
     *
     * @param integer $beneficios
     *
     * @return Sueldo
     */
    public function setBeneficios($beneficios)
    {
        $this->beneficios = $beneficios;

        return $this;
    }

    /**
     * Get beneficios
     *
     * @return int
     */
    public function getBeneficios()
    {
        return $this->beneficios;
    }

    /**
     * Set bonificaciones
     *
     * @param integer $bonificaciones
     *
     * @return Sueldo
     */
    public function setBonificaciones($bonificaciones)
    {
        $this->bonificaciones = $bonificaciones;

        return $this;
    }

    /**
     * Get bonificaciones
     *
     * @return int
     */
    public function getBonificaciones()
    {
        return $this->bonificaciones;
    }

    /**
     * Set vacaciones
     *
     * @param integer $vacaciones
     *
     * @return Sueldo
     */
    public function setVacaciones($vacaciones)
    {
        $this->vacaciones = $vacaciones;

        return $this;
    }

    /**
     * Get vacaciones
     *
     * @return int
     */
    public function getVacaciones()
    {
        return $this->vacaciones;
    }

    /**
     * Set totalH
     *
     * @param integer $totalH
     *
     * @return Sueldo
     */
    public function setTotalH($totalH)
    {
        $this->totalH = $totalH;

        return $this;
    }

    /**
     * Get totalH
     *
     * @return int
     */
    public function getTotalH()
    {
        return $this->totalH;
    }

    /**
     * Set totalS
     *
     * @param integer $totalS
     *
     * @return Sueldo
     */
    public function setTotalS($totalS)
    {
        $this->totalS = $totalS;

        return $this;
    }

    /**
     * Get totalS
     *
     * @return int
     */
    public function getTotalS()
    {
        return $this->totalS;
    }

    /**
     * Set totalgeneral
     *
     * @param integer $totalgeneral
     *
     * @return Sueldo
     */
    public function setTotalgeneral($totalgeneral)
    {
        $this->totalgeneral = $totalgeneral;

        return $this;
    }

    /**
     * Get totalgeneral
     *
     * @return int
     */
    public function getTotalgeneral()
    {
        return $this->totalgeneral;
    }
}


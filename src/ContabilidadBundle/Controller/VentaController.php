<?php

namespace ContabilidadBundle\Controller;

use ContabilidadBundle\ContabilidadBundle;
use ContabilidadBundle\Entity\Cliente;
use ContabilidadBundle\Entity\Ventac;
use ContabilidadBundle\Entity\Entidad;
use ContabilidadBundle\Entity\Ventad;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ContabilidadBundle\Form\VentaSinType;
use ContabilidadBundle\Repository\VentacRepository;
use ContabilidadBundle\Repository\VentadRepository;
use ContabilidadBundle\Repository\EntidadRepository;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Venta controller.
 *
 */
class VentaController extends Controller
{
    /**
     * Lists all Venta entities.
     *
     */
    public function indexAction(Request $request, $id_cliente, $mes, $ano)
    {

//        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$id_cliente));

        $clisel=$this->get('app.cliente');
        $clisel->setCliente($cliente);

        $nvocli=$this->get('app.cliente')->getCliente();

        //filtrar ventas del cliente y del periodo
        $ventaSins=$em->getRepository('ContabilidadBundle:Ventac')->filtrarVentasPeriodo(array(
            'cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano
        ));

        $ventas=[];

        foreach ($ventaSins as $ventaSin) {
//            echo 'Comprobante: ' . $ventaSin->getNsuc() . '-' . $ventaSin->getNpe() . '-'.$ventaSin->getNcomp().'<br>';
//            echo 'Entidad: '. $ventaSin->getEntidad()->getNombre() . '<br>';
//            echo 'Sucursal: '. $ventaSin->getSucursal()->getSucursal() . '<br>';
//            echo 'Moneda: '. $ventaSin->getMoneda()->getMoneda() . '<br>';
            $detalles = $ventaSin->getVentad();
            $suma=0;
            foreach ($detalles as $detalle){
                $monto= $detalle->getG10()+$detalle->getG5()+$detalle->getExe()+$detalle->getIva10()+$detalle->getIva5();
//                echo 'Monto = '.$monto.'<br>';
                $suma+=$monto;
            }
//            echo 'Suma = '.$suma.'<hr>';
            array_push($ventas, ['id'=>$ventaSin->getId(),
                'fecha'=>$ventaSin->getFecha(),
                'comprobante'=> $ventaSin->getNsuc() . '-' . $ventaSin->getNpe() . '-'.$ventaSin->getNcomp(),
                'cotiz'=>$ventaSin->getCotiz(),
                'comentario'=>$ventaSin->getComentario(),
                'total'=>$suma,
                'timbrado'=>$ventaSin->getTimbrado(),
                'condicion'=>$ventaSin->getCondicion()
            ]);
        }

        dump($ventas);

        return $this->render('@Contabilidad/ventas/index.html.twig', array(
            'ventaSins' => $ventas,
            'user'=>$user,
            'cliente'=>$cliente,
            'titulo'=>'Ventas '.$mes.' - '.$ano,
            'id_cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano,
            'botones'=>array(
                array('texto'=>'Nueva Venta', 'ruta'=>'venta_new')
            )
        ));
    }

    public function newAction($id_cliente, $mes, $ano, Request $request)
    {

        //        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        $em=$this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->find($id_cliente);

        $ventac = new Ventac();

        // si el formulario fue enviado por POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $formulario = $request->request;
            dump($formulario);
            die();
//            --------------- CABECERA --------------- //
            $ruc_entidad=$formulario->get('rucent');
            $dia=$formulario->get('dia');
            $cotiz=$formulario->get('cotiz');
            $id_moneda=$formulario->get('moneda');
            $condicion=$formulario->get('condicion');
            $nsuc=$formulario->get('nsuc');
            $npe=$formulario->get('npe');
            $ncomp=$formulario->get('ncomp');
            $comentario=$formulario->get('comentario');
            $anul=$formulario->get('anul');
//            --------------- DETALLE --------------- //
            $codCta=$formulario->get('codCta');
            $cuenta=$formulario->get('cuenta');
            $g10=$formulario->get('gravado10');
            $g5=$formulario->get('gravado5');
            $iva10=$formulario->get('iva10');
            $iva5=$formulario->get('iva5');
            $exe=$formulario->get('exento');
            $timbrado=$formulario->get('timbrado');
            $fecha_texto=$mes.'/'.$dia.'/'.$ano;
            $fecha=date_create($fecha_texto);
            $renta = $formulario->get('renta');


            $datos=['ruc_entidad'=>$ruc_entidad,
                'dia'=>$dia,
                'cotiz'=>$cotiz,
                'moneda'=>$id_moneda,
                'condicion'=>$condicion,
                'nsuc'=>$nsuc,
                'npe'=>$npe,
                'ncomp'=>$ncomp,
                'comentario'=>$comentario,
                'g10'=>$g10,
                'g5'=>$g5,
                'iva10'=>$iva10,
                'iva5'=>$iva5,
                'exe'=>$exe,
                'timbrado'=>$timbrado,
                'anul'=>$anul,
                'renta'=>$renta,
                'codCta'=>$codCta
            ];
            dump($datos);

            // Conseguir objetos
            $entidad=$em->getRepository('ContabilidadBundle:Entidad')->findOneBy(['ruc'=>$ruc_entidad]);
            $moneda=$em->getRepository('ContabilidadBundle:Moneda')->findOneBy(['id'=>$id_moneda]);
            $sucursal=$em->getRepository('ContabilidadBundle:Sucursal')->findOneBy(['id'=>1]);

            $ventac->setCliente($cliente)
                ->setUsuario($user)
                ->setSucursal($sucursal)
                ->setFecha($fecha)
                ->setEntidad($entidad)
                ->setNsuc($nsuc)
                ->setNpe($npe)
                ->setNcomp($ncomp)
                ->setMoneda($moneda)
                ->setCotiz($cotiz)
                ->setComentario($comentario)
                ->setG10($g10)
                ->setG5($g5)
                ->setIva10($iva10)
                ->setIva5($iva5)
                ->setExe($exe)
                ->setTimbrado($timbrado)
                ->setCondicion($condicion);
            $em->persist($ventac);



            $em->flush();
        }
        $datosDet=['111.01', 'CAJA M/L', '100000', '10000'];

//        $form = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventac);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em=$this->getDoctrine()->getManager();
//            $em->persist($ventac);
//            $em->flush();
//
//            return $this->redirectToRoute('venta_new', array(
//                'id_cliente' => $id_cliente, 'mes'=>$mes, 'ano'=>$ano));
//        }

        //muestra las cédulas almacenadas
        $imagenes=$em->getRepository('ContabilidadBundle:Cliente')->tieneCedula($cliente->getRuc());
        $cianv=$imagenes['cianv'];
        $cirev=$imagenes['cirev'];

        return $this->render('@Contabilidad/ventas/new.html.twig', array(
            'ventaSin' => $ventac,
            'user'=>$user,
            'cliente' => $cliente,
//            'form' => $form->createView(),
            'id_cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano,
            'cianv'=>$cianv,
            'cirev'=>$cirev,
            'titulo'=>'Nueva Venta - Periodo '.$mes.' - '.$ano,
            'tituloPag'=>'Nueva Venta',
            'datosDet'=>$datosDet,
            'botones'=>array(
                array('texto'=>'Volver', 'ruta'=>'venta_index')
            )
        ));
    }

    /**
     * Finds and displays a VentaSin entity.
     *
     */
    public function showAction(Request $request, $id_cliente, $mes, $ano, $id_venta)
    {

        //        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();
        $em=$this->getDoctrine()->getManager();

        $ventac=$em->getRepository('ContabilidadBundle:Ventac')->find($id_venta);

        $deleteForm = $this->createDeleteForm($id_cliente, $mes, $ano, $id_venta);

//        $form = $this->createForm('ContabilidadBundle\Form\VentacType', $ventac);
//        $form->handleRequest($request);

        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$ventac->getCliente()));




        return $this->render('@Contabilidad/ventas/show.html.twig', array(
            'ventac' => $ventac,
            'user'=>$user,
            'cliente' => $cliente,
            'delete_form' => $deleteForm->createView(),
            'id_cliente'=>$id_cliente,
            'id_venta'=>$id_venta,
            'mes'=>$mes,
            'ano'=>$ano,
//            'form'=>$form->createView(),
            'titulo'=>'Mostrar Venta '.$ventac->getNsuc().'-'.$ventac->getNpe().'-'.$ventac->getNcomp(),
            'botones'=>array(
                array('texto'=>'Editar', 'ruta'=>'venta_edit'),
                array('texto'=>'Volver', 'ruta'=>'venta_index')
            )
        ));
    }

    /**
     * Displays a form to edit an existing Ventac entity.
     *
     */
    public function editAction(Request $request, $id_cliente, $mes, $ano, $id_venta)
    {
        //        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();
        $em=$this->getDoctrine()->getManager();
        $ventac=$em->getRepository('ContabilidadBundle:Ventac')->find($id_venta);
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$ventac->getCliente()));

        $deleteForm = $this->createDeleteForm($id_cliente, $mes, $ano, $id_venta);

        //cargar el formulario por Ajax

        // si el formulario fue enviado por POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $formulario = $request->request;
            dump($formulario);
            die();
//            --------------- CABECERA --------------- //
            $ruc_entidad=$formulario->get('rucent');
            $dia=$formulario->get('dia');
            $cotiz=$formulario->get('cotiz');
            $id_moneda=$formulario->get('moneda');
            $condicion=$formulario->get('condicion');
            $nsuc=$formulario->get('nsuc');
            $npe=$formulario->get('npe');
            $ncomp=$formulario->get('ncomp');
            $comentario=$formulario->get('comentario');
            $anul=$formulario->get('anul');
//            --------------- DETALLE --------------- //
            $codCta=$formulario->get('codCta');
            $cuenta=$formulario->get('cuenta');
            $g10=$formulario->get('gravado10');
            $g5=$formulario->get('gravado5');
            $iva10=$formulario->get('iva10');
            $iva5=$formulario->get('iva5');
            $exe=$formulario->get('exento');
            $timbrado=$formulario->get('timbrado');
            $fecha_texto=$mes.'/'.$dia.'/'.$ano;
            $fecha=date_create($fecha_texto);
            $renta = $formulario->get('renta');


            $datos=['ruc_entidad'=>$ruc_entidad,
                'dia'=>$dia,
                'cotiz'=>$cotiz,
                'moneda'=>$id_moneda,
                'condicion'=>$condicion,
                'nsuc'=>$nsuc,
                'npe'=>$npe,
                'ncomp'=>$ncomp,
                'comentario'=>$comentario,
                'g10'=>$g10,
                'g5'=>$g5,
                'iva10'=>$iva10,
                'iva5'=>$iva5,
                'exe'=>$exe,
                'timbrado'=>$timbrado,
                'anul'=>$anul,
                'renta'=>$renta,
                'codCta'=>$codCta
            ];
            dump($datos);

            // Conseguir objetos
            $entidad=$em->getRepository('ContabilidadBundle:Entidad')->findOneBy(['ruc'=>$ruc_entidad]);
            $moneda=$em->getRepository('ContabilidadBundle:Moneda')->findOneBy(['id'=>$id_moneda]);
            $sucursal=$em->getRepository('ContabilidadBundle:Sucursal')->findOneBy(['id'=>1]);

            $ventac->setCliente($cliente)
                ->setUsuario($user)
                ->setSucursal($sucursal)
                ->setFecha($fecha)
                ->setEntidad($entidad)
                ->setNsuc($nsuc)
                ->setNpe($npe)
                ->setNcomp($ncomp)
                ->setMoneda($moneda)
                ->setCotiz($cotiz)
                ->setComentario($comentario)
                ->setG10($g10)
                ->setG5($g5)
                ->setIva10($iva10)
                ->setIva5($iva5)
                ->setExe($exe)
                ->setTimbrado($timbrado)
                ->setCondicion($condicion);
            $em->persist($ventac);



            $em->flush();
        }
        $datosDet=['111.01', 'CAJA M/L', '100000', '10000'];

//        $form = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventac);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em=$this->getDoctrine()->getManager();
//            $em->persist($ventac);
//            $em->flush();
//
//            return $this->redirectToRoute('venta_new', array(
//                'id_cliente' => $id_cliente, 'mes'=>$mes, 'ano'=>$ano));
//        }

        //muestra las cédulas almacenadas
        $imagenes=$em->getRepository('ContabilidadBundle:Cliente')->tieneCedula($cliente->getRuc());
        $cianv=$imagenes['cianv'];
        $cirev=$imagenes['cirev'];


        return $this->render('@Contabilidad/ventas/new.html.twig', array(
            'ventaSin' => $ventac,
            'user'=>$user,
            'cliente' => $cliente,
            'cianv'=>$cianv,
            'cirev'=>$cirev,
            'datosDet'=>$datosDet,
            'id_cliente'=>$id_cliente,
            'id_venta'=>$id_venta,
            'mes'=>$mes,
            'ano'=>$ano,
//            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
//            'form'=>$form->createView(),
            'titulo'=>'Edición de Ventas',
            'tituloPag'=>'Editar Venta',
            'botones'=>array(
                array('texto'=>'Volver', 'ruta'=>'venta_show'),
            )
        ));
    }

    /**
     * Deletes a Ventac entity.
     *
     */
    public function deleteAction(Request $request, $id_cliente, $mes, $ano, $id_venta)
    {
//        dump($request->request());
//        die();
        $ventac=$this->getDoctrine()->getRepository('ContabilidadBundle:Ventac')->find($id_venta);
        $form = $this->createDeleteForm($id_cliente, $mes, $ano, $id_venta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ventac);
            $em->flush();
        }

        return $this->redirectToRoute('venta_index', array(
            'id_cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano
        ));
    }

    /**
     * Creates a form to delete a Ventac entity.
     *
     * @param Ventac $ventac The Ventac entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id_cliente, $mes, $ano, $id_venta)
    {
        $parametros=array('id_venta' => $id_venta,
            'id_cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano
        );
//        dump($parametros);
//        die();
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('venta_delete', $parametros))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function getEntidadAction($ruc)
    {
        $em=$this->getDoctrine()->getManager();
       // ----------- METODO 1 -------------------
        $entidad =  $em->getRepository('ContabilidadBundle:Entidad')->findOneBy(array('ruc'=>$ruc));

        if($entidad){
            $respuesta = array(
                'ruc'=>$entidad->getRuc(),
                'dv'=>$entidad->getDv(),
                'nombre'=>$entidad->getNombre(),
                'id'=>$entidad->getId()
            );
        } else {
            $respuesta=null;
        }

        return new JsonResponse($respuesta);

    }

    public function getCuentaAction($cod)
    {
        $em=$this->getDoctrine()->getManager();
        // ----------- METODO 1 -------------------
        $codcta =  $em->getRepository('ContabilidadBundle:PlanCta')->findOneBy(array('codigo'=>$cod));

        if($codcta){
            $respuesta = array(
                'codigo'=>$codcta->getCodigo(),
                'cuenta'=>$codcta->getcuenta(),
                'imputable'=>$codcta->getImputable(),
                'renta'=>$codcta->getRenta()
            );
        } else {
            $respuesta=null;
        }

        return new JsonResponse($respuesta);

    }

    public function getPlanctaAction($cod)
    {
        $em=$this->getDoctrine()->getManager();
        // ----------- METODO 1 -------------------
        $planctas =  $em->getRepository('ContabilidadBundle:PlanCta')->findAll();
        $respuesta=[];
        foreach ($planctas as $cta){
            array_push($respuesta, [
                'codigo'=>$cta->getCodigo(),
                'cuenta'=>$cta->getcuenta()
            ]);
        }

        return new JsonResponse($respuesta);

    }

    public function guardarVentaAction(Request $request)
    {
        // Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();

        // --------------- CABECERA --------------- //
        $id_cliente=$_POST['idcliente'];
        $tipo_comp=$_POST['tipo_comp'];
        $dia=$_POST['dia'];
        $mes=$_POST['mes'];
        $ano=$_POST['ano'];
        $fecha_texto=$mes.'/'.$dia.'/'.$ano;
        $fecha=date_create($fecha_texto);
        $ruc_entidad=$_POST['rucent'];
        $nsuc=$_POST['nsuc'];
        $npe=$_POST['npe'];
        $ncomp=$_POST['ncomp'];
        $timbrado=$_POST['timbrado'];
        $condicion=$_POST['condicion'];
        $id_moneda=$_POST['moneda'];
        $cotiz=$_POST['cotiz'];
        $anul=$_POST['anul'];
        $anulado=$anul==='true'?true:false;
        $comentario=$_POST['comentario'];
        if($anul=='false'){
            $detalles = $_POST['detalle'];
        }
        $respuesta=$anulado;
        $em=$this->getDoctrine()->getManager();

        // Conseguir objetos
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->find($id_cliente);
        $entidad=$em->getRepository('ContabilidadBundle:Entidad')->findOneBy(['ruc'=>$ruc_entidad]);
        $moneda=$em->getRepository('ContabilidadBundle:Moneda')->findOneBy(['id'=>$id_moneda]);
        $sucursal=$em->getRepository('ContabilidadBundle:Sucursal')->findOneBy(['id'=>1]);

        // --------- CABECERA ------------ //

        $ventac = new Ventac();
        $ventac->setCliente($cliente)
            ->setUsuario($user)
            ->setSucursal($sucursal)
            ->setFecha($fecha)
            ->setEntidad($entidad)
            ->setNsuc($nsuc)
            ->setNpe($npe)
            ->setNcomp($ncomp)
            ->setTimbrado($timbrado)
            ->setCondicion($condicion)
            ->setMoneda($moneda)
            ->setCotiz($cotiz)
            ->setAnul($anulado)
            ->setComentario($comentario);

        $em->persist($ventac);

        // --------- DETALLE ------------ //
        if(isset($detalles)){
            foreach ($detalles as $detalle) {
                $ventad = new Ventad();
                $codigo = $detalle['codigo'];
                $cuenta=$em->getRepository('ContabilidadBundle:PlanCta')->findOneBy(['codigo'=>$codigo]);

                $ventad->setVentac($ventac)
                    ->setNcuenta($cuenta)
                    ->setG10($detalle['g10'])
                    ->setG5($detalle['g5'])
                    ->setExe($detalle['exe'])
                    ->setIva10($detalle['iva10'])
                    ->setIva5($detalle['iva5'])
                    ->setAfecta($detalle['afecta']);


                $em->persist($ventad);
            }
        }

        $em->flush();
        $respuesta = $ventac;

        return new JsonResponse($respuesta);
    }

    public function getVentaAction($id_venta)
    {
        $em=$this->getDoctrine()->getManager();
        // ----------- METODO 1 -------------------
        $venta =  $em->getRepository('ContabilidadBundle:Ventac')->find($id_venta);
        $ventadet=[];
        $detalles=$venta->getVentad();
        foreach ($detalles as $detalle){
            array_push($ventadet, [
                'id'=>$detalle->getId(),
                'codigo'=>$detalle->getNcuenta()->getCodigo(),
                'cuenta'=>$detalle->getNcuenta()->getCuenta(),
                'g10'=>$detalle->getG10(),
                'g5'=>$detalle->getG5(),
                'iva10'=>$detalle->getIva10(),
                'iva5'=>$detalle->getIva5(),
                'exe'=>$detalle->getExe(),
                'afecta'=>$detalle->getAfecta()
            ]);
        }
//        dump($ventadet);
//        die();
        $respuesta=['fecha'=>$venta->getFecha(),
            'ruc'=>$venta->getEntidad()->getRuc(),
            'dv'=>$venta->getEntidad()->getDv(),
            'cliente'=>$venta->getEntidad()->getNombre(),
            'nsuc'=>$venta->getNsuc(),
            'npe'=>$venta->getNpe(),
            'ncomp'=>$venta->getNcomp(),
            'timbrado'=>$venta->getTimbrado(),
            'condicion'=>$venta->getCondicion(),
            'moneda'=>$venta->getMoneda()->getId(),
            'cotiz'=>$venta->getCotiz(),
            'anul'=>$venta->getAnul(),
            'comentario'=>$venta->getComentario(),
            'detalle'=>$ventadet
        ];

//        dump($respuesta);
//        die();
        return new JsonResponse($respuesta);

    }

}

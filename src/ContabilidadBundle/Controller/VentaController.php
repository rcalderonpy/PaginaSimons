<?php

namespace ContabilidadBundle\Controller;

use ContabilidadBundle\ContabilidadBundle;
use ContabilidadBundle\Entity\Cliente;
use ContabilidadBundle\Entity\VentaCab;
use ContabilidadBundle\Entity\Entidad;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ContabilidadBundle\Form\VentaSinType;
use ContabilidadBundle\Repository\VentaCabRepository;
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
//        $ventaSins = $em->getRepository('ContabilidadBundle:VentaCab')->findAll();
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$id_cliente));

        $clisel=$this->get('app.cliente');
        $clisel->setCliente($cliente);

        $nvocli=$this->get('app.cliente')->getCliente();
//        dump($nvocli);
//        die();

        //filtrar ventas del cliente
        $em=$this->getDoctrine()->getManager();
        $ventaSins=$em->getRepository('ContabilidadBundle:VentaCab')->filtrarVentasPeriodo(array(
            'cliente'=>$id_cliente, 'mes'=>$mes, 'ano'=>$ano
        ));

        return $this->render('@Contabilidad/ventas/index.html.twig', array(
            'ventaSins' => $ventaSins,
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

        $ventaCab = new VentaCab();

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

            $ventaCab->setCliente($cliente)
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
            $em->persist($ventaCab);



            $em->flush();
        }
        $datosDet=['111.01', 'CAJA M/L', '100000', '10000'];

//        $form = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaCab);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em=$this->getDoctrine()->getManager();
//            $em->persist($ventaCab);
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
            'ventaSin' => $ventaCab,
            'user'=>$user,
            'cliente' => $cliente,
//            'form' => $form->createView(),
            'id_cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano,
            'cianv'=>$cianv,
            'cirev'=>$cirev,
            'titulo'=>'Nueva Venta - Periodo '.$mes.' - '.$ano,
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
//        dump($ventaCab);
//        die();
        //        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();
        $em=$this->getDoctrine()->getManager();

        $ventaCab=$em->getRepository('ContabilidadBundle:VentaCab')->find($id_venta);

        $deleteForm = $this->createDeleteForm($ventaCab);
        $form = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaCab);
        $form->handleRequest($request);


        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$ventaCab->getCliente()));


        return $this->render('@Contabilidad/ventas/show.html.twig', array(
            'ventaSin' => $ventaCab,
            'user'=>$user,
            'cliente' => $cliente,
            'delete_form' => $deleteForm->createView(),
            'id_cliente'=>$id_cliente,
            'id_venta'=>$id_venta,
            'mes'=>$mes,
            'ano'=>$ano,
            'form'=>$form->createView(),
            'titulo'=>'Libro de Ventas',
            'botones'=>array(
                array('texto'=>'Editar', 'ruta'=>'venta_edit'),
                array('texto'=>'Volver', 'ruta'=>'venta_index')
            )
        ));
    }

    /**
     * Displays a form to edit an existing VentaCab entity.
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
        $ventaCab=$em->getRepository('ContabilidadBundle:VentaCab')->find($id_venta);

        $deleteForm = $this->createDeleteForm($ventaCab);
        $editForm = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaCab);
        $editForm->handleRequest($request);
        $form = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaCab);
        $form->handleRequest($request);

        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$ventaCab->getCliente()));


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($ventaCab);
            $em->flush();

            return $this->redirectToRoute('venta_show', array(
                'id_venta' => $id_venta,
                'form'=>$form->createView()
            ));
        }

        return $this->render('@Contabilidad/ventas/edit.html.twig', array(
            'ventaSin' => $ventaCab,
            'user'=>$user,
            'cliente' => $cliente,
            'id_cliente'=>$id_cliente,
            'id_venta'=>$id_venta,
            'mes'=>$mes,
            'ano'=>$ano,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'form'=>$form->createView(),
            'titulo'=>'Libro de Ventas',
            'botones'=>array(
                array('texto'=>'Volver', 'ruta'=>'venta_show'),
            )
        ));
    }

    /**
     * Deletes a VentaCab entity.
     *
     */
    public function deleteAction(Request $request, VentaCab $ventaCab)
    {
        $form = $this->createDeleteForm($ventaCab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ventaCab);
            $em->flush();
        }

        return $this->redirectToRoute('venta_index');
    }

    /**
     * Creates a form to delete a VentaCab entity.
     *
     * @param VentaCab $ventaCab The VentaCab entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VentaSin $ventaCab)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('venta_delete', array('id' => $ventaCab->getId())))
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

    public function guardarVentaAction(Request $request)
    {
        // Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();

        $ventaCab = new VentaCab();


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
        $comentario=$_POST['comentario'];

        // --------------- DETALLE --------------- //

        $datos=[
            'dia'=>$dia,
            'mes'=>$mes,
            'ano'=>$ano,
            'fecha'=>$fecha,
            'ruc_entidad'=>$ruc_entidad,
            'nsuc'=>$nsuc,
            'npe'=>$npe,
            'ncomp'=>$ncomp,
            'timbrado'=>$timbrado,
            'condicion'=>$condicion,
            'moneda'=>$id_moneda,
            'cotiz'=>$cotiz,
            'anul'=>$anul,
            'comentario'=>$comentario
        ];

        $em=$this->getDoctrine()->getManager();

        // Conseguir objetos
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->find($id_cliente);
        $entidad=$em->getRepository('ContabilidadBundle:Entidad')->findOneBy(['ruc'=>$ruc_entidad]);
        $moneda=$em->getRepository('ContabilidadBundle:Moneda')->findOneBy(['id'=>$id_moneda]);
        $sucursal=$em->getRepository('ContabilidadBundle:Sucursal')->findOneBy(['id'=>1]);

        $ventaCab->setCliente($cliente)
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
            ->setAnul($anul)
            ->setComentario($comentario);

        $em->persist($ventaCab);

        $em->flush();
        $respuesta = 'Datos almacenados exitosamente';

        return new JsonResponse($respuesta);
    }

}

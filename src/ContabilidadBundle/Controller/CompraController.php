<?php

namespace ContabilidadBundle\Controller;

use ContabilidadBundle\Entity\Comprac;
use ContabilidadBundle\Entity\Comprad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ContabilidadBundle\Form\CompracType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Comprac controller.
 *
 */
class CompraController extends Controller
{
    /**
     * Lists all compras entities.
     *
     */
    public function indexAction(Request $request, $id_cliente, $mes, $ano)
    {

        // Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$id_cliente));

        $clisel=$this->get('app.cliente');
        $clisel->setCliente($cliente);

        $nvocli=$this->get('app.cliente')->getCliente();

        //filtrar compras del cliente y del periodo
        $comprascabs=$em->getRepository('ContabilidadBundle:Comprac')->filtrarComprasPeriodo(array(
            'cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano
        ));

        $compras=[];

        foreach ($comprascabs as $comprascab) {
//            echo 'Comprobante: ' . $comprascab->getNsuc() . '-' . $comprascab->getNpe() . '-'.$comprascab->getNcomp().'<br>';
//            echo 'Entidad: '. $comprascab->getEntidad()->getNombre() . '<br>';
//            echo 'Sucursal: '. $comprascab->getSucursal()->getSucursal() . '<br>';
//            echo 'Moneda: '. $comprascab->getMoneda()->getMoneda() . '<br>';
            $detalles = $comprascab->getComprad();
            $suma=0;
            foreach ($detalles as $detalle){
                $monto= $detalle->getG10()+$detalle->getG5()+$detalle->getExe()+$detalle->getIva10()+$detalle->getIva5();
//                echo 'Monto = '.$monto.'<br>';
                $suma+=$monto;
            }
//            echo 'Suma = '.$suma.'<hr>';
            array_push($compras, ['id'=>$comprascab->getId(),
                'fecha'=>$comprascab->getFecha(),
                'comprobante'=> $comprascab->getNsuc() . '-' . $comprascab->getNpe() . '-'.$comprascab->getNcomp(),
                'cotiz'=>$comprascab->getCotiz(),
                'comentario'=>$comprascab->getComentario(),
                'total'=>$suma,
                'timbrado'=>$comprascab->getTimbrado(),
                'condicion'=>$comprascab->getCondicion(),
                'entidad'=>$comprascab->getEntidad()->getNombre()
            ]);
        }

        dump($compras);

        return $this->render('@Contabilidad/compras/index.html.twig', array(
            'compras' => $compras,
            'user'=>$user,
            'cliente'=>$cliente,
            'titulo'=>'Compras '.$mes.' - '.$ano,
            'id_cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano,
            'botones'=>array(
                array('texto'=>'Nueva Compra', 'ruta'=>'compra_new')
            )
        ));
    }

    /**
     * Creates a new compras entity.
     *
     */
    public function newAction($id_cliente, $mes, $ano, Request $request)
    {

        //        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        $em=$this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->find($id_cliente);

//
//            // Conseguir objetos
//            $entidad=$em->getRepository('ContabilidadBundle:Entidad')->findOneBy(['ruc'=>$ruc_entidad]);
//            $moneda=$em->getRepository('ContabilidadBundle:Moneda')->findOneBy(['id'=>$id_moneda]);
        $sucursal=$em->getRepository('ContabilidadBundle:Sucursal')->findOneBy(['id'=>1]);

        $comprac = new Comprac();
        $comprac->setSucursal($sucursal);
        $comprac->setCliente($cliente);
        $comprac->setUsuario($user);
        $form = $this->createForm('ContabilidadBundle\Form\CompracType', $comprac);
        $form->handleRequest($request);


//        $comprad = new Comprad();
//        $comprad->setComprac($comprac);
//        $form_det = $this->createForm('ContabilidadBundle\Form\CompradType', $comprad);
//        $form_det->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dia=$form['dia']->getData();
            $fecha_texto=$mes.'/'.$dia .'/'.$ano;
            $fecha=date_create($fecha_texto);
            $comprac->setFecha($fecha);
            $detalles=$comprac->getComprad(); //cuenta la cantidad de filas detalle para agregar objeto $comprac
            foreach ($detalles as $detalle){
                $detalle->setComprac($comprac);
            }

//            dump(count($comprac->getComprad()));
//            die();

            $em->persist($comprac);
            $em->flush();

            return $this->redirectToRoute('compra_new', array(
                'id_cliente' => $id_cliente, 'mes'=>$mes, 'ano'=>$ano));
        }

        //muestra las cédulas almacenadas
        $imagenes=$em->getRepository('ContabilidadBundle:Cliente')->tieneCedula($cliente->getRuc());
        $cianv=$imagenes['cianv'];
        $cirev=$imagenes['cirev'];

        return $this->render('@Contabilidad/compras/new.html.twig', array(
            'compra' => $comprac,
            'user'=>$user,
            'cliente' => $cliente,
//            'form' => $form->createView(),
            'id_cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano,
            'form'=>$form->createView(),
//            'form_det'=>$form_det->createView(),
            'cianv'=>$cianv,
            'cirev'=>$cirev,
            'titulo'=>'Nueva Compra - Periodo '.$mes.' - '.$ano,
            'tituloPag'=>'Nueva Compra',
//            'datosDet'=>$datosDet,
            'botones'=>array(
                array('texto'=>'Volver', 'ruta'=>'compra_index')
            )
        ));
    }

    /**
     * Finds and displays a compras entity.
     *
     */
    public function showAction(Request $request, $id_cliente, $mes, $ano, $id_compra)
    {

        //        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();
        $em=$this->getDoctrine()->getManager();

        $comprac=$em->getRepository('ContabilidadBundle:Comprac')->find($id_compra);

        $deleteForm = $this->createDeleteForm($id_cliente, $mes, $ano, $id_compra);


        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->find($id_cliente);

        return $this->render('@Contabilidad/compras/show.html.twig', array(
            'comprac' => $comprac,
            'user'=>$user,
            'cliente' => $cliente,
            'delete_form' => $deleteForm->createView(),
            'id_cliente'=>$id_cliente,
            'id_compra'=>$id_compra,
            'mes'=>$mes,
            'ano'=>$ano,
            'titulo'=>'Mostrar Compra '.$comprac->getNsuc().'-'.$comprac->getNpe().'-'.$comprac->getNcomp(),
            'botones'=>array(
                array('texto'=>'Editar', 'ruta'=>'compra_edit', 'param'=>"'id_compra'"),
                array('texto'=>'Volver', 'ruta'=>'compra_index', 'param'=>"'id_compra'")
            )
        ));
    }


    /**
     * Displays a form to edit an existing compras entity.
     *
     */
    public function editAction(Request $request, $id_cliente, $mes, $ano, $id_compra)
    {
        // Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();
        $em=$this->getDoctrine()->getManager();
        $comprac=$em->getRepository('ContabilidadBundle:Comprac')->find($id_compra);
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->find($id_cliente);

        $deleteForm = $this->createDeleteForm($id_cliente, $mes, $ano, $id_compra);

        // si el formulario fue enviado por POST

        $form = $this->createForm('ContabilidadBundle\Form\CompracType', $comprac);
        $form->handleRequest($request);
//        $fecha=$comprac->getFecha()->getTimestamp();
//        $dia=date('j', $fecha);
//        $form['dia']->setData($dia);

//        dump($form);
//        die();


        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($comprac);
            $em->flush();
            return $this->redirectToRoute('compra_show', array(
                'id_cliente' => $id_cliente, 'mes'=>$mes, 'ano'=>$ano, 'id_compra'=>$id_compra));
        }

        //muestra las cédulas almacenadas
        $imagenes=$em->getRepository('ContabilidadBundle:Cliente')->tieneCedula($cliente->getRuc());
        $cianv=$imagenes['cianv'];
        $cirev=$imagenes['cirev'];

        return $this->render('@Contabilidad/compras/new.html.twig', array(
            'comprac' => $comprac,
            'user'=>$user,
            'cliente' => $cliente,
            'cianv'=>$cianv,
            'cirev'=>$cirev,
//            'datosDet'=>$datosDet,
            'id_cliente'=>$id_cliente,
            'id_compra'=>$id_compra,
            'mes'=>$mes,
            'ano'=>$ano,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
//            'form'=>$form->createView(),
            'titulo'=>'Edición de Compras',
            'tituloPag'=>'Editar Compra',
            'botones'=>array(
                array('texto'=>'Volver', 'ruta'=>'compra_show'),
            )
        ));
    }

    /**
     * Deletes a compras entity.
     *
     */
    public function deleteAction(Request $request, $id_cliente, $mes, $ano, $id_compra)
    {

        $comprac=$this->getDoctrine()->getRepository('ContabilidadBundle:Comprac')->find($id_compra);
        $form = $this->createDeleteForm($id_cliente, $mes, $ano, $id_compra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comprac);
            $em->flush();
        }

        return $this->redirectToRoute('compra_index', array(
            'id_cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano
        ));
    }

    /**
     * Creates a form to delete a compras entity.
     *
     * @param Comprac $comprac The compras entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id_cliente, $mes, $ano, $id_compra)
    {
        $parametros=array('id_compra' => $id_compra,
            'id_cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano
        );

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('compra_delete', $parametros))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}

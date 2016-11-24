<?php

namespace ContabilidadBundle\Controller;

use ContabilidadBundle\ContabilidadBundle;
use ContabilidadBundle\Entity\Cliente;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ContabilidadBundle\Entity\VentaSin;
use ContabilidadBundle\Form\VentaSinType;
use ContabilidadBundle\Repository\VentaSinRepository;
use ContabilidadBundle\Repository\EntidadRepository;


/**
 * VentaSin controller.
 *
 */
class VentaSinController extends Controller
{
    /**
     * Lists all VentaSin entities.
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
//        $ventaSins = $em->getRepository('ContabilidadBundle:VentaSin')->findAll();
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$id_cliente));

        $clisel=$this->get('app.cliente');
        $clisel->setCliente($cliente);

        $nvocli=$this->get('app.cliente')->getCliente();
//        dump($nvocli);
//        die();

        //filtrar ventas del cliente
        $em=$this->getDoctrine()->getManager();
        $ventaSins=$em->getRepository('ContabilidadBundle:VentaSin')->filtrarVentasPeriodo(array(
            'cliente'=>$id_cliente, 'mes'=>$mes, 'ano'=>$ano
        ));

        return $this->render('ventasin/index.html.twig', array(
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
//
//    public function printIndexAction(Request $request)
//    {
//        $last_username='hola';
//        $this->get('knp_snappy.pdf')->generateFromHtml(
//            $this->renderView(
//                '@App/Default/login.html.twig',
//                array(
//                    'last_username'  => $last_username
//                )
//            ),
//            '/lista.pdf'
//        );
//    }

    /**
     * Creates a new VentaSin entity.
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

        $ventaSin = new VentaSin();
        $ventaSin->setCliente($cliente);
        $ventaSin->setUsuario($user);
        $form = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaSin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($ventaSin);
            $em->flush();

            return $this->redirectToRoute('venta_new', array(
                'id_cliente' => $id_cliente, 'mes'=>$mes, 'ano'=>$ano));
        }

        return $this->render('ventasin/new.html.twig', array(
            'ventaSin' => $ventaSin,
            'user'=>$user,
            'cliente' => $cliente,
            'form' => $form->createView(),
            'id_cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano,
            'titulo'=>'Libro de Ventas',
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
//        dump($ventaSin);
//        die();
        //        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();
        $em=$this->getDoctrine()->getManager();

        $ventaSin=$em->getRepository('ContabilidadBundle:VentaSin')->find($id_venta);

//        dump($ventaSin);
//        die();
        $deleteForm = $this->createDeleteForm($ventaSin);
        $form = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaSin);
        $form->handleRequest($request);


        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$ventaSin->getCliente()));


        return $this->render('ventasin/show.html.twig', array(
            'ventaSin' => $ventaSin,
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
     * Displays a form to edit an existing VentaSin entity.
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
        $ventaSin=$em->getRepository('ContabilidadBundle:VentaSin')->find($id_venta);

        $deleteForm = $this->createDeleteForm($ventaSin);
        $editForm = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaSin);
        $editForm->handleRequest($request);
        $form = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaSin);
        $form->handleRequest($request);

        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$ventaSin->getCliente()));


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($ventaSin);
            $em->flush();

            return $this->redirectToRoute('venta_show', array(
                'id_venta' => $id_venta,
                'form'=>$form->createView()
            ));
        }

        return $this->render('ventasin/edit.html.twig', array(
            'ventaSin' => $ventaSin,
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
     * Deletes a VentaSin entity.
     *
     */
    public function deleteAction(Request $request, VentaSin $ventaSin)
    {
        $form = $this->createDeleteForm($ventaSin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ventaSin);
            $em->flush();
        }

        return $this->redirectToRoute('venta_index');
    }

    /**
     * Creates a form to delete a VentaSin entity.
     *
     * @param VentaSin $ventaSin The VentaSin entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VentaSin $ventaSin)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('venta_delete', array('id' => $ventaSin->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace ContabilidadBundle\Controller;

use ContabilidadBundle\ContabilidadBundle;
use ContabilidadBundle\Entity\Cliente;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ContabilidadBundle\Entity\VentaSin;
use ContabilidadBundle\Form\VentaSinType;
use ContabilidadBundle\Repository\VentaSinRepository;


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
//        dump($request);
//        die();

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

        $periodo='02 - 2016';

        return $this->render('ventasin/index.html.twig', array(
            'ventaSins' => $ventaSins,
            'user'=>$user,
            'cliente'=>$cliente,
            'titulo'=>'Libro de Ventas',
            'botones'=>array(
                array('texto'=>'Nueva Venta', 'ruta'=>'venta_new', 'id'=>$cliente->getId())
            ),
            'periodo'=>$periodo
        ));
    }

    /**
     * Creates a new VentaSin entity.
     *
     */
    public function newAction(Cliente $cliente, Request $request)
    {
//        dump($request);
//        die();
        //        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        $ventaSin = new VentaSin();
        $ventaSin->setCliente($cliente);
        $ventaSin->setUsuario($user);
        $form = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaSin);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($ventaSin);
            $em->flush();

            return $this->redirectToRoute('venta_new', array('id' => $cliente->getId()));
        }

        return $this->render('ventasin/new.html.twig', array(
            'ventaSin' => $ventaSin,
            'user'=>$user,
            'cliente' => $cliente,
            'form' => $form->createView(),
            'titulo'=>'Libro de Ventas',
            'botones'=>array(
                array('texto'=>'Volver', 'ruta'=>'venta_index', 'id'=>$cliente->getId())
            )
        ));
    }

    /**
     * Finds and displays a VentaSin entity.
     *
     */
    public function showAction(VentaSin $ventaSin, Request $request)
    {
//        dump($ventaSin);
//        die();
        //        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

//        dump($ventaSin);
//        die();
        $deleteForm = $this->createDeleteForm($ventaSin);
        $form = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaSin);
        $form->handleRequest($request);

        $em=$this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$ventaSin->getCliente()));


        return $this->render('ventasin/show.html.twig', array(
            'ventaSin' => $ventaSin,
            'user'=>$user,
            'cliente' => $cliente,
            'delete_form' => $deleteForm->createView(),
            'form'=>$form->createView(),
            'titulo'=>'Libro de Ventas',
            'botones'=>array(
                array('texto'=>'Editar', 'ruta'=>'venta_edit', 'id'=>$ventaSin->getId()),
                array('texto'=>'Volver', 'ruta'=>'venta_index', 'id'=>$cliente->getId())
            )
        ));
    }

    /**
     * Displays a form to edit an existing VentaSin entity.
     *
     */
    public function editAction(Request $request, VentaSin $ventaSin)
    {
        //        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        $deleteForm = $this->createDeleteForm($ventaSin);
        $editForm = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaSin);
        $editForm->handleRequest($request);
        $form = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaSin);
        $form->handleRequest($request);

        $em=$this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$ventaSin->getCliente()));


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($ventaSin);
            $em->flush();

            return $this->redirectToRoute('venta_show', array(
                'id' => $ventaSin->getId(),
                'form'=>$form
            ));
        }

        return $this->render('ventasin/edit.html.twig', array(
            'ventaSin' => $ventaSin,
            'user'=>$user,
            'cliente' => $cliente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'form'=>$form->createView(),
            'titulo'=>'Libro de Ventas',
            'botones'=>array(
                array('texto'=>'Volver', 'ruta'=>'venta_index', 'id'=>$cliente->getId()),
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

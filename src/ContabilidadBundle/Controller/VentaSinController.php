<?php

namespace ContabilidadBundle\Controller;

use ContabilidadBundle\ContabilidadBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ContabilidadBundle\Entity\VentaSin;
use ContabilidadBundle\Form\VentaSinType;

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
    public function indexAction(Request $request)
    {
//        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $ventaSins = $em->getRepository('ContabilidadBundle:VentaSin')->findAll();
//        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneById($request->request->get('id'));
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$_GET['id']));


        return $this->render('ventasin/index.html.twig', array(
            'ventaSins' => $ventaSins,
            'user'=>$user,
            'cliente'=>$cliente,
            'titulo'=>'Libro de Ventas',
            'botones'=>array(
                array('texto'=>'Nueva Venta', 'ruta'=>'venta_new')
            )
        ));
    }

    /**
     * Creates a new VentaSin entity.
     *
     */
    public function newAction(Request $request)
    {
        dump($request);
        die();
        //        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        $ventaSin = new VentaSin();
        $form = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaSin);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$request->request->get('id')));

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($ventaSin);
            $em->flush();

            return $this->redirectToRoute('venta_show', array('id' => $ventaSin->getId()));
        }

        return $this->render('ventasin/new.html.twig', array(
            'ventaSin' => $ventaSin,
            'user'=>$user,
            'cliente' => $cliente,
            'form' => $form->createView(),
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
    public function showAction(VentaSin $ventaSin, Request $request)
    {
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
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>2));


        return $this->render('ventasin/show.html.twig', array(
            'ventaSin' => $ventaSin,
            'user'=>$user,
            'cliente' => $cliente,
            'delete_form' => $deleteForm->createView(),
            'form'=>$form->createView(),
            'titulo'=>'Libro de Ventas',
            'botones'=>array(
                array('texto'=>'Editar', 'ruta'=>'venta_edit', 'id'=>$ventaSin->getId()),
                array('texto'=>'Volver', 'ruta'=>'venta_index')
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

        $em = $this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneById($request->request->get('id'));


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
                array('texto'=>'Volver', 'ruta'=>'venta_index'),
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

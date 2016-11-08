<?php

namespace ContabilidadBundle\Controller;

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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ventaSins = $em->getRepository('ContabilidadBundle:VentaSin')->findAll();

        return $this->render('ventasin/index.html.twig', array(
            'ventaSins' => $ventaSins,
        ));
    }

    /**
     * Creates a new VentaSin entity.
     *
     */
    public function newAction(Request $request)
    {
        $ventaSin = new VentaSin();
        $form = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaSin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ventaSin);
            $em->flush();

            return $this->redirectToRoute('venta_show', array('id' => $ventaSin->getId()));
        }

        return $this->render('ventasin/new.html.twig', array(
            'ventaSin' => $ventaSin,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a VentaSin entity.
     *
     */
    public function showAction(VentaSin $ventaSin)
    {
        $deleteForm = $this->createDeleteForm($ventaSin);

        return $this->render('ventasin/show.html.twig', array(
            'ventaSin' => $ventaSin,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing VentaSin entity.
     *
     */
    public function editAction(Request $request, VentaSin $ventaSin)
    {
        $deleteForm = $this->createDeleteForm($ventaSin);
        $editForm = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaSin);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ventaSin);
            $em->flush();

            return $this->redirectToRoute('venta_edit', array('id' => $ventaSin->getId()));
        }

        return $this->render('ventasin/edit.html.twig', array(
            'ventaSin' => $ventaSin,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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

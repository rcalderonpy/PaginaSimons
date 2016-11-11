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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ventaSins = $em->getRepository('ContabilidadBundle:VentaSin')->findAll();
//        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findAll();
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>2));

//        dump($cliente);
//        die();


        return $this->render('ventasin/index.html.twig', array(
            'ventaSins' => $ventaSins,
            'cliente'=>$cliente
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
        $form = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaSin);

        $em=$this->getDoctrine()->getEntityManager();
        $entidad=$em->getRepository('Entidad')->findOneBy('id');


        return $this->render('ventasin/show.html.twig', array(
            'ventaSin' => $ventaSin,
            'delete_form' => $deleteForm->createView(),
            'form'=>$form->createView()
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
        $form = $this->createForm('ContabilidadBundle\Form\VentaSinType', $ventaSin);
        $form->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ventaSin);
            $em->flush();

            return $this->redirectToRoute('venta_show', array(
                'id' => $ventaSin->getId(),
                'form'=>$form
            ));
        }

        return $this->render('ventasin/edit.html.twig', array(
            'ventaSin' => $ventaSin,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'form'=>$form->createView()
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

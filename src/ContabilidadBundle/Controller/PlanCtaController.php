<?php

namespace ContabilidadBundle\Controller;

use ContabilidadBundle\Entity\PlanCta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Plancta controller.
 *
 */
class PlanCtaController extends Controller
{
    /**
     * Lists all planCta entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $planCtas = $em->getRepository('Cuenta.php')->findAll();

        return $this->render('@Contabilidad/plancta/index.html.twig', array(
            'planCtas' => $planCtas,
        ));
    }

    /**
     * Creates a new planCta entity.
     *
     */
    public function newAction(Request $request)
    {
        $planCta = new Plancta();
        $form = $this->createForm('ContabilidadBundle\Form\PlanCtaType', $planCta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($planCta);
            $em->flush($planCta);

            return $this->redirectToRoute('plancta_show', array('id' => $planCta->getId()));
        }

        return $this->render('@Contabilidad/plancta/new.html.twig', array(
            'planCta' => $planCta,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a planCta entity.
     *
     */
    public function showAction(PlanCta $planCta)
    {
        $deleteForm = $this->createDeleteForm($planCta);

        return $this->render('@Contabilidad/plancta/show.html.twig', array(
            'planCta' => $planCta,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing planCta entity.
     *
     */
    public function editAction(Request $request, PlanCta $planCta)
    {
        $deleteForm = $this->createDeleteForm($planCta);
        $editForm = $this->createForm('ContabilidadBundle\Form\PlanCtaType', $planCta);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plancta_edit', array('id' => $planCta->getId()));
        }

        return $this->render('@Contabilidad/plancta/edit.html.twig', array(
            'planCta' => $planCta,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a planCta entity.
     *
     */
    public function deleteAction(Request $request, PlanCta $planCta)
    {
        $form = $this->createDeleteForm($planCta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($planCta);
            $em->flush($planCta);
        }

        return $this->redirectToRoute('plancta_index');
    }

    /**
     * Creates a form to delete a planCta entity.
     *
     * @param PlanCta $planCta The planCta entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PlanCta $planCta)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plancta_delete', array('id' => $planCta->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

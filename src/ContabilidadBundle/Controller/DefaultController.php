<?php

namespace ContabilidadBundle\Controller;

use ContabilidadBundle\ContabilidadBundle;
use ContabilidadBundle\Entity\Periodo;
use ContabilidadBundle\Repository\PeriodoRepository;
use ContabilidadBundle\Form\PeriodoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ContabilidadBundle\Repository\ClienteRepository;
use Symfony\Component\HttpFoundation\Request;
use ContabilidadBundle\Entity\VentaSin;
use ContabilidadBundle\Form\VentaSinType;
use ContabilidadBundle\Repository\VentaSinRepository;

class DefaultController extends Controller
{
    public function indexAction()
    {

        //        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();
        return $this->render('@Contabilidad/Default/menu.html.twig', array(
            'user'=>$user
        ));
    }

    public function filtrarClientesAction(Request $request)
    {
        // Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        // Filtrar Clientes
        $em=$this->getDoctrine()->getManager();
        $clientes=$em->getRepository('ContabilidadBundle:Cliente')->buscarCliente(array(
            'ruc'=>$request->request->get('ruc'),
            'nombre'=>$request->request->get('nombre')
        ));

        return $this->render('@Contabilidad/Clientes/clientes.index.html.twig', array(
            'user'=>$user,
            'clientes'=>$clientes
        ));
    }

    public function fichaClienteAction(Request $request, $id_cliente)
    {
//        dump($request);
//        die();


        // Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        // Cliente Selccionado
        $em=$this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$id_cliente));

        // Crea Formulario Periodo
        $period=new Periodo();
        $period->setCliente($cliente);

        $form = $this->createForm('ContabilidadBundle\Form\PeriodoType', $period);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            echo 'formulario enviado';
            $em=$this->getDoctrine()->getManager();
            $em->persist($period);
            $em->flush();

            return $this->redirectToRoute('contabilidad_ficha_cliente', array('id_cliente' => $cliente->getId()));
        }

        //filtrar periodos del cliente
        $em=$this->getDoctrine()->getManager();
        $periodos=$em->getRepository('ContabilidadBundle:Periodo')->filtrarPeriodos(array(
            'cliente'=>$id_cliente
        ));

        return $this->render('@Contabilidad/Clientes/clientes.ficha.html.twig', array(
            'user'=>$user,
            'cliente'=>$cliente,
            'titulo'=>'Ficha del Cliente',
            'botones'=>null,
            'form'=>$form->createView(),
            'periodos'=>$periodos
        ));
    }

    public function periodoClienteAction(Request $request, $id_cliente, $mes, $ano)
    {
//        dump($request);
//        die();

        // Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        // Cliente Selccionado
        $em=$this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$id_cliente));

        //filtrar periodos del cliente
//        $em=$this->getDoctrine()->getManager();
//        $periodos=$em->getRepository('ContabilidadBundle:Periodo')->filtrarPeriodos(array(
//            'cliente'=>$id
//        ));

        //contar y sumar libro ventas
        $totales=$em->getRepository('ContabilidadBundle:VentaSin')->totalesVentas(array(
            'cliente'=>$id_cliente, 'mes'=>$mes, 'ano'=>$ano
        ));

//        dump($totales);
//        die();

        return $this->render('@Contabilidad/Clientes/clientes.periodo.html.twig', array(
            'user'=>$user,
            'cliente'=>$cliente,
            'titulo'=>'Periodo '.$mes.' - '.$ano,
            'botones'=>null,
            'mes'=>$mes,
            'ano'=>$ano,
            'totales'=>$totales
        ));
    }

    public function periodoDeleteAction(Request $request, $periodo_id, $cliente_id)
    {

        // Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $em=$this->getDoctrine()->getManager();
        $periodo=$em->getRepository('ContabilidadBundle:Periodo')->find($periodo_id);
        $em->remove($periodo);
        $em->flush();

//        dump($periodo_id);
//        die();

        return $this->redirectToRoute('contabilidad_ficha_cliente', array(
            'id'=>$cliente_id
        ));
    }
}

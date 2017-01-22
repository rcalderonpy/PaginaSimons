<?php

namespace ContabilidadBundle\Controller;

use ContabilidadBundle\ContabilidadBundle;
use ContabilidadBundle\Entity\Periodo;
use ContabilidadBundle\Entity\Cliente;
use ContabilidadBundle\Entity\VentaCab;
use ContabilidadBundle\Repository\PeriodoRepository;
use ContabilidadBundle\Repository\VentaCabRepository;
use ContabilidadBundle\Repository\ClienteRepository;
use ContabilidadBundle\Form\PeriodoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ContabilidadBundle\Form\ClienteType;
use ContabilidadBundle\Form\VentaSinType;
use Symfony\Component\HttpFoundation\Request;

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

    public function newClienteAction(Request $request)
    {

        // Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        // Cliente Selccionado
        $cliente=new Cliente();
        $form = $this->createForm('ContabilidadBundle\Form\ClienteType', $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // guarda cédula anverso
            $cianv=$form['cianv']->getData();
            $ext=$cianv->guessExtension();
            $file_name=$form['ruc']->getData().'cianv'.'.'.$ext;
            $cianv->move('cedulas', $file_name);

            // guarda cédula reverso
            $cirev=$form['cirev']->getData();
            $ext=$cirev->guessExtension();
            $file_name=$form['ruc']->getData().'cirev'.'.'.$ext;
            $cirev->move('cedulas', $file_name);

            $em=$this->getDoctrine()->getManager();
            $em->persist($cliente);
            $em->flush();

            return $this->redirectToRoute('contabilidad_lista_clientes');
        }

        return $this->render('@Contabilidad/Clientes/cliente.new.html.twig', array(
            'user'=>$user,
            'cliente'=>$cliente,
            'titulo'=>'Nuevo Cliente',
//            'botones'=>array(
//                array('texto'=>'Editar', 'ruta'=>'contabilidad_lista_clientes')
//            ),
//            'mes'=>null,
//            'id_cliente'=>$id_cliente,
            'form'=>$form->createView()
        ));
    }

    public function editClienteAction(Request $request, $id_cliente)
    {

        // Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();
        $em=$this->getDoctrine()->getManager();

        // Cliente Selccionado
        $cliente=$em->getRepository('ContabilidadBundle:Cliente')->find($id_cliente);
        // Crea el formulario del cliente
        $form = $this->createForm('ContabilidadBundle\Form\ClienteType', $cliente);
        $form->handleRequest($request);

        // si el formulario es ejecutado
        if ($form->isSubmitted() && $form->isValid()) {
            // reemplaza cédula anverso si es que se carga
            if($form['cianv']->getData() != null){
                $cianv=$form['cianv']->getData();
                $ext=$cianv->guessExtension();
                $file_name=$form['ruc']->getData().'cianv'.'.'.$ext;
                $cianv->move('cedulas', $file_name);
            }

            // reemplaza cédula reverso si es que se carga
            if($form['cirev']->getData() != null) {
                $cirev = $form['cirev']->getData();
                $ext = $cirev->guessExtension();
                $file_name = $form['ruc']->getData() . 'cirev' . '.' . $ext;
                $cirev->move('cedulas', $file_name);
            }
            $em->persist($cliente);
            $em->flush();
            return $this->redirectToRoute('contabilidad_ficha_cliente', array('id_cliente'=>$id_cliente));
        }

        //muestra las cédulas almacenadas
        $imagenes=$em->getRepository('ContabilidadBundle:Cliente')->tieneCedula($cliente->getRuc());
        $cianv=$imagenes['cianv'];
        $cirev=$imagenes['cirev'];


        return $this->render('@Contabilidad/Clientes/cliente.edit.html.twig', array(
            'user'=>$user,
            'cliente'=>$cliente,
            'titulo'=>'Editar Cliente',
            'botones'=>null,
//                array(
//                array('texto'=>'Editar', 'ruta'=>'contabilidad_lista_clientes')
//            ),
            'id_cliente'=>$id_cliente,
            'form'=>$form->createView(),
            'cianv'=>$cianv,
            'cirev'=>$cirev
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
        $period->setCliente($cliente);

        $form = $this->createForm('ContabilidadBundle\Form\PeriodoType', $period);
        $form->handleRequest($request);

        $deleteForm=$this->createDeleteForm($cliente);

        //tiene cédulas
        $imagenes=$em->getRepository('ContabilidadBundle:Cliente')->tieneCedula($cliente->getRuc());
        $cianv=$imagenes['cianv'];
        $cirev=$imagenes['cirev'];
//        dump($imagenes);
//        die();

//        if(file_exists('cedulas/'.$cliente->getRuc().'cianv.jpeg')){
//            $cianv='cedulas/'.$cliente->getRuc().'cianv.jpeg';
//        } else {
//            $cianv='cedulas/sincedula.jpeg';
//        }
//
//        if(file_exists('cedulas/'.$cliente->getRuc().'cirev.jpeg')){
//            $cirev='cedulas/'.$cliente->getRuc().'cirev.jpeg';
//        } else {
//            $cirev='cedulas/sincedula.jpeg';
//        }
//        dump($cianv);
//        die();


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
            'botones'=>array(
                array('texto'=>'Editar', 'ruta'=>'contabilidad_cliente_edit')
            ),
            'mes'=>null,
            'id_cliente'=>$id_cliente,
            'form'=>$form->createView(),
            'periodos'=>$periodos,
            'delete_form' => $deleteForm->createView(),
            'cianv'=>$cianv,
            'cirev'=>$cirev
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

        //tiene cédulas
        $imagenes=$em->getRepository('ContabilidadBundle:Cliente')->tieneCedula($cliente->getRuc());
        $cianv=$imagenes['cianv'];
        $cirev=$imagenes['cirev'];


        //contar y sumar libro ventas
        $totales=$em->getRepository('ContabilidadBundle:VentaCab')->totalesVentas(array(
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
            'totales'=>$totales,
            'cianv'=>$cianv,
            'cirev'=>$cirev
        ));
    }

    public function periodoDeleteAction($id_periodo, $id_cliente)
    {
//        dump($id_periodo);
//        die();

        // Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $em=$this->getDoctrine()->getManager();
        $periodo=$em->getRepository('ContabilidadBundle:Periodo')->findOneBy(array('id'=>$periodo_id));
        $em->remove($periodo);
        $em->flush();


        return $this->redirectToRoute('contabilidad_ficha_cliente', array(
            'id_cliente'=>$id_cliente
        ));
    }

    public function periodoBlockAction($id_periodo, $id_cliente)
    {

        // Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
//        dump($id_periodo);
//        die();


        $em=$this->getDoctrine()->getManager();
        $periodo=$em->getRepository('ContabilidadBundle:Periodo')->findOneBy(array('id'=>$id_periodo));

        $periodo->setBloqueado(true);
        $em->persist($periodo);
        $em->flush();


        return $this->redirectToRoute('contabilidad_ficha_cliente', array(
            'id_cliente'=>$id_cliente
        ));
    }

    public function deleteClienteAction(Request $request, Cliente $cliente)
    {
        $form = $this->createDeleteForm($cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cliente);
            $em->flush();
        }
        echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
        die();
//        return $this->redirectToRoute('contabilidad_lista_clientes');
    }

    /**
     * Creates a form to delete a VentaSin entity.
     *
     * @param VentaSin $ventaSin The VentaSin entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cliente $cliente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contabilidad_cliente_delete', array('id' => $cliente->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }


}

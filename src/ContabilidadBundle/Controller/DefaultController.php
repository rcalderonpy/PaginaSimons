<?php

namespace ContabilidadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ContabilidadBundle\Repository\ClienteRepository;
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
//        if($_POST){
//            dump($request);
//            die();
//        }

        //        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        // Filtrar Clientes
        $em=$this->getDoctrine()->getManager();
        $clientes=$em->getRepository('ContabilidadBundle:Cliente')->buscarCliente(array(
            'ruc'=>$request->request->get('ruc'),
            'nombres'=>$request->request->get('nombre')
        ));

//        dump($clientes);
//        die();

        return $this->render('@Contabilidad/Clientes/clientes.index.html.twig', array(
            'user'=>$user,
            'clientes'=>$clientes
        ));
    }

}

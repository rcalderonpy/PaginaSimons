<?php

namespace ContabilidadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ContabilidadBundle\Repository\ClienteRepository;

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

    public function filtrarClientesAction()
    {
        //        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        // Filtrar Clientes
        $em=$this->getDoctrine()->getManager();
        $clientes=$em->getRepository('ContabilidadBundle:Cliente')->buscarCliente();

//        dump($clientes);
//        die();

        return $this->render('@Contabilidad/Clientes/clientes.index.html.twig', array(
            'user'=>$user,
            'clientes'=>$clientes
        ));
    }

}

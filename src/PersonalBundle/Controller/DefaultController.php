<?php

namespace PersonalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PersonalBundle\Form\EmpresaType;
use PersonalBundle\Entity\Empresa;

class DefaultController extends Controller
{
    public function indexAction(){

        return $this->render('PersonalBundle:Default:index.html.twig');
    }


    public function cargaEmpresaAction(Request $request)
    {
        $empresa=new Empresa();
        $form=$this->createForm(EmpresaType::class, $empresa);

        $form->handleRequest($request);

        if($form->isValid()){


            $empresa
                ->setNombre($form->get("nombre")->getData())
                ->setApellido($form->get("apellido")->getData())
                ->setNpatMtess($form->get("npatMtess")->getData())
                ->setNpatIps($form->get("npatIps")->getData())
                ->setPwMtess($form->get("pwMtess")->getData())
                ->setPwIps($form->get("pwIps")->getData());

            $em=$this->getDoctrine()->getEntityManager();
            $em->persist($empresa);
            $em->flush();
        }


        return $this->render('PersonalBundle:Default:empresa.html.twig', array(
            "form"=>$form->createView()

        ));
    }
}
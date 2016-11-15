<?php

namespace AppBundle\Controller;

use AppBundle\Form\UsuarioType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // abre la página inicial
        return $this->render('default/index.html.twig', [
            'base_dir' => '']);

    }


    public function misionAction(Request $request)
    {
        // abre la página mision
        return $this->render('default/mision.html.twig', [
            'base_dir' => '']);

    }
    public function contactoAction(Request $request)
    {
        // abre la página contacto
        return $this->render('default/contacto.html.twig', [
            'base_dir' => '']);

    }

//    public function loginAction(Request $request)
//    {
////        $defaultData = array('message' => 'Texto de prueba');
////        $form = $this->createFormBuilder($defaultData)
////            ->add('user', TextType::class)
////            ->add('pw', PasswordType::class)
////            ->add('submit', SubmitType::class)
////            ->getForm();
////
////        $form->handleRequest($request);
////
////        if ($form->isValid()) {
////            // data is an array with "name", "email", and "message" keys
////            $data = $form->getData();
////            echo "El formulario es válido";
////            dump($data);
////            $this->redirectToRoute('homepage');
////        }
//
//        $nombre=$request->request->get('usuario');
//        $pw=$request->request->get('pw');
//        echo 'Nombre= '.$nombre;
//        echo '<br>';
//        echo 'Contraseña= '.$pw;
//
//        // abre la página contacto
//        return $this->render('@App/Default/login.html.twig');

//    }
}


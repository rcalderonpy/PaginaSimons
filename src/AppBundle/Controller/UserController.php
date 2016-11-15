<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use Symfony\Bridge\Doctrine\Tests\Fixtures\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class UserController extends Controller
{
    public function loginAction(Request $request)
    {
        $authenticationUtils=$this->get("security.authentication_utils");
        $error=$authenticationUtils->getLastAuthenticationError();
        $lastUserName=$authenticationUtils->getLastUsername();


        return $this->render('@App/Default/login.html.twig', array(
            'error'=>$error,
            'last_username'=>$lastUserName
        ));

    }

}


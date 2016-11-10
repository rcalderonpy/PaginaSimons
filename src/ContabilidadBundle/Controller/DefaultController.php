<?php

namespace ContabilidadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ContabilidadBundle:Default:index.html.twig');
    }

    public function ventasSinAction()
    {
        return $this->render('BaseFormularios.html.twig');
    }
}

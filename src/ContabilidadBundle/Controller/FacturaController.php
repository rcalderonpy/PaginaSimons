<?php

namespace ContabilidadBundle\Controller;

use ContabilidadBundle\ContabilidadBundle;
use ContabilidadBundle\Entity\Cliente;
use ContabilidadBundle\Entity\Ventac;
use ContabilidadBundle\Entity\Entidad;
use ContabilidadBundle\Entity\Ventad;
use ContabilidadBundle\Entity\Cuenta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ContabilidadBundle\Form\VentaSinType;
use ContabilidadBundle\Repository\VentacRepository;
use ContabilidadBundle\Repository\VentadRepository;
use ContabilidadBundle\Repository\EntidadRepository;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Venta controller.
 *
 */
class FacturaController extends Controller
{
    /**
     * Lists all Venta entities.
     *
     */
    public function indexAction(Request $request)
    {

        // Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        return $this->render('@Contabilidad/ventas/index.html.twig', array(
            'ventaSins' => $ventas,
            'user'=>$user,
            'cliente'=>$cliente,
            'titulo'=>'Ventas '.$mes.' - '.$ano,
            'id_cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano,
            'botones'=>array(
                array(
                    'texto'=>'Nueva Venta',
                    'ruta'=>'venta_new',
                    'parametros'=>array(
                        'id_cliente'=>$id_cliente,
                        'mes'=>$mes,
                        'ano'=>$ano
                    )

                )
            )
        ));
    }


}

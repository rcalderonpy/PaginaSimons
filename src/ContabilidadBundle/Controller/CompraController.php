<?php

namespace ContabilidadBundle\Controller;

use ContabilidadBundle\Entity\Comprac;
use ContabilidadBundle\Entity\Comprad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ContabilidadBundle\Form\CompracType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

/**
 * Comprac controller.
 *
 */
class CompraController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session=new Session();
    }

    /**
     * Lists all compras entities.
     *
     */
    public function indexAction(Request $request, $id_cliente, $mes, $ano)
    {

        // Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$id_cliente));

        $clisel=$this->get('app.cliente');
        $clisel->setCliente($cliente);

        $nvocli=$this->get('app.cliente')->getCliente();

        //filtrar compras del cliente y del periodo
        $comprascabs=$em->getRepository('ContabilidadBundle:Comprac')->filtrarComprasPeriodo(array(
            'cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano
        ));

        $compras=[];

        foreach ($comprascabs as $comprascab) {
//            echo 'Comprobante: ' . $comprascab->getNsuc() . '-' . $comprascab->getNpe() . '-'.$comprascab->getNcomp().'<br>';
//            echo 'Entidad: '. $comprascab->getEntidad()->getNombre() . '<br>';
//            echo 'Sucursal: '. $comprascab->getSucursal()->getSucursal() . '<br>';
//            echo 'Moneda: '. $comprascab->getMoneda()->getMoneda() . '<br>';
            $detalles = $comprascab->getComprad();
            $suma=0;
            foreach ($detalles as $detalle){
                $monto= $detalle->getG10()+$detalle->getG5()+$detalle->getExe();
                $suma+=$monto;
            }
//            echo 'Suma = '.$suma.'<hr>';
            array_push($compras, ['id'=>$comprascab->getId(),
                'fecha'=>$comprascab->getFecha(),
                'comprobante'=> $comprascab->getNsuc() . '-' . $comprascab->getNpe() . '-'.$comprascab->getNcomp(),
                'cotiz'=>$comprascab->getCotiz(),
                'comentario'=>$comprascab->getComentario(),
                'total'=>$suma,
                'timbrado'=>$comprascab->getTimbrado(),
                'condicion'=>$comprascab->getCondicion()==0?'Contado':'Plazo',
                'entidad'=>$comprascab->getEntidad()->getNombre()
            ]);
        }

//        dump($compras);

        return $this->render('@Contabilidad/compras/index.html.twig', array(
            'compras' => $compras,
            'user'=>$user,
            'cliente'=>$cliente,
            'titulo'=>'Compras '.$mes.' - '.$ano,
            'id_cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano,
            'botones'=>array(
                array(
                    'texto'=>'Nueva Compra',
                    'ruta'=>'compra_new',
                    'parametros'=>array(
                        'id_cliente'=>$id_cliente,
                        'mes'=>$mes,
                        'ano'=>$ano
                    )

                ),
                array(
                    'texto'=>'Imprimir',
                    'ruta'=>'compra_libro_imprimir',
                    'parametros'=>array(
                        'id_cliente'=>$id_cliente,
                        'mes'=>$mes,
                        'ano'=>$ano
                    ),
                    'target'=>'_blank'

                )
            )
        ));
    }

    public function printComprasAction(Request $request, $id_cliente, $mes, $ano){
        // Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->findOneBy(array('id'=>$id_cliente));

        $clisel=$this->get('app.cliente');
        $clisel->setCliente($cliente);

        $nvocli=$this->get('app.cliente')->getCliente();

        //filtrar compras del cliente y del periodo
        $comprascabs=$em->getRepository('ContabilidadBundle:Comprac')->filtrarComprasPeriodo(array(
            'cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano
        ));

        $compras=[];

        foreach ($comprascabs as $comprascab) {

            $detalles = $comprascab->getComprad();
            $suma=0;
            $sumabase10=0;
            $sumabase5=0;
            $sumaiva10=0;
            $sumaiva5=0;
            $sumaexe=0;
            foreach ($detalles as $detalle){
                $monto= $detalle->getG10()+$detalle->getG5()+$detalle->getExe();
                $suma+=$monto;
                $sumabase10+=$detalle->getBase10();
                $sumabase5+=$detalle->getBase5();
                $sumaiva10+=$detalle->getIva10();
                $sumaiva5+=$detalle->getIva5();
                $sumaexe+=$detalle->getExe();
            }
//            echo 'Suma = '.$suma.'<hr>';
            array_push($compras, ['id'=>$comprascab->getId(),
                'fecha'=>$comprascab->getFecha(),
                'comprobante'=> $comprascab->getNsuc() . '-' . $comprascab->getNpe() . '-'.$comprascab->getNcomp(),
                'cotiz'=>$comprascab->getCotiz(),
                'comentario'=>$comprascab->getComentario(),
                'base10'=>$sumabase10,
                'base5'=>$sumabase5,
                'iva10'=>$sumaiva10,
                'iva5'=>$sumaiva5,
                'exe'=>$sumaexe,
                'total'=>$suma,
                'timbrado'=>$comprascab->getTimbrado(),
                'condicion'=>$comprascab->getCondicion()==0?'Contado':'Plazo',
                'entidad'=>$comprascab->getEntidad()->getNombre()
            ]);
        }
        $nombre_archivo=$cliente->getRuc().'_'.$mes.'_'.$ano;

        $html= $this->renderView('@Contabilidad/compras/libro_compras.html.twig', array(
            'compras' => $compras,
            'user'=>$user,
            'cliente'=>$cliente,
            'titulo'=>'Compras '.$mes.' - '.$ano,
            'id_cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano
        ));

//        return new Response($html);

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf'
//                'Content-Disposition'   => 'attachment; filename="Compras_'.$mes.'_'.$ano.'.pdf"'
            )
        );


//        $this->get('knp_snappy.pdf')->generateFromHtml(
//            $this->renderView(
//                '@Contabilidad/compras/libro_compras.html.twig',
//                array(
//                    'compras' => $compras,
//                    'user'=>$user,
//                    'cliente'=>$cliente,
//                    'titulo'=>'Compras '.$mes.' - '.$ano,
//                    'id_cliente'=>$id_cliente,
//                    'mes'=>$mes,
//                    'ano'=>$ano
//                )
//            ),
////            'C:\Rodrigo\libro_compras.pdf',
//            'C:\Rodrigo\compras'.$nombre_archivo.'.pdf',
//            [],
//            true
//        );


    }

    /**
     * Creates a new compras entity.
     *
     */
    public function newAction($id_cliente, $mes, $ano, Request $request)
    {

        //        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();
        $em=$this->getDoctrine()->getManager();

        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->find($id_cliente);

        //muestra las cédulas almacenadas
        $imagenes=$em->getRepository('ContabilidadBundle:Cliente')->tieneCedula($cliente->getRuc());
        $cianv=$imagenes['cianv'];
        $cirev=$imagenes['cirev'];

        // Conseguir objetos
        $sucursal=$em->getRepository('ContabilidadBundle:Sucursal')->findOneBy(['id'=>1]);

        $comprac = new Comprac();
        $comprac->setSucursal($sucursal);
        $comprac->setCliente($cliente);
        $comprac->setUsuario($user);
        $form = $this->createForm('ContabilidadBundle\Form\CompracType', $comprac);
        $form->handleRequest($request);


//        $comprad = new Comprad();
//        $comprad->setComprac($comprac);
//        $form_det = $this->createForm('ContabilidadBundle\Form\CompradType', $comprad);
//        $form_det->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            dump($form);
//            die();
            $dia=$form['dia']->getData();
            $fecha_valida=checkdate ( $mes , $dia, $ano );
            if($fecha_valida){
                $fecha_texto=$mes.'/'.$dia .'/'.$ano;
                $fecha=date_create($fecha_texto);
                $comprac->setFecha($fecha);
                $detalles=$comprac->getComprad(); //cuenta la cantidad de filas detalle para agregar objeto $comprac
                foreach ($detalles as $detalle){
                    $detalle->setComprac($comprac);
                    $detalle->setBase10($detalle->getG10() - $detalle->getIva10());
                    $detalle->setBase5($detalle->getG5() - $detalle->getIva5());
                }
                $em->persist($comprac);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Registro guardado exitosamente');
                return $this->redirectToRoute('compra_new', array(
                    'id_cliente' => $id_cliente, 'mes'=>$mes, 'ano'=>$ano));
            }
            $this->session->getFlashBag()->add('danger', 'Fecha inválida');

        }

        return $this->render('@Contabilidad/compras/new.html.twig', array(
            'compra' => $comprac,
            'user'=>$user,
            'cliente' => $cliente,
//            'form' => $form->createView(),
            'id_cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano,
            'form'=>$form->createView(),
//            'form_det'=>$form_det->createView(),
            'cianv'=>$cianv,
            'cirev'=>$cirev,
            'titulo'=>'Nueva Compra - Periodo '.$mes.' - '.$ano,
            'tituloPag'=>'Nueva Compra',
//            'datosDet'=>$datosDet,
            'botones'=>array(
                array(
                    'texto'=>'Volver',
                    'ruta'=>'compra_index',
                    'parametros'=>array(
                        'id_cliente'=>$id_cliente,
                        'mes'=>$mes,
                        'ano'=>$ano
                    )
                )
            )
        ));
    }

    /**
     * Finds and displays a compras entity.
     *
     */
    public function showAction(Request $request, $id_cliente, $mes, $ano, $id_compra)
    {

        //        Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();
        $em=$this->getDoctrine()->getManager();

        $comprac=$em->getRepository('ContabilidadBundle:Comprac')->find($id_compra);

        $deleteForm = $this->createDeleteForm($id_cliente, $mes, $ano, $id_compra);


        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->find($id_cliente);

        return $this->render('@Contabilidad/compras/show.html.twig', array(
            'comprac' => $comprac,
            'user'=>$user,
            'cliente' => $cliente,
            'delete_form' => $deleteForm->createView(),
            'id_cliente'=>$id_cliente,
            'id_compra'=>$id_compra,
            'mes'=>$mes,
            'ano'=>$ano,
            'titulo'=>'Mostrar Compra '.$comprac->getNsuc().'-'.$comprac->getNpe().'-'.$comprac->getNcomp(),
            'botones'=>array(
                array(
                    'texto'=>'Editar',
                    'ruta'=>'compra_edit',
                    'parametros'=>array(
                        'id_cliente'=>$id_cliente,
                        'mes'=>$mes,
                        'ano'=>$ano,
                        'id_compra'=> $id_compra
                    )
                ),
                array(
                    'texto'=>'Volver',
                    'ruta'=>'compra_index',
                    'parametros'=>array(
                        'id_cliente'=>$id_cliente,
                        'mes'=>$mes,
                        'ano'=>$ano
                    )
                )
            )
        ));
    }


    /**
     * Displays a form to edit an existing compras entity.
     *
     */
    public function editAction(Request $request, $id_cliente, $mes, $ano, $id_compra)
    {
        // Validación Usuario
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $mensaje=null;
        $user = $this->getUser();
        $em=$this->getDoctrine()->getManager();
        $comprac=$em->getRepository('ContabilidadBundle:Comprac')->find($id_compra);
        $cliente = $em->getRepository('ContabilidadBundle:Cliente')->find($id_cliente);

        $deleteForm = $this->createDeleteForm($id_cliente, $mes, $ano, $id_compra);

        // si el formulario fue enviado por POST

        $form = $this->createForm('ContabilidadBundle\Form\CompracType', $comprac);
        $form->handleRequest($request);
//        $fecha=$comprac->getFecha()->getTimestamp();
//        $dia=date('j', $fecha);
//        $form['dia']->setData($dia);

//        dump($form);
//        die();

        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($comprac);
            $em->flush();
            $this->addFlash('success', 'Registro guardado exitosamente');
            return $this->redirectToRoute('compra_show', array(
                'id_cliente' => $id_cliente, 'mes'=>$mes, 'ano'=>$ano, 'id_compra'=>$id_compra));
        }

        //muestra las cédulas almacenadas
        $imagenes=$em->getRepository('ContabilidadBundle:Cliente')->tieneCedula($cliente->getRuc());
        $cianv=$imagenes['cianv'];
        $cirev=$imagenes['cirev'];

        return $this->render('@Contabilidad/compras/new.html.twig', array(
            'comprac' => $comprac,
            'user'=>$user,
            'cliente' => $cliente,
            'cianv'=>$cianv,
            'cirev'=>$cirev,
//            'datosDet'=>$datosDet,
            'id_cliente'=>$id_cliente,
            'id_compra'=>$id_compra,
            'mes'=>$mes,
            'ano'=>$ano,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
//            'form'=>$form->createView(),
            'titulo'=>'Edición de Compras',
            'tituloPag'=>'Editar Compra',
            'botones'=>array(
                array(
                    'texto'=>'Volver',
                    'ruta'=>'compra_show',
                    'parametros'=>array(
                        'id_cliente'=>$id_cliente,
                        'mes'=>$mes,
                        'ano'=>$ano,
                        'id_compra'=>$id_compra
                    )
                ),
            )
        ));
    }

    /**
     * Deletes a compras entity.
     *
     */
    public function deleteAction(Request $request, $id_cliente, $mes, $ano, $id_compra)
    {

        $comprac=$this->getDoctrine()->getRepository('ContabilidadBundle:Comprac')->find($id_compra);
        $form = $this->createDeleteForm($id_cliente, $mes, $ano, $id_compra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comprac);
            $em->flush();
        }

        return $this->redirectToRoute('compra_index', array(
            'id_cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano
        ));
    }

    /**
     * Creates a form to delete a compras entity.
     *
     * @param Comprac $comprac The compras entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id_cliente, $mes, $ano, $id_compra)
    {
        $parametros=array('id_compra' => $id_compra,
            'id_cliente'=>$id_cliente,
            'mes'=>$mes,
            'ano'=>$ano
        );

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('compra_delete', $parametros))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}

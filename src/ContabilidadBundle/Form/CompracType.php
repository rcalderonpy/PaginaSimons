<?php

namespace ContabilidadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use ContabilidadBundle\Repository\ParametroRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use ContabilidadBundle\Entity\Comprac;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class CompracType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipocomp', EntityType::class, array(
                'class' => 'ContabilidadBundle\Entity\Parametro',
                'query_builder' => function (ParametroRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->Where("p.dominio = 'GENERALES_TIPO_COMPROBANTE'")
                        ->andWhere("p.id<>11")
                        ->andWhere("p.id<>12")
                        ->andWhere("p.id<>18")
                        ->orderBy('p.orden', 'ASC');
                },
                'choice_label' => 'codigo',
                'label' => 'Tipo de Comprobante'
            ))
            ->add('dia', TextType::class, array(
                'attr'=>array('style'=>'width:40px',
//                    'id'=>'dia',
                    'autofocus'=>true,
                    'maxlength'=>'2',
                    'class'=>'input-sm text-center'),
                'required'=>true,
//                'mapped'=>false
            ))
//            ->add('entidad', null, array(
//                'attr'=>array(
//                    'style'=>'widht:1000px'
//                )
//            ))
            ->add('entidad', Select2EntityType::class, array(
                'multiple' => false,
                'remote_route' => 'get_entidad_json',
                'class' => 'ContabilidadBundle\Entity\Entidad',
                'primary_key' => 'id',
                'text_property' => 'nombre',
                'minimum_input_length' => 2,
                'page_limit' => 10,
                'allow_clear' => true,
//                'allow_add' => array(
//                    'enabled' => true,
//                    'new_tag_text' => ' (Nuevo)',
//                    'new_tag_prefix' => '__',
//                    'tag_separators' => '[",", " "]'
//                ),
                'delay' => 500,
                'cache' => true,
                'cache_timeout' => 6000, // if 'cache' is true
                'language' => 'es_es',
                'placeholder' => 'Elija una entidad',
                'label'=>'Proveedor',
                'attr'=>array(
                    'style'=>'width:400px',
                    'class'=>'select2'
                )
            ))
//            ->add('cuenta', Select2EntityType::class, array(
//                'multiple' => false,
//                'remote_route' => 'get_cuenta_json',
//                'class' => 'ContabilidadBundle\Entity\Cuenta',
//                'primary_key' => 'id',
////                'text_property' => 'text',
//                'minimum_input_length' => 2,
//                'page_limit' => 10,
//                'allow_clear' => true,
//                'delay' => 300,
//                'cache' => true,
//                'cache_timeout' => 3000, // if 'cache' is true
//                'language' => 'es_es',
//                'placeholder' => 'Elija una cuenta',
//                'label'=>null,
//                'attr'=>array(
//                    'style'=>'width:150px',
//                    'class'=>'select2'
//                ),
//                'mapped'=>false
//            ))
            ->add('nsuc', null, array(
                'attr'=>array('style'=>'width:50px',
//                    'placeholder'=>'Suc',
                    'class'=>'input-sm text-center'),
                'label'=>'Suc'
            ))
            ->add('npe', null, array(
                'attr'=>array('style'=>'width:50px',
//                    'placeholder'=>'Ex',
                    'class'=>'input-sm text-center'),
                'label'=>'P. Ex.'
            ))
            ->add('ncomp', null, array(
                'attr'=>array('style'=>'width:80px',
//                    'placeholder'=>'Comprob',
                    'class'=>'input-sm text-center'),
                'label'=>'Comprob.'
            ))
            ->add('timbrado', null, array(
                'attr'=>array('style'=>'width:80px',
//                    'placeholder'=>'Nº Timbrado',
                    'class'=>'input-sm text-center')
            ))
            ->add('condicion', ChoiceType::class, array(
                'choices'=>array('Contado'=>0,
                'Plazo'=>1)
            ))
            ->add('moneda', null, array(
                'placeholder'=>false
            ))
            ->add('cotiz', NumberType::class, array(
                'attr' => array(
                    'class' => 'numero',
                    'style' => 'width:100px'
                ),
                'label' => 'Cotización',
                'grouping'=>true,
                'scale'=>2
            ))
            ->add('anul', ChoiceType::class, array(
                'choices'=>array('No'=>false,
                    'Sí'=>true),
                'attr'=>array('tabindex'=>-1)
            ))
            ->add('afecta', EntityType::class, array(
                'class' => 'ContabilidadBundle\Entity\Parametro',
                'query_builder' => function (ParametroRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->Where("p.dominio = 'GENERALES_RENTA'")
                        ->orderBy('p.orden', 'ASC');
                },
                'choice_label' => 'codigo',
                'label' => 'Renta',
                'attr'=>array(
                    'style'=>'width:100px'
                )
            ))
            ->add('comentario', TextareaType::class, array(
                'attr'=>array(
//                    'style'=>'width:100%'
                ),
                'label'=>'Comentario'
            ))
            ->add('comprad', CollectionType::class, array(
                'entry_type'   => CompradType::class,
                'allow_add'=>true,
                'allow_delete'=>true,
                'prototype'=>true,
                'label'=>false
            ));

        $builder->addEventListener(FormEvents::POST_SET_DATA, function(FormEvent $event){
            $form = $event->getForm();
            $fecha=$form->getNormData()->getFecha()->getTimestamp();
            $dia=date('j', $fecha);
            if($form->getNormData()->getNsuc()!=null){
                $form['dia']->setData($dia);
            }
        });


    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ContabilidadBundle\Entity\Comprac'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'contabilidadbundle_comprac';
    }


}

<?php

namespace ContabilidadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use ContabilidadBundle\Entity\Comprac;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompracType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dia', null, array(
                'attr'=>array('style'=>'width:40px',
//                    'id'=>'dia',
                    'autofocus'=>true,
                    'maxlength'=>'2',
                    'class'=>'input-sm text-center'),
                'required'=>true,
                'mapped'=>false
            ))
            ->add('entidad', null, array(
                'attr'=>array(
                    'style'=>'widht:1000px'
                )
            ))
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
            ->add('cotiz',NumberType::class, array(
                'attr'=>array(
                    'style'=>'width:80px',
                    'class'=>'text-right input-sm'
                ),
                'scale'=>2,
                'grouping'=>true,
            ))
            ->add('anul', ChoiceType::class, array(
                'choices'=>array('No'=>false,
                    'Sí'=>true),
                'attr'=>array('tabindex'=>-1)
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

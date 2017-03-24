<?php

namespace ContabilidadBundle\Form;

use ContabilidadBundle\Entity\Parametro;
use ContabilidadBundle\Repository\CuentaRepository;
use ContabilidadBundle\Repository\ParametroRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class CompradType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

//            ->add('cuenta', null, array(
//                'placeholder' => false,
//                'label' => false,
//                'attr'=>array(
//                    'style'=>'width:150px'
//                )
//            ))
            ->add('cuenta', Select2EntityType::class, array(
                'multiple' => false,
                'remote_route' => 'get_cuenta_json',
                'class' => 'ContabilidadBundle\Entity\Cuenta',
                'primary_key' => 'id',
//                'text_property' => 'text',
                'minimum_input_length' => 2,
                'page_limit' => 10,
                'allow_clear' => true,
                'delay' => 500,
                'cache' => true,
                'cache_timeout' => 6000, // if 'cache' is true
                'language' => 'es_es',
                'placeholder' => 'Elija una cuenta',
                'label'=>false,
                'attr'=>array(
                    'style'=>'width:150px',
                    'class'=>'select2'
                )
            ))
            ->add('g10', NumberType::class, array(
                'attr' => array(
                    'class' => 'numero',
                    'style' => 'width:130px'
                ),
                'label' => false,
                'grouping'=>true,
                'scale'=>2
            ))
            ->add('g5', NumberType::class, array(
                'attr' => array(
                    'class' => 'numero',
                    'style' => 'width:130px'
                ),
                'label' => false,
                'grouping'=>true,
                'scale'=>2
            ))
            ->add('exe', NumberType::class, array(
                'attr' => array(
                    'class' => 'numero',
                    'style' => 'width:115px'
                ),
                'label' => false,
                'grouping'=>true,
                'scale'=>2
            ))
            ->add('iva10', NumberType::class, array(
                'attr' => array(
                    'class' => 'numero inactivo',
                    'style' => 'width:100px',
                    'readonly'=>true,
                    'tabindex' => -1
                ),
                'label' => false,
                'grouping'=>true,
                'scale'=>2
            ))
            ->add('iva5', NumberType::class, array(
                'attr' => array(
                    'class' => 'numero inactivo',
                    'style' => 'width:100px',
                    'readonly'=>true,
                    'tabindex' => -1
                ),
                'label' => false,
                'grouping'=>true,
                'scale'=>2
            ))
            ->add('total', NumberType::class, array(
                'attr' => array(
                    'class' => 'numero inactivo',
                    'style' => 'width:130px',
                    'disabled'=>true
                ),
                'label' => false,
                'grouping'=>true,
                'scale'=>2,
                'mapped'=>false
            ))

            ->add('borrar', ButtonType::class, array(
                'attr' => array(
                    'class' => 'btn btn-xs btn-danger borrar',
                    'tabindex' => -1
                ),
                'label' => 'X'
            ))
            ->add('agregar', ButtonType::class, array(
                'attr' => array(
                    'class' => 'btn btn-xs btn-success agregar',
//                    'tabindex' => -1
                ),
                'label' => '+'
            ));

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            if (!$form->getNormData()) {
                $form['g10']->setData(0);
                $form['g5']->setData(0);
                $form['iva10']->setData(0);
                $form['iva5']->setData(0);
                $form['exe']->setData(0);
                $form['total']->setData(0);
            }
        });


    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ContabilidadBundle\Entity\Comprad'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'contabilidadbundle_comprad';
    }


}

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

class CompradType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('afecta', EntityType::class, array(
                'class' => 'ContabilidadBundle\Entity\Parametro',
                'query_builder' => function (ParametroRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->Where("p.dominio = 'GENERALES_RENTA'")
                        ->orderBy('p.orden', 'ASC');
                },
                'choice_label' => 'codigo',
                'label' => false,
                'attr'=>array(
                    'style'=>'width:100px'
                )
            ))
            ->add('cuenta', null, array(
                'placeholder' => false,
                'label' => false,
                'attr'=>array(
                    'style'=>'width:200px'
                )
            ))
            ->add('g10', NumberType::class, array(
                'attr' => array(
                    'class' => 'numero',
                    'style' => 'width:100px'
                ),
                'label' => false,
                'grouping'=>true
            ))
            ->add('g5', NumberType::class, array(
                'attr' => array(
                    'class' => 'numero',
                    'style' => 'width:100px'
                ),
                'label' => false,
                'grouping'=>true
            ))
            ->add('exe', NumberType::class, array(
                'attr' => array(
                    'class' => 'numero',
                    'style' => 'width:100px'
                ),
                'label' => false,
                'grouping'=>true
            ))
            ->add('iva10', NumberType::class, array(
                'attr' => array(
                    'class' => 'numero',
                    'style' => 'width:100px',
                    'disabled'=>true
                ),
                'label' => false,
                'grouping'=>true
            ))
            ->add('iva5', NumberType::class, array(
                'attr' => array(
                    'class' => 'numero',
                    'style' => 'width:100px',
                    'disabled'=>true
                ),
                'label' => false,
                'grouping'=>true
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
                    'tabindex' => -1
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
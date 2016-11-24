<?php

namespace ContabilidadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClienteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ruc')
            ->add('dv')
            ->add('nombres', null, array(
                'attr'=>array(
                    'style'=>'text-transform:uppercase'
                )
            ))
            ->add('ape1', null, array(
                'attr'=>array(
                    'style'=>'text-transform:uppercase'
                ),
//                'data'=>" ",
                'trim'=>false
            ))
            ->add('ape2', null, array(
                'attr'=>array(
                    'style'=>'text-transform:uppercase'
                ),
//                'data'=>" ",
                'trim'=>false
            ))
            ->add('estado', ChoiceType::class, array(
                'choices'=>array(
                    'ACTIVO'=>'ACTIVO',
                    'INACTIVO'=>'INACTIVO'
                ),
                'placeholder'=>false
            ))
            ->add('cianv', FileType::class, array(
                'mapped'=>false
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ContabilidadBundle\Entity\Cliente'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'contabilidadbundle_cliente';
    }


}

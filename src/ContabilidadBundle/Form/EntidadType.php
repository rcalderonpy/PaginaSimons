<?php

namespace ContabilidadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntidadType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ruc', null, array(
                'attr' => array(
                    'autofocus' => true
                )
            ))
            ->add('dv')
            ->add('nombre', null, array(
                'attr'=>array(
                    'class'=>'form-control text-uppercase'
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ContabilidadBundle\Entity\Entidad'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'contabilidadbundle_entidad';
    }


}

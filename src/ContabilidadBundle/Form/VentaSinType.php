<?php

namespace ContabilidadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class VentaSinType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', DateType::class)
            ->add('comprobante')
            ->add('cotiz')
            ->add('comentario')
            ->add('g10')
            ->add('g5')
            ->add('iva10')
            ->add('iva5')
            ->add('exe')
            ->add('retencion')
            ->add('timbrado')
            ->add('condicion')
            ->add('sucursal')
            ->add('entidad')
            ->add('cliente')
            ->add('moneda')
            ->add('usuario', ChoiceType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ContabilidadBundle\Entity\VentaSin'
        ));
    }
}

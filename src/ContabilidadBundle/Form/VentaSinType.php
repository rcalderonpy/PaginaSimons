<?php

namespace ContabilidadBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VentaSinType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', DateType::class, array(
                'format'=>'dd-MM-yyyy',
                'html5'=>true
            ))
            ->add('comprobante')
            ->add('cotiz')
            ->add('comentario')
            ->add('g10', IntegerType::class, array(
                'data'=>0
            ))
            ->add('g5', IntegerType::class, array(
                'data'=>0
            ))
            ->add('iva10', IntegerType::class, array(
                'data'=>0
            ))
            ->add('iva5', IntegerType::class, array(
                'data'=>0
            ))
            ->add('exe', IntegerType::class, array(
                'data'=>0
            ))
            ->add('retencion', IntegerType::class, array(
                'data'=>0
            ))
            ->add('timbrado')
            ->add('condicion')
            ->add('sucursal')
            ->add('entidad')
            ->add('cliente')
            ->add('moneda')
            ->add('usuario')
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

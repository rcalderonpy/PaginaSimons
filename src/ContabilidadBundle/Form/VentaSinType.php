<?php

namespace ContabilidadBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Intl\NumberFormatter;

class VentaSinType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', BirthdayType::class, array(
                'widget'=>'single_text',
                'input'=>'datetime',
                'data'=>new \DateTime(),
                'attr'=>array('id'=>'fecha',
                    'style'=>'width:17%'
                    )
            ))
            ->add('nsuc', null, array(
                'attr'=>array('style'=>'width:6%',
                    'placeholder'=>'SUC')
            ))
            ->add('npe', null, array(
                'attr'=>array('style'=>'width:6%',
                    'placeholder'=>'PE')
            ))
            ->add('ncomp', null, array(
                'attr'=>array('style'=>'width:11%',
                    'placeholder'=>'COMPROB')
            ))
            ->add('cotiz',null, array(
                'attr'=>array(
                    'style'=>'width:10%'
                )
            ))
            ->add('comentario', null, array(
                'attr'=>array(
                    'style'=>'width:40%'
                )
            ))
            ->add('g10', NumberType::class, array(
                'grouping'=>true,
                'data'=>0,
                'attr'=>array('class'=>'text-right'),
                'scale'=>0
            ))
            ->add('g5', NumberType::class, array(
                'grouping'=>true,
                'data'=>0,
                'attr'=>array('class'=>'text-right'),
                'scale'=>0
            ))
            ->add('iva10', NumberType::class, array(
                'data'=>0,
                'attr'=>array('class'=>'text-right'),
                'grouping'=>true,
                'empty_data'=>0
            ))
            ->add('iva5', NumberType::class, array(
                'data'=>0,
                'attr'=>array('class'=>'text-right'),
                'grouping'=>true
            ))
            ->add('exe', NumberType::class, array(
                'data'=>0,
                'attr'=>array('class'=>'text-right'),
                'grouping'=>true
            ))
            ->add('retencion', NumberType::class, array(
                'data'=>0,
                'attr'=>array('class'=>'text-right'),
                'grouping'=>true
            ))
            ->add('timbrado', null, array(
                'attr'=>array(
                    'style'=>'width:15%',
                    'placeholder'=>'Nº Timbrado'
                )
            ))
            ->add('condicion', ChoiceType::class, array(
                'choices'=>array(
                    'Contado'=>0,
                    'Credito'=>1
                ),
                'expanded'=>false,
                'placeholder'=>false
            ))
            ->add('sucursal', null, array(
                'attr'=>array(
                    'style'=>'width:21%'
                )
            ))
            ->add('entidad', null, array(
                'attr'=>array(
                    'style'=>'width:36%'
                )
            ))
            ->add('cliente')
            ->add('moneda', null, array(
                'placeholder'=>false
            ))
            ->add('usuario', null, array(
                'placeholder'=>false
            ))
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

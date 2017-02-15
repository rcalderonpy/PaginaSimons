<?php

namespace ContabilidadBundle\Form;


use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Intl\DateFormatter\IntlDateFormatter;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Intl\NumberFormatter;
use ContabilidadBundle\Entity\VentaSin;

class VentacType extends AbstractType
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
                    'html5'=>false,
                    'format'=>'d-M-y',
                    'attr'=>array('id'=>'fecha',
                        'style'=>'width:17%',
                        'class'=>'input-sm'
                    )
                ))
                ->add('dia', null, array(
                    'attr'=>array('style'=>'width:5%',
                        'placeholder'=>'Día',
                        'maxlength'=>'2',
                        'class'=>'input-sm text-center'),
                    'required'=>true,
                    'mapped'=>false
                ))
                ->add('nsuc', null, array(
                    'attr'=>array('style'=>'width:5%',
                        'placeholder'=>'Suc',
                        'class'=>'input-sm text-center'),
                ))
                ->add('npe', null, array(
                    'attr'=>array('style'=>'width:5%',
                        'placeholder'=>'Ex',
                        'class'=>'input-sm text-center')
                ))
                ->add('ncomp', null, array(
                    'attr'=>array('style'=>'width:9%',
                        'placeholder'=>'Comprob',
                        'class'=>'input-sm text-center')
                ))
                ->add('cotiz',NumberType::class, array(
                    'attr'=>array(
                        'style'=>'width:8%',
                        'class'=>'text-right input-sm'
                    ),
                    'scale'=>2,
                    'grouping'=>true,
                ))
                ->add('comentario', null, array(
                    'attr'=>array(
                        'style'=>'width:49%',
                        'class'=>'input-sm'
                    )
                ))
//                ->add('g10', NumberType::class, array(
//                    'grouping'=>true,
//                    'attr'=>array(
//                        'class'=>'text-right input-sm',
//                        'style'=>'width:17%'
//                    ),
//                    'scale'=>0
//                ))
//                ->add('g5', NumberType::class, array(
//                    'grouping'=>true,
//                    'attr'=>array('class'=>'text-right input-sm',
//                        'style'=>'width:17%'),
//                    'scale'=>0
//                ))
//                ->add('iva10', NumberType::class, array(
//                    'attr'=>array('class'=>'text-right input-sm',
//                        'style'=>'width:16%'),
//                    'grouping'=>true,
//                    'empty_data'=>0
//                ))
//                ->add('iva5', NumberType::class, array(
//                    'attr'=>array('class'=>'text-right input-sm',
//                        'style'=>'width:16%'),
//                    'grouping'=>true
//                ))
//                ->add('exe', NumberType::class, array(
//                    'attr'=>array('class'=>'text-right input-sm',
//                        'style'=>'width:16%'),
//                    'grouping'=>true
//                ))
//                ->add('retencion', NumberType::class, array(
//                    'attr'=>array('class'=>'text-right input-sm',
//                        'style'=>'width:15%'),
//                    'grouping'=>true
//                ))
                ->add('timbrado', null, array(
                    'attr'=>array(
                        'style'=>'width:10%',
                        'placeholder'=>'Nº Timbrado',
                        'class'=>'input-sm'
                    )
                ))
                ->add('condicion', ChoiceType::class, array(
                    'choices'=>array(
                        'Contado'=>0,
                        'Credito'=>1
                    ),
                    'expanded'=>false,
                    'placeholder'=>false,
                    'attr'=>array(
                        'class'=>'input-sm'
                    )
                ))
                ->add('sucursal', null, array(
                    'attr'=>array(
                        'style'=>'width:21%',
                        'class'=>'input-sm'
                    )
                ))
//                ->add('entidad', null, array(
//                    'attr'=>array(
//                        'style'=>'width:36%',
//                        'class'=>'input-sm'
//                    )
//                ))
                ->add('moneda', null, array(
                    'placeholder'=>false,
                    'attr'=>array(
                        'style'=>'width:20%',
                        'class'=>'input-sm'
                    )
                ))
//                ->add('cliente')
//                ->add('usuario')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ContabilidadBundle\Entity\Ventac'
        ));
    }
}
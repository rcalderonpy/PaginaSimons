<?php

namespace PersonalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmpresaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, array(
                "attr"=>array(
                    "class"=>"form-nombre form-control text-uppercase",
                    "placeholder"=>"Complete el Nombre"
                ), "label"=>"Nombre de la Empresa"
            ))
            ->add('apellido', TextType::class, array(
                "attr"=>array(
                    "class"=>"form-control text-uppercase",
                    "placeholder"=>"Complete el Apellido"
                ),
                "required"=>"required",
                "label"=>"Apellido"
            ))
            ->add('npatMtess', TextType::class, array(
                "attr"=>array(
                    "class"=>"form-control",
                    "placeholder"=>"Complete el Nº Pat. MTESS"
                ),
                "required"=>"required",
                "label"=>"Nº Patronal MTESS"
            ))
            ->add('npatIps', TextType::class, array(
                "attr"=>array(
                    "class"=>"form-control",
                    "placeholder"=>"Complete el Nº Pat. IPS"
                ),
                "required"=>"required",
                "label"=>"Nº Patronal IPS"
            ))
            ->add('pwMtess', TextType::class, array(
                "attr"=>array(
                    "class"=>"form-control",
                    "placeholder"=>"Complete el password MTESS"
                ),
                "label"=>"Password MTESS",
                "required"=>false
            ))
            ->add('pwIps', TextType::class, array(
                "attr"=>array(
                    "class"=>"form-pwIps form-control",
                    "placeholder"=>"Complete el password IPS"
                ),
                "label"=>"Password IPS",
                "required"=>false
            ))
            ->add('submit', SubmitType::class, array(
                "attr"=>array(
                    "class"=>"form-submit btn btn-success"
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PersonalBundle\Entity\Empresa'
        ));
    }
}

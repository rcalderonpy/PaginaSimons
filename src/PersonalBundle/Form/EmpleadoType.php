<?php

namespace PersonalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpleadoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('documento')
            ->add('nombre')
            ->add('apellido')
            ->add('sexo')
            ->add('estadocivil')
            ->add('fechanac', 'datetime')
            ->add('nacionalidad')
            ->add('domicilio')
            ->add('fechamenor', 'datetime')
            ->add('hijosmenores')
            ->add('cargo')
            ->add('profesion')
            ->add('fechaentrada', 'datetime')
            ->add('horariotrabajo')
            ->add('menorescapa')
            ->add('menoresescolar')
            ->add('fechasalida', 'datetime')
            ->add('motivosalida')
            ->add('estado')
            ->add('empresa')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PersonalBundle\Entity\Empleado'
        ));
    }
}

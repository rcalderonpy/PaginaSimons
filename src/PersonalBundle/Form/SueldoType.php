<?php

namespace PersonalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SueldoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('formadepago')
            ->add('importeunitario')
            ->add('hEne')
            ->add('sEne')
            ->add('hFeb')
            ->add('sFeb')
            ->add('hMar')
            ->add('sMar')
            ->add('hAbr')
            ->add('sAbr')
            ->add('hMay')
            ->add('sMay')
            ->add('hJun')
            ->add('sJun')
            ->add('hJul')
            ->add('sJul')
            ->add('hAgo')
            ->add('sAgo')
            ->add('hSet')
            ->add('sSet')
            ->add('hOct')
            ->add('sOct')
            ->add('hNov')
            ->add('sNov')
            ->add('hDic')
            ->add('sDic')
            ->add('h50')
            ->add('s50')
            ->add('h100')
            ->add('s100')
            ->add('aguinaldo')
            ->add('beneficios')
            ->add('bonificaciones')
            ->add('vacaciones')
            ->add('totalH')
            ->add('totalS')
            ->add('totalgeneral')
            ->add('empresa')
            ->add('empleado')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PersonalBundle\Entity\Sueldo'
        ));
    }
}

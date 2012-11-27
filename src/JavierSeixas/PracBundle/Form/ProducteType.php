<?php

namespace JavierSeixas\PracBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProducteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('preu_actual','money', array(
                'required' => true,
                'label' => "Preu actual *"
            ))
            ->add('es_oferta','checkbox', array(
                'required' => false,
                'label' => "Es oferta"
            ))
            ->add('estoc_inicial','integer', array(
                'required' => false,
                'label' => "Estoc inicial"
            ))
            ->add('estoc_final','integer', array(
                'required' => false,
                'label' => "Estoc final"
            ))
            ->add('estoc_notificacio','integer', array(
                'required' => false,
                'label' => "Estoc notificació"
            ))
        ;
    }

    public function getName()
    {
        return 'producte';
    }


}

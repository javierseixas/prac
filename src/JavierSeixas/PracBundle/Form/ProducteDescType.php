<?php

namespace JavierSeixas\PracBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProducteDescType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcioCurta','textarea', array(
                'required' => true,
                'label' => "Descripció curta"
            ))
            ->add('descripcioLlarga','textarea', array(
                'required' => false,
                'label' => "Descripció llarga"
            ))
            ->add('idIdioma','choice', array(
                'required' => false,
                'label' => "Idioma"
            ))
        ;
    }

    public function getName()
    {
        return 'producte';
    }


}

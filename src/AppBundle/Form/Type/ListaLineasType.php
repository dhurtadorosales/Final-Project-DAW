<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\Model\ListaAceites;
use AppBundle\Form\Model\ListaLineas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ListaLineasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lineas', CollectionType::class, [
                'entry_type' => LineaType::class,
                'label' => 'Nueva línea:',
                'entry_options' => [
                    'label' => false
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ListaLineas::class,
            'translation_domain' => false,
            'venta' => null
        ]);
    }
}

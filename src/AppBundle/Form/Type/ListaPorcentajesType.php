<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\Model\ListaAceites;
use AppBundle\Form\Model\ListaPorcentajes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ListaPorcentajesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('porcentajes', CollectionType::class, [
                'entry_type' => PorcentajeType::class,
                'label' => 'Porcentajes:',
                'entry_options' => [
                    'label' => false
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ListaPorcentajes::class,
            'translation_domain' => false
        ]);
    }
}

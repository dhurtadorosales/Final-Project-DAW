<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\Model\ListaLotes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ListaLotesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lotes', CollectionType::class, [
                'entry_type' => LoteType::class,
                'label' => 'Lotes',
                'entry_options' => [
                    'label' => false
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ListaLotes::class,
        ]);
    }
}

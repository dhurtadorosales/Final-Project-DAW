<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\Model\ListaAceites;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ListaAceitesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('aceites', CollectionType::class, [
                'entry_type' => AceiteType::class,
                'label' => 'Lotes:',
                'entry_options' => [
                    'label' => false
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ListaAceites::class,
            'translation_domain' => false
        ]);
    }
}

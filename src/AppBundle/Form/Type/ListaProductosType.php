<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Temporada;
use AppBundle\Form\Model\ListaProductos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ListaProductosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productos', CollectionType::class, [
                'entry_type' => ProductoType::class,
                'label' => null,
                'entry_options' => [
                    'temporada' => $options['temporada'],
                    'label' => false
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ListaProductos::class,
            'temporada' => null
        ]);
    }
}

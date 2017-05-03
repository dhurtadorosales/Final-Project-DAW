<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Lote;
use AppBundle\Entity\Producto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Repository\LoteRepository;

class Producto2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
                ->add('lotes', EntityType::class, [
                    'class' => Lote::class,
                    'query_builder' => function(LoteRepository $loteRepository) use ($options) {
                        return $loteRepository->getLotesTemporadaNoNulosQuery($options['temporada'], $options['aceite']);
                    },
                    'placeholder' => '[Ninguno]'
                    ]
               )
                ->add('stock');
}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
            'temporada' => null,
            'aceite' => null
        ])
        ->setRequired(['temporada', 'aceite']);

    }
}

<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Movimiento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MovimientoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('temporada', null, [
            'label' => 'Temporada:',
            'disabled' => true
        ])
        ->add('fecha', null, [
            'label' => 'Fecha:',
            'widget' => 'single_text',
            'attr' => [
                'readonly' => true
            ]
        ])
        ->add('concepto', null, [
            'label' => 'Concepto:'
        ])
        ->add('cantidad', null, [
            'label' => 'Cantidad:',
            'attr' => [
                'placeholder' => 'Ejemplo: -3000 si es pago, 3000 si es ingreso'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movimiento::class,
            'fecha' => null,
            'temporada' => null,
            'translation_domain' => false
        ]);
    }
}

<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Movimiento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
        ->add('tipo', ChoiceType::class, [
            'label' => 'Tipo:',
            'choices' => [
                'pago' => true,
                'ingreso' => false
            ]
        ])
        ->add('concepto', null, [
            'label' => 'Concepto:'
        ])
        ->add('cantidad', null, [
            'label' => 'Cantidad:'
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

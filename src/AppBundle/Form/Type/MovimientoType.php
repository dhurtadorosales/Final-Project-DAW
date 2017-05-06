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
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($options) {
                $form = $event->getForm();
                $data = $event->getData();
                $form
                    ->add('temporada', null, [
                        'label' => 'Temporada:',
                        'data' => $options['temporada'],
                        'attr' => [
                            'readonly' => true
                        ]
                    ])
                    ->add('fecha', null, [
                        'label' => 'Fecha:',
                        'data' => $options['fecha'],
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
                    ]);
            });
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

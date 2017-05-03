<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Venta;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;


class VentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($options) {
                $form = $event->getForm();
                $data = $event->getData();
                $form
                    ->add('numero', null, [
                        'data' => $options['numero'],
                        'label' => 'Número de factura',
                        'translation_domain' => false,
                        'attr' => [
                            'readonly' => true
                        ]
                    ])
                    ->add('fecha', null, [
                        'data' => $options['fecha'],
                        'widget' => 'single_text',
                        'translation_domain' => false,
                        'attr' => [
                            'readonly' => true
                        ]
                    ])
                    ->add('temporada', null, [
                        'data' => $options['temporada'],
                        'translation_domain' => false,
                        'attr' => [
                            'readonly' => true
                        ]
                    ])
                    ->add('usuario', null, [
                        'placeholder' => '[Ninguno]',
                        'translation_domain' => false
                    ])
                    ->add('descuento', null, [
                        'data' => 0.1,
                        'translation_domain' => false,
                        'attr' => [
                            'readonly' => true
                        ]
                    ])
                    ->add('iva', null, [
                        'data' => 0.21,
                        'translation_domain' => false,
                        'attr' => [
                            'readonly' => true
                        ]
                    ])
                    ->add('suma', null, [
                        'data' => 0,
                        'translation_domain' => false,
                        'attr' => [
                            'readonly' => true
                        ]
                    ]);
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Venta::class,
            'numero' => null,
            'fecha' => null,
            'temporada' => null
        ]);
    }
}

<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Finca;
use AppBundle\Entity\Movimiento;
use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Tests\Extension\Core\Type\PasswordTypeTest;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;


class FincaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($options) {
                $form = $event->getForm();
                $data = $event->getData();
                $form
                    ->add('denominacion', null, [
                        'label' => 'Denominación:',
                        'attr' => [
                            'placeholder' => 'Denominación'
                        ]
                    ])
                    ->add('provincia', null, [
                        'label' => 'Provincia:',
                        'attr' => [
                            'placeholder' => 'Ejemplo: 13'
                        ]
                    ])
                    ->add('municipio', null, [
                        'label' => 'Municipio:',
                        'attr' => [
                            'placeholder' => 'Ejemplo: 77'
                        ]
                    ])
                    ->add('sector', null, [
                        'label' => 'Sector:',
                        'attr' => [
                            'placeholder' => 'Ejemplo: A'
                        ]
                    ])
                    ->add('poligono', null, [
                        'label' => 'Polígono:',
                        'attr' => [
                            'placeholder' => 'Ejemplo: 018'
                        ]
                    ])
                    ->add('parcela', null, [
                        'label' => 'Parcela:',
                        'attr' => [
                            'placeholder' => 'Ejemplo: 00039'
                        ]
                    ])
                    ->add('idInmueble', null, [
                        'label' => 'Identificación del inmueble:',
                        'attr' => [
                            'placeholder' => 'Ejemplo: 0000'
                        ]
                    ])
                    ->add('caracterControl', null, [
                        'label' => 'Caracteres de control:',
                        'attr' => [
                            'placeholder' => 'Ejemplo: FP'
                        ]
                    ])
                    ->add('numPlantas', null , [
                        'label' => 'Número de plantas:',
                        'attr' => [
                            'placeholder' => 'Número de plantas'
                        ]
                    ])
                    ->add('regadio', null, [
                        'label' => 'Regadío'
                    ])
                    ->add('partPropietario', PercentType::class, [
                        'label' => 'Participación del propietario:',
                        'attr' => [
                            'placeholder' => 'Participación del propietario'
                        ]
                    ])
                    ->add('partArrend', PercentType::class, [
                        'label' => 'Participación del arrendatario:',
                        'attr' => [
                            'placeholder' => 'Participación del arrendatario'
                        ]
                    ])
                    ->add('variedad', null, [
                        'label' => 'Variedad de aceituna:',
                        'placeholder' => '[Ninguna]'
                    ])
                    ->add('propietario', null, [
                        'label' => 'Propietario:',
                        'placeholder' => '[Ninguno]'
                    ])
                    ->add('arrendatario', null, [
                        'label' => 'Arrendatario:',
                        'placeholder' => '[Ninguno]',
                        'required' => false
                    ]);
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Finca::class,
            'translation_domain' => false
        ]);
    }
}

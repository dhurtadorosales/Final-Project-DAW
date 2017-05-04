<?php

namespace AppBundle\Form\Type;

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


class EmpleadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($options) {
                $form = $event->getForm();
                $data = $event->getData();
                $form
                    ->add('nif', null, [
                        'label' => 'Nif:',
                        'translation_domain' => false
                    ])
                    ->add('clave', PasswordType::class, [
                        'label' => 'Clave:',
                        'translation_domain' => false,
                        'attr' => [
                            'readonly' => true
                        ]
                    ])
                    ->add('nombre', null, [
                        'label' => 'Nombre:',
                        'translation_domain' => false
                    ])
                    ->add('apellidos', null, [
                        'label' => 'Apellidos:',
                        'translation_domain' => false
                    ])
                    ->add('direccion', null, [
                        'label' => 'Dirección:',
                        'translation_domain' => false
                    ])
                    ->add('codigoPostal', null, [
                        'label' => 'Código postal:',
                        'translation_domain' => false
                    ])
                    ->add('localidad', null, [
                        'label' => 'Localidad:',
                        'translation_domain' => false
                    ])
                    ->add('provincia', null, [
                        'label' => 'Provincia:',
                        'translation_domain' => false
                    ])
                    ->add('telefono', null , [
                        'label' => 'Telefono:',
                        'translation_domain' => false
                    ])
                    ->add('email', EmailType::class, [
                        'label' => 'Correo electrónico:',
                        'translation_domain' => false
                    ])
                    ->add('descuento', PercentType::class, [
                        'label' => 'Descuento:',
                        'translation_domain' => false
                    ])
                    ->add('administrador', null, [
                        'label' => 'Administrador:',
                        'translation_domain' => false
                    ])
                    ->add('comercial', null, [
                        'label' => 'Comercial:',
                        'translation_domain' => false
                    ])
                    ->add('dependiente', null, [
                        'label' => 'Dependiente:',
                        'translation_domain' => false
                    ])
                    ->add('encargado', null, [
                        'label' => 'Encargado:',
                        'translation_domain' => false
                    ]);
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class
        ]);
    }
}

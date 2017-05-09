<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Movimiento;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Tests\Extension\Core\Type\PasswordTypeTest;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;


class SocioType extends AbstractType
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
                        'property_path' => 'usuario.nif',
                        'attr' => [
                            'readonly' => true
                        ]
                    ])
                    ->add('nombre', null, [
                        'label' => 'Nombre:',
                        'property_path' => 'usuario.nombre'
                    ])
                    ->add('apellidos', null, [
                        'label' => 'Apellidos:',
                        'property_path' => 'usuario.apellidos'
                    ])
                    ->add('direccion', null, [
                        'label' => 'Dirección:',
                        'property_path' => 'usuario.direccion'
                    ])
                    ->add('codigoPostal', null, [
                        'label' => 'Código postal:',
                        'property_path' => 'usuario.codigoPostal'
                    ])
                    ->add('localidad', null, [
                        'label' => 'Localidad:',
                        'property_path' => 'usuario.localidad'
                    ])
                    ->add('provincia', null, [
                        'label' => 'Provincia:',
                        'property_path' => 'usuario.provincia'
                    ])
                    ->add('telefono', null , [
                        'label' => 'Telefono:',
                        'property_path' => 'usuario.telefono'
                    ])
                    ->add('email', EmailType::class, [
                        'label' => 'Correo electrónico:',
                        'property_path' => 'usuario.email'
                    ])
                    ->add('descuento', PercentType::class, [
                        'label' => 'Descuento:',
                        'property_path' => 'usuario.descuento'
                    ]);
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Socio::class,
            'translation_domain' => false
        ]);
    }
}

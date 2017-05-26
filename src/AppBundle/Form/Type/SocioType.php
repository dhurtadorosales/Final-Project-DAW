<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Socio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


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
                        'constraints' => [
                            new Assert\Regex('/^[0-9]{8}[A-Z a-z]{1}$/')
                        ]
                    ])
                    ->add('nombre', null, [
                        'label' => 'Nombre:',
                        'property_path' => 'usuario.nombre'
                    ])
                    ->add('apellidos', null, [
                        'label' => 'Apellidos:',
                        'property_path' => 'usuario.apellidos',
                        'required' => true
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
                        'label' => 'Telefono: (opcional)',
                        'property_path' => 'usuario.telefono',
                        'required' => false
                    ])
                    ->add('email', EmailType::class, [
                        'label' => 'Correo electrónico: (opcional)',
                        'property_path' => 'usuario.email',
                        'required' => false
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

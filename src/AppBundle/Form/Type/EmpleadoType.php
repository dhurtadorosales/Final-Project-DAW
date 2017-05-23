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
                        'label' => 'Nif:'
                    ])
                    ->add('nombre', null, [
                        'label' => 'Nombre:'
                    ])
                    ->add('apellidos', null, [
                        'label' => 'Apellidos:'
                    ])
                    ->add('direccion', null, [
                        'label' => 'Dirección:'
                    ])
                    ->add('codigoPostal', null, [
                        'label' => 'Código postal:'
                    ])
                    ->add('localidad', null, [
                        'label' => 'Localidad:'
                    ])
                    ->add('provincia', null, [
                        'label' => 'Provincia:'
                    ])
                    ->add('telefono', null , [
                        'label' => 'Telefono:',
                        'required' => false
                    ])
                    ->add('email', EmailType::class, [
                        'label' => 'Correo electrónico:',
                        'required' => false
                    ])
                    ->add('descuento', PercentType::class, [
                        'label' => 'Descuento:'
                    ])
                    ->add('administrador', null, [
                        'label' => 'Administrador:'
                    ])
                    ->add('comercial', null, [
                        'label' => 'Comercial:'
                    ])
                    ->add('dependiente', null, [
                        'label' => 'Dependiente:'
                    ])
                    ->add('encargado', null, [
                        'label' => 'Encargado:'
                    ]);
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
            'translation_domain' => false
        ]);
    }
}

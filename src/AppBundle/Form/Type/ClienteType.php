<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Forms;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;


class ClienteType extends AbstractType
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
                        'constraints' => [
                            new Assert\Regex('/([A-Z a-z]{1}\d{8})|(\d{8}[A-Z a-z]{1})/')
                        ]
                    ])
                    ->add('nombre', null, [
                        'label' => 'Nombre:',
                        'constraints' => [
                            new Assert\Regex('/^[A-Z a-zÑñáéíóúÁÉÍÓÚ , .]*$/')
                        ]
                    ])
                    ->add('apellidos', null, [
                        'label' => 'Apellidos:',
                        'required' => false,
                        'constraints' => [
                            new Assert\Regex('/^[A-Z a-zÑñáéíóúÁÉÍÓÚ , .]*$/')
                        ]
                    ])
                    ->add('direccion', null, [
                        'label' => 'Dirección:',
                        'constraints' => [
                            new Assert\Regex('/[a-zA-Z1-9À-ÖØ-öø-ÿ]+\.?(( |\-)[a-zA-Z1-9À-ÖØ-öø-ÿ]+\.?)* (((#|[nN][oO]\.?) ?)?\d{1,4}(( ?[a-zA-Z0-9\-]+)+)?)/')
                        ]
                    ])
                    ->add('codigoPostal', null, [
                        'label' => 'Código postal:',
                        'constraints' => [
                            new Assert\Regex('/^[0-9]{5}$/')
                        ]
                    ])
                    ->add('localidad', null, [
                        'label' => 'Localidad:',
                        'constraints' => [
                            new Assert\Regex('/^[A-Z a-zÑñáéíóúÁÉÍÓÚ]*$/')
                        ]
                    ])
                    ->add('provincia', null, [
                        'label' => 'Provincia:',
                        'constraints' => [
                            new Assert\Regex('/^[A-Z a-zÑñáéíóúÁÉÍÓÚ]*$/')
                        ]
                    ])
                    ->add('telefono', null , [
                        'label' => 'Telefono: (opcional)',
                        'required' => false,
                        'constraints' => [
                            new Assert\Regex('/^[0-9]{9}$/')
                        ]
                    ])
                    ->add('email', EmailType::class, [
                        'label' => 'Correo electrónico: (opcional)',
                        'required' => false
                    ])
                    ->add('descuento', PercentType::class, [
                        'label' => 'Descuento:'
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

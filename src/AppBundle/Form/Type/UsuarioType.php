<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Length;


class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nif', null, [
                'label' => 'form.nif'
            ])
            ->add('administrador', null, [
                'label' => 'form.administrador',
                'disabled' => ($options['es_administrador'] === false)
            ]);

        if (false === $options['es_administrador']) {
            $builder
                ->add('antigua', PasswordType::class, [
                    'label' => 'form.clave_antigua',
                    'mapped' => false,
                    'constraints' => [
                        new UserPassword()
                    ]
                ]);
        }

        $builder
            ->add('nueva', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'form.clave_nueva',
                ],
                'second_options' => [
                    'label' => 'form.clave_nueva_repetir'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
            'translation_domain' => 'usuario',
            'es_administrador' => false,
            'el_mismo' => false
        ]);
    }
}

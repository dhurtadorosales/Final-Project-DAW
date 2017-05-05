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
                    ->add('usuario', CollectionType::class, [
                        'entry_type' => Usuario2Type::class,
                        'entry_options' => [
                            'temporada' => $options['usuario'],
                            'label' => false
                        ],
                    ])
                    ->add('fechaAlta', null, [
                        'label' => 'Fecha de alta:',
                        'translation_domain' => false
                    ])
                    ->add('activo', null, [
                        'label' => 'Activo',
                        'translation_domain' => false,
                        'attr' => [
                            'readonly' => true
                        ]
                    ])
                    ->add('fechaBaja', null, [
                        'label' => 'Fecha de baja:',
                        'translation_domain' => false
                    ]);
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Socio::class,
            'fecha' => null,
            'usuario' => null
        ]);
    }
}

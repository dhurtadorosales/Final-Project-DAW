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


class FincaModificarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($options) {
                $form = $event->getForm();
                $data = $event->getData();
                $form
                    ->add('numPlantas', null , [
                        'label' => 'Número de plantas:',
                        'translation_domain' => false
                    ])
                    ->add('regadio', null, [
                        'label' => 'Regadío',
                        'translation_domain' => false
                    ])
                    ->add('partPropietario', PercentType::class, [
                        'label' => 'Participación del propietario: (sobre 1)',
                        'translation_domain' => false
                    ])
                    ->add('partArrend', PercentType::class, [
                        'label' => 'Participación del arrendatario: (sobre 1)',
                        'translation_domain' => false
                    ])
                    ->add('variedad', null, [
                        'label' => 'Variedad de aceituna:',
                        'placeholder' => '[Ninguna]',
                        'translation_domain' => false
                    ])
                    ->add('propietario', null, [
                        'label' => 'Propietario:',
                        'placeholder' => '[Ninguno]',
                        'translation_domain' => false
                    ])
                    ->add('arrendatario', null, [
                        'label' => 'Arrendatario:',
                        'placeholder' => '[Ninguno]',
                        'translation_domain' => false
                    ]);
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Finca::class
        ]);
    }
}

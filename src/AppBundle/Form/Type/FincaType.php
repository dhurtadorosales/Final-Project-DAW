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
                        'translation_domain' => false
                    ])
                    ->add('provincia', null, [
                        'label' => 'Provincia:',
                        'translation_domain' => false,
                    ])
                    ->add('municipio', null, [
                        'label' => 'Municipio:',
                        'translation_domain' => false
                    ])
                    ->add('sector', null, [
                        'label' => 'Sector:',
                        'translation_domain' => false
                    ])
                    ->add('poligono', null, [
                        'label' => 'Polígono:',
                        'translation_domain' => false
                    ])
                    ->add('parcela', null, [
                        'label' => 'Parcela:',
                        'translation_domain' => false
                    ])
                    ->add('idInmueble', null, [
                        'label' => 'Identificación del inmueble:',
                        'translation_domain' => false
                    ])
                    ->add('caracterControl', null, [
                        'label' => 'Caracteres de control:',
                        'translation_domain' => false
                    ])
                    ->add('numPlantas', null , [
                        'label' => 'Número de plantas:',
                        'translation_domain' => false
                    ])
                    ->add('regadio', null, [
                        'label' => 'Regadío',
                        'translation_domain' => false
                    ])
                    ->add('partPropietario', null, [
                        'label' => 'Participación del propietario: (sobre 1)',
                        'translation_domain' => false
                    ])
                    ->add('partArrend', null, [
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

<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Aceite;
use AppBundle\Entity\Lote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AceiteNuevoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($options) {
                $form = $event->getForm();
                $data = $event->getData();
                $form
                    ->add('denominacion', null, [
                        'label' => 'Denominación:'
                    ])
                    ->add('densidadKgLitro', null, [
                        'label' => 'Densidad:'
                    ])
                    ->add('precioKg', null, [
                        'label' => 'Precio (€/kg):'
                    ]);
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Aceite::class,
            'translation_domain' => false
        ]);
    }
}

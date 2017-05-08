<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Porcentaje;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class PorcentajeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($options) {
                $form = $event->getForm();
                $data = $event->getData();
                $form
                    ->add('cantidad', PercentType::class, [
                        'label' => $data . ' %:'
                    ]);
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Porcentaje::class,
            'translation_domain' => false
        ]);
    }
}

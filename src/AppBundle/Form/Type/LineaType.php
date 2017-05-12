<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Linea;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Producto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LineaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cantidad', null, [
                'label' => 'Cantidad:',
            ])
            ->add('producto', EntityType::class, [
                'class' => Producto::class,
                'label' => 'Producto:',
                'mapped' => false
            ])
            ->add('lote', EntityType::class, [
                'class' => Lote::class,
                'label' => 'Lote:',
                'mapped' => false
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($options) {
                $form = $event->getForm();
                $data = $event->getData();
                $form
                    ->add('precio', null, [
                        'label' => 'Precio:',
                    ]);
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Linea::class,
            'venta' => null,
            'translation_domain' => false
        ]);
    }
}

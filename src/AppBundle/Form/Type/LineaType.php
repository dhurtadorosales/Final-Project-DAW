<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Linea;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Producto;
use AppBundle\Repository\LoteRepository;
use AppBundle\Repository\ProductoRepository;
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
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($options) {
                $form = $event->getForm();
                $data = $event->getData();
                $form
                    ->add('cantidad', null, [
                        'label' => 'Cantidad:',
                    ])
                    ->add('producto', null, [
                        'label' => 'Producto:',
                        'required' => false,
                        'placeholder' => '[Ninguno]'
                    ])
                    ->add('lote', EntityType::class, [
                        'class' => Lote::class,
                        'label' => 'Lote:',
                        'query_builder' => function (LoteRepository $loteRepository) use ($options) {
                            return $loteRepository->getLotesNoNulosQuery();
                        },
                        'mapped' => false,
                        'required' => false,
                        'placeholder' => '[Ninguno]'
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

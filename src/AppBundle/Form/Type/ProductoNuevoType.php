<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Lote;
use AppBundle\Entity\Producto;
use AppBundle\Repository\LoteRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ProductoNuevoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($options) {
                $form = $event->getForm();
                $data = $event->getData();
                $form
                    ->add('envase', null, [
                        'label' => 'Envase:',
                        'placeholder' => '[Ninguno]'
                    ])
                    /*->add('lotes', null, [
                        'label' => 'Aceites:',
                        'class' => Lote::class,
                        'mapped' => false,
                        'query_builder' => function(LoteRepository $aceiteRepository) use ($options) {
                            return $aceiteRepository->getLotesTemporadaQuery($options['temporada']);
                        },
                        'placeholder' => '[Ninguno]'
                    ])*/
                    ->add('lotes', null, [
                        'label' => 'Aceite:'
                    ])
                    ->add('precio', null, [
                        'label' => 'Precio (€/ud):'
                    ]);
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
            'temporada' => null,
            'translation_domain' => false
        ]);
    }
}

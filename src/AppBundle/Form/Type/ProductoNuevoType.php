<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Producto;
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
                    /*->add('aceites', EntityType::class, [
                        'class' => Aceite::class,
                        'mapped' => false,
                        'query_builder' => function(AceiteRepository $aceiteRepository) use ($options) {
                            return $aceiteRepository->getAceites();
                        }
                    ])*/
                    ->add('lotes', null, [
                        'label' => 'Aceites:',
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
            'translation_domain' => false
        ]);
    }
}

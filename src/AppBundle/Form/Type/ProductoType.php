<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Lote;
use AppBundle\Entity\Producto;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Repository\LoteRepository;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
                ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($options) {
                    $form = $event->getForm();
                    $data = $event->getData();
                    $form
                        ->add('lotes', EntityType::class, [
                            'class' => Lote::class,
                            'mapped' => false,
                            'query_builder' => function(LoteRepository $loteRepository) use ($options) {
                                return $loteRepository->getLotesAceiteNoNulosQuery($options['aceite']);
                            },
                            'placeholder' => '[Ninguno]',
                        ])
                        ->add('stock', null, [
                            'label' => 'Cantidad (kg):',
                            'data' => null
                        ]);
                });
}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
            'temporada' => null,
            'aceite' => null,
            'translation_domain' => false
        ]);
    }
}

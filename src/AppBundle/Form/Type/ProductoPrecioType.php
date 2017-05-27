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

class ProductoPrecioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
                ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($options) {
                    $form = $event->getForm();
                    $data = $event->getData();
                    $form
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

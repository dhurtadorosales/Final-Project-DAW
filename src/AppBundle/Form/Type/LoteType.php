<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Lote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class LoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('aceite', null, [
                'label' => 'Nombre del lote',
                'placeholder' => '[Ninguno]'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lote::class,
        ]);
    }
}

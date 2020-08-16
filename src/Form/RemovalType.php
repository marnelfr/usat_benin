<?php

namespace App\Form;

use App\Entity\Removal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemovalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status')
            ->add('bfuNum')
            ->add('entryNum')
            ->add('agent')
            ->add('vehicle')
            ->add('remover')
            ->add('payBank')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Removal::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Removal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemovalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vehicle', null, [
                'label' => 'Véhicule',
                'attr' => [
                    'disabled' => true
                ]
            ])
            ->add('vehicle_id', HiddenType::class, [
                'mapped' => false
            ])
//            ->add('status')
            ->add('bfuNum', TextType::class, [
                'label' => 'N° BFU'
            ])
            ->add('entryNum', TextType::class, [
                'label' => 'N° déclaration de Douane'
            ])
//            ->add('agent')
            ->add('remover', null, [
                'label' => 'Enleveur'
            ])
            ->add('payBank', null, [
                'label' => 'Banque de payement'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Removal::class,
        ]);
    }
}

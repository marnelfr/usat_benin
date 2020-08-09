<?php

namespace App\Form;

use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chassis', TextType::class, [
                'label' => 'N° Châssis'
            ])
            ->add('brand', null, [
                'label' => 'Marque',
                'placeholder' => 'Choississez une marque'
            ])
            ->add('ship', null, [
                'label' => 'Navire d\'arrivage',
                'placeholder' => 'Choississez un navire'
            ])
            ->add('consignee', TextType::class, [
                'label' => 'Consignataire'
            ])
            ->add('importer', null, [
                'label' => 'Importateur'
            ])
            ->add('putInUseAt', null, [
                'label' => 'Mise en circulation le'
            ])
            ->add('cameAt', null, [
                'label' => 'Arrivé le'
            ])
//            ->add('createdAt')
//            ->add('removal')
//            ->add('transfer')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}

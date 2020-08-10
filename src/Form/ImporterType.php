<?php

namespace App\Form;

use App\Entity\Importer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImporterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', null, [
                'label' => 'Prénom'
            ])
            ->add('lastName', null, [
                'label' => 'Nom'
            ])
            ->add('phone', null, [
                'label' => 'N° Téléphone'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => false
            ])
            ->add('address', null, [
                'label' => 'Adresse'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Importer::class,
        ]);
    }
}

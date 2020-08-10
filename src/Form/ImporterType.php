<?php

namespace App\Form;

use App\Entity\Importer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImporterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('lastName')
            ->add('phone')
            ->add('e_mail', EmailType::class, [
                'label' => 'Email',
                'mapped' => false,
                'required' => false
            ])
            ->add('email', HiddenType::class, [
                'attr' => [
                    'value' => 'nel@dev.fr'
                ]
            ])
            ->add('address')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Importer::class,
        ]);
    }
}

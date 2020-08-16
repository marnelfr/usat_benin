<?php

namespace App\Form;

use App\Entity\Remover;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RemoverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('phone', TelType::class, [
                'label' => 'N° Téléphone'
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail'
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('cinName', FileType::class, [
                'label' => 'CIN',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => true,

                'help' => 'Veuillez choisir un fichier image <b>jpg/jpeg</b> ou <b>png</b> d\'au plus 2048ko (2Mo)',
                'help_html' => true,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '2040k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez choisir un fichier image jpg ou png',
                    ])
                ],
            ])
//            ->add('cin', FileType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Remover::class,
        ]);
    }
}

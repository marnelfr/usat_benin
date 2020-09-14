<?php

namespace App\Form;

use App\Entity\Inform;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class InformType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre'
            ])
            ->add('resume', null, [
                'label' => 'Résumé'
            ])
            //https://symfony.com/doc/current/bundles/FOSCKEditorBundle/installation.html
            //https://symfony.com/doc/current/bundles/FOSCKEditorBundle/index.html
            ->add('content', CKEditorType::class, [
                'label' => 'Contenu',
                'config' => [
                    'uiColor' => '#ffffff'
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Image',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inform::class,
        ]);
    }
}

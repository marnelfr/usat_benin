<?php

namespace App\Form;

use App\Entity\Removal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RemovalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('vehicle', null, [
                'label' => 'Véhicule',
                'attr' => [
                    'disabled' => true
                ]
            ])*/
            ->add('vehicule', null, [
                'label' => 'Véhicule',
                'mapped' => false,
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
            ->add('bfu', FileType::class, $this->getFileOption('BFU reglé scanné'))
            ->add('entryNum', TextType::class, [
                'label' => 'N° déclaration de Douane'
            ])
            ->add('entry', FileType::class, $this->getFileOption('Déclaration de Douane scanné'))
//            ->add('agent')
            ->add('remover', null, [
                'label' => 'Enleveur',
                'placeholder' => 'Sélectionnez un enleveur'
            ])
            ->add('payBank', null, [
                'label' => 'Banque de payement',
                'placeholder' => 'Sélectionnez une banque'
            ])
            ->add('receipt', FileType::class, $this->getFileOption('Reçu de banque scanné'))
        ;
    }

    private function getFileOption(string $label): array {
        return [
            'label' => $label,

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
        ];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Removal::class,
        ]);
    }
}

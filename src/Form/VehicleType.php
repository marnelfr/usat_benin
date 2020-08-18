<?php

namespace App\Form;

use App\Entity\Vehicle;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

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
                'label' => 'Importateur',
                'placeholder' => 'Selectionnez un importateur',
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->where('i.deleted=0')
                        ->orderBy('i.id', 'DESC')
                    ;
                },
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('putInUseAt', DateType::class, [
                'label' => 'Mise en circulation le',
                'widget' => 'single_text',
            ])
            ->add('cameAt', null, [
                'label' => 'Arrivé le',
                'widget' => 'single_text',

                // prevents rendering it as type="date", to avoid HTML5 date pickers
//                'html5' => false,

                // adds a class that can be selected in JavaScript
//                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('bol', FileType::class, [
                'label' => 'Connaissement',

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

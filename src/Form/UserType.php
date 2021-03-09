<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label' => 'Identifiant'])
            ->add('name', TextType::class, ['label' => 'Prénom'])
            ->add('lastName', TextType::class, ['label' => 'Nom'])
            ->add('password', TextType::class, ['label' => 'Code d\'accès'])
            ->add('phone', TelType::class, ['label' => 'N° Téléphone'])
            ->add('email', EmailType::class, ['label' => 'E-mail'])
            ->add('address', TextType::class, ['label' => 'Adresse'])
//            ->add('status')
//            ->add('createdAt')
//            ->add('lastConnection')
//            ->add('isVerified')
            ->add('profil', null, [
                'label' => 'Rôle',
                'placeholder' => 'Selectionnez un rôle',
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
//                        ->where('p.public=0')
                        ->andWhere("p.slug <> 'importer'")
                        ->orderBy('p.name')
                        ;
                },
            ])
            ->add('image', FileType::class, [
                'label' => 'Photo de Profile',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                'help' => 'Veuillez choisir un fichier image <b>jpg/jpeg</b> ou <b>png</b> d\'au plus 1024ko (1Mo)',
                'help_html' => true,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
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
            'data_class' => User::class,
        ]);
    }
}

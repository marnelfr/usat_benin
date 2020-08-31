<?php

namespace App\Form;

use App\Entity\Fleet;
use App\Entity\Profil;
use App\Entity\User;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Identifiant',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez renseigner un identifiant'
                    ]),
                    new NotNull([
                        'message' => 'Vous devez renseigner un identifiant'
                    ])
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('phone', TelType::class, [
                'label' => 'Téléphone'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse Email',
            ])
            ->add('address', TextType::class, [
                'label' => 'Votre adresse'
            ])
            ->add('profil', EntityType::class, [
                'label' => 'Profil',
                'class' => Profil::class,
                'placeholder' => 'Sélectionnez votre profil',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->where('p.public = 1')
                        ->orderBy('p.name', 'ASC');
                },
                'choice_value' => 'slug'
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'J\'accepte les conditions d\'utilisation',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos termes et conditions',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Les codes d\'accès doivent être les mêmes',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Code d\'accès'],
                'second_options' => ['label' => 'Retapez le code'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un code d\'accès s\'il vous plait',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le code d\'accès doit avoir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ]
            ])->add('compagny', TextType::class, [
                'mapped' => false,
                'label' => 'Compagnie'
            ])/*->add('ifu', TextType::class, [
                'mapped' => false,
                'label' => 'N° IFU'
            ])->add('registerNum', TextType::class, [
                'mapped' => false,
                'label' => 'N° d\'enregistrement'
            ])->add('fleet', null, [
                'mapped' => false,
                'label' => 'Parc'
            ])*/
            ->add('fleet', EntityType::class, [
                'mapped' => false,
                'label' => 'Parc',
                'required' => false,
                'class' => Fleet::class,
                'placeholder' => 'Sélectionnez votre parc'
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

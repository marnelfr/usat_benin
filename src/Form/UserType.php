<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                        ->where('p.public=0')
                        ->andWhere("p.slug <> 'importer'")
                        ->orderBy('p.id', 'DESC')
                        ;
                },
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

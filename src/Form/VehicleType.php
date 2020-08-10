<?php

namespace App\Form;

use App\Entity\Importer;
use App\Entity\Vehicle;
use App\Repository\ProfilRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleType extends AbstractType
{
    private $userRepo;
    private $profilRepo;

    public function __construct(UserRepository $repository, ProfilRepository $profilRepository)
    {
        $this->userRepo = $repository;
        $this->profilRepo = $profilRepository;
    }

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
            ->add('importateur', ChoiceType::class, [
                'mapped' => false,
                'required' => true,
                'choice_loader' => new CallbackChoiceLoader(function() {
                    $users = $this->userRepo->findBy([
                        'profil' => $this->profilRepo->findOneBy(['slug' => 'importer'])
                    ]);
                    $tab = [];
                    foreach ($users as $user) {
                        $tab[$user->getFullname()] = $user->getId();
                    }
                    return $tab;
                }),
                'label' => 'Importateur'
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

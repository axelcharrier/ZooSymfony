<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Enclo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('nom')
            ->add('date_naissance')
            ->add('date_arrive')
            ->add('date_depart')
            ->add('genre', ChoiceType::class, [
                'choices' => [
                    'Mâle' => 'male',
                    'Femelle' => 'femelle',
                    'Non défini' => 'non définie',
                ],
                'placeholder' => 'Choisir un genre', // optionnel
            ])
            ->add('espece')
            ->add('sterilise')
            ->add('quarantaine')
            ->add('id_enclo', EntityType::class, [
                'class' => Enclo::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}

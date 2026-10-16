<?php
// src/Form/AvisType.php

namespace App\Form;

use App\Entity\Avis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $notes = ['⭐' => 1, '⭐⭐' => 2, '⭐⭐⭐' => 3, '⭐⭐⭐⭐' => 4, '⭐⭐⭐⭐⭐' => 5];

        $builder
            ->add('note', ChoiceType::class, ['label' => 'Note globale', 'choices' => $notes])
            ->add('noteNettete', ChoiceType::class, ['label' => 'Propreté', 'choices' => $notes])
            ->add('noteEmplacement', ChoiceType::class, ['label' => 'Emplacement', 'choices' => $notes])
            ->add('noteRapportQualite', ChoiceType::class, ['label' => 'Rapport qualité/prix', 'choices' => $notes])
            ->add('commentaire', TextareaType::class, [
                'label' => 'Votre avis',
                'attr' => ['rows' => 5, 'placeholder' => 'Décrivez votre séjour...'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Avis::class]);
    }
}
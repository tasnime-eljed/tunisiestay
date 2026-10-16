<?php

namespace App\Form;

use App\Entity\Equipement;
use App\Entity\Logement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class LogementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => false,
                'constraints' => [new NotBlank(message: 'Le titre est requis')],
                'attr' => ['placeholder' => 'Ex: Villa avec piscine à Djerba'],
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Décrivez votre logement...', 'rows' => 5],
            ])
            ->add('type', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Villa' => 'villa',
                    'Appartement' => 'appartement',
                    'Riad' => 'riad',
                    'Chalet' => 'chalet',
                    'Maison d\'hôte' => 'maison_hote',
                    'Bungalow' => 'bungalow',
                ],
            ])
            ->add('devise', ChoiceType::class, [
                'label' => false,
                'choices' => ['TND (Dinar Tunisien)' => 'TND', 'EUR (Euro)' => 'EUR'],
            ])
            ->add('prixParNuit', NumberType::class, [
                'label' => false,
                'scale' => 2,
                'constraints' => [new Positive(message: 'Le prix doit être positif')],
                'attr' => ['placeholder' => '0.00'],
            ])
            ->add('maxVoyageurs', NumberType::class, [
                'label' => false,
                'attr' => ['min' => 1, 'max' => 20, 'placeholder' => '1'],
            ])
            ->add('chambres', NumberType::class, [
                'label' => false,
                'attr' => ['min' => 1, 'placeholder' => '1'],
            ])
            ->add('sallesDeBain', NumberType::class, [
                'label' => false,
                'attr' => ['min' => 1, 'placeholder' => '1'],
            ])
            ->add('adresse', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Rue, numéro...'],
            ])
            ->add('ville', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Ex: Djerba'],
            ])
            ->add('region', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Ex: Médenine'],
            ])
            ->add('latitude', NumberType::class, [
                'label' => false,
                'required' => false,
                'scale' => 7,
                'attr' => ['placeholder' => '33.8869'],
            ])
            ->add('longitude', NumberType::class, [
                'label' => false,
                'required' => false,
                'scale' => 7,
                'attr' => ['placeholder' => '9.5375'],
            ])
            ->add('equipements', EntityType::class, [
                'class' => Equipement::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
                'label' => false,
                'required' => false,
            ])
            ->add('images', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Logement::class]);
    }
}
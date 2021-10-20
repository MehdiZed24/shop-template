<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('firstname', TextType::class, [
        'label' => "Votre prenom",
        'constraints' => new Length(null, 2, 30),
        'constraints' => new NotBlank(null, 'Veuillez renseigner ce champ'),
        'attr' => [
          'placeholder' => "Merci de saisir votre prénom"
        ]
      ])
      ->add('lastname', TextType::class, [
        'constraints' => new Length(null, 2, 30),
        'constraints' => new NotBlank(null, 'Veuillez renseigner ce champ'),

        'label' => "Votre Nom",
        'attr' => [
          'placeholder' => "Merci de saisir votre nom"
        ]
      ])
      ->add('email', EmailType::class, [
        'constraints' => new Length(null, 2, 40),
        'constraints' => new NotBlank(null, 'Veuillez renseigner ce champ'),
        'label' => "Votre email",
        'attr' => [
          'placeholder' => "Merci de saisir votre email"
        ]
      ])
      ->add('password', RepeatedType::class, [
        'type' => PasswordType::class,
        'constraints' => new Length(null, 8, 16),
        'constraints' => new NotBlank(null, 'Veuillez renseigner ce champ'),
        'invalid_message' => "Le mot de passe n'est pas identique",
        'label' => 'Votre mot de passe',
        'required' => true,
        "first_options" => [
          'label' => 'Mot de Passe',
          "attr" => [
            "placeholder" => "Veuillez saisir votre mot de passe"
          ]
        ],
        "second_options" => [
          'label' => 'Confirmation de votre mot de passe',
          "attr" => [
            "placeholder" => "Veuillez de confirmer votre mot de passe"
          ]
        ],
        'attr' => [
          'placeholder' => 'Merci de saisir votre mot de passe'
        ]
      ])

      ->add('submit', SubmitType::class, ['label' => "S'inscrire"]); //Bouton Submit 
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => User::class,
    ]);
  }
}

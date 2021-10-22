<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('email', EmailType::class, [
        'disabled' => true,
        'label' => "Mon adresse email"
      ])

      ->add('firstname', TextType::class, [
        'disabled' => true,
        'label' => "Mon prénom"
      ])

      ->add('lastname', TextType::class, [
        'disabled' => true,
        'label' => "Mon nom"
      ])

      ->add('old_password', PasswordType::class, [
        'mapped' => false,
        'label' => "Mot de passe actuel",
        'attr' => [
          'placeholder' => 'Veuillez saisir votre mot de passe actuel'
        ]
      ])

      ->add('new_password', RepeatedType::class, [
        'type' => PasswordType::class,
        'mapped' => false,
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
          'label' => 'Confirmation de votre nouveau mot de passe',
          "attr" => [
            "placeholder" => "Veuillez confirmer votre nouveau mot de passe"
          ]
        ],
        'attr' => [
          'placeholder' => 'Merci de saisir votre mot de passe'
        ]
      ])
      ->add('submit', SubmitType::class, ['label' => "Mettre à jour"]); 
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => User::class,
    ]);
  }
}

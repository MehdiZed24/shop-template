<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegisterType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('firstname', TextType::class, [
        'label' => "Votre prenom",
        'attr' => [
          'placeholder' => "Merci de saisir votre prénom"
        ]
      ])
      ->add('lastname', TextType::class, [
        'label' => "Votre Nom",
        'attr' => [
          'placeholder' => "Merci de saisir votre nom"
        ]
      ])
      ->add('email', EmailType::class, [
        'label' => "Votre email",
        'attr' => [
          'placeholder' => "Merci de saisir votre email"
        ]
      ])
      ->add('password', PasswordType::class, [
        'label' => 'Votre mot de passe',
        'attr' => [
          'placeholder' => 'Merci de saisir votre mot de passe'
        ]
      ])
      ->add('password_confirm',PasswordType::class,[
        'label'=>'Confirmation du mot de passe',
        'mapped'=>false, //mapped signifie que ce cette proprièté ne sera pas liée à notre entitée.
        'attr'=>[
          'placeholder' => "Veuillez confirmer votre mot de passe"
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

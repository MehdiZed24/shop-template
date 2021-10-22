<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountPasswordController extends AbstractController
{
  private $entityManager;
  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }
  /**
   * @Route("/compte/modification-motdepasse", name="account_password")
   */
  public function index(Request $request, UserPasswordHasherInterface $encoder): Response
  {
$notification = null;

    $user = $this->getUser();
    $form = $this->createForm(ChangePasswordType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $old_password = $form->get('old_password')->getData();

      if ($encoder->isPasswordValid($user, $old_password)) {
        $new_password = $form->get('new_password')->getData();
        $password = $encoder->hashPassword($user, $new_password);

        $user->setPassword($password);
        $this->entityManager->flush();
        $notification="Votre mot de passe a bien été mis a jour";
      } else {
        $notification = "Votre mot de passe actuel n'est pas correct";
      }
    }




    return $this->render('account/password.html.twig', [
      'form' => $form->createView(),
      'notification'=>$notification
    ]);
  }
}

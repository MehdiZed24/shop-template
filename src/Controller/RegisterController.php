<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; //<--Conséquence de la ligne 17
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
  private $entityManager;
  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }

  /**
   * @Route("/inscription", name="register")
   */
  public function index(Request $request, UserPasswordHasherInterface $encoder)
  { //<-- cf ligne 36

    $user = new User();
    $form = $this->createForm(RegisterType::class, $user);

    //Dès que ce formulaire est soumis, je veux que tu traites l'information que tu controles si le formulaire est valide et ensuite pouvoir l'enregistrer dans la BDD

    $form->handleRequest($request);
    //Nous demandons à notre formulaire qu'il écoute la requète entrante->Pour cela on utilise la méthode handleRequest
    //Cela va utiliser la méthode d'injection de dépendance de Symfony,
    // /!\ATTENTION, ne pas oublier de placer la variable $request en paramètre de index()! Voir plus haut ligne 25



    if ($form->isSubmitted() && $form->isValid()) { //<--Est ce que mon formulaire a été soumis ET est ce qu'il est valide par rapport aux contraintes qu'on lui a soumis (dans notre cas TextType, EmailType etc...)?

      $user = $form->getData(); //Cela injecte dans mon objet user toutes les données que tu récupères dans le formulaire 
      //dd($user);

      $password = $encoder->hashPassword($user, $user->getPassword());
      $user->setPassword($password);

      $this->entityManager->persist($user);
      $this->entityManager->flush();
    }

    return $this->render('register/index.html.twig', [
      'form' => $form->createView(),
    ]);
  }
}

<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{

  private $session;

  public function __construct(SessionInterface $session)
  {
    $this->session = $session;
  }

  public function add($id)
  {
    $cart = $this->session->get('cart', []);

    if (!empty($cart[$id])) {
      $cart[$id]++;
    } else {
      $cart[$id] = 1;
    }

    $this->session->set('cart', $cart);
  }

  public function get()
  {
    return $this->session->get('cart');
  }

  public function remove()
  {
    return $this->session->remove('cart');
  }

  public function delete($id)
  {
    $cart = $this->session->get('cart');
    unset($cart[$id]); //on utilise unset car cart est un tableau.

    // return $cart; on a passé la formule en dessous pour bien reset le cart une fois que la fonction delete a agi.
    
    return $this->session->set('cart', $cart);
  }
}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

   /**
   * @ORM\Column(type="string")
   */
   private $name;

   /**
   * @ORM\Column(type="string")
   */
   private $firstname;

   //Getters & Setters
  public function getId(){
    return $this->id;
  }

  public function getName(){
    return $this->name;
  }

  public function getFirstname(){
    return $this->firstname;
  }

  public function setName($name){
    $this->name = $name;
  }

  public function setFirstname($firstname){
    $this->firstname = $firstname;
  }
}

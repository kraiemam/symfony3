<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class Product
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
   private $label;


   //Getters & Setters
  public function getId(){
    return $this->id;
  }

  public function getLabel(){
    return $this->label;
  }

  public function setLabel($label){
    $this->label = $label;
  }
}

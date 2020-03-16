<?php



namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class Subscription
{
/**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

  
   /**
     * @ORM\ManyToOne(targetEntity="Contact", cascade={"all"}, fetch="EAGER")
     */
    private $contact;


    /**
     * @ORM\ManyToOne(targetEntity="Product", cascade={"all"}, fetch="EAGER")
     */
    private $product;



  /**
   * @ORM\Column(type="datetime")
   */
   private $beginDate;


 /**
   * @ORM\Column(type="datetime")
   */
   private $endDate;

   public function getId(){
      return $this->id;
    }

    public function setId($id){
    $this->id = $id;
  }
    /**
   * Set Contact
   *
   * @param \AppBundle\Entity\Contact $contact
   *
   * @return Contact
   */

   
  public function setContact($contact)
  {
    $this->contact = $contact;
    
  }

  /**
   * Get Contact
   *
   * @return \AppBundle\Entity\Contact
   */
  public function getContact()
  {
    return $this->contact;
  }

     /**
   * Set Product
   *
   * @param \AppBundle\Entity\Product $product
   *
   * @return Product
   */
  public function setProduct($product)
  {
    $this->product = $product;

    return $this;
  }

  /**
   * Get Product
   *
   * @return \AppBundle\Entity\Product
   */
  public function getProduct()
  {
    return $this->product;
  }


  public function getBeginDate(){
    return $this->beginDate;
  }

  public function setBeginDate($beginDate){
    $this->beginDate = $beginDate;
  }
  public function getEndDate(){
    return $this->endDate;
  }

  public function setEndDate($endDate){
    $this->endDate = $endDate;
  }

}

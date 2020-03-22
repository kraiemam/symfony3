<?php

namespace AppBundle\Controller;



use AppBundle\Entity\Subscription;
use AppBundle\Entity\Contact;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
class SubscriptionController extends Controller
{
     /**
     * @Route("/subscription/{id}", name="subscription_view")
     * @Method({"GET"})
     */
    public function viewSubscriptionAction($id)
    {
       $contact=$this->getDoctrine()->getRepository('AppBundle:Contact')->findBy(array('id' => $id ));
        $Subscription = $this->getDoctrine()->getRepository('AppBundle:Subscription')->findBy(array('contact' => $contact ));
        $data = $this->get('jms_serializer')->serialize($Subscription, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/subscription", name="subscription_create")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        
        $datacatprod = json_decode($request->getContent(), true);
        $contact=$this->getDoctrine()->getRepository('AppBundle:Contact')->find($datacatprod["contact_id"]);
        $product=$this->getDoctrine()->getRepository('AppBundle:Product')->find($datacatprod["product_id"] );
           if (empty($contact)) {
                 return new Response("contact not found", Response::HTTP_NOT_FOUND);
            } 
           if (empty($product)) {
                return new Response("product not found", Response::HTTP_NOT_FOUND);
            } 
        $data = $request->getContent();
        $Subscription = $this->get('jms_serializer')->deserialize($data, 'AppBundle\Entity\Subscription', 'json');
        
        $Subscription->setContact($contact);
        $Subscription->setProduct($product);

        $em = $this->getDoctrine()->getManager();
        $em->persist($Subscription);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }
    /**
     * @Route("/subscription/{id}", name="subscription_update")
     * @Method({"PUT"})
     */
  public function updateAction($id,Request $request)
     { 
        $datacatprod = json_decode($request->getContent(), true);
        $contact=$this->getDoctrine()->getRepository('AppBundle:Contact')->find($datacatprod["contact_id"]);
        $product=$this->getDoctrine()->getRepository('AppBundle:Product')->find($datacatprod["product_id"] );
    $data = $request->getContent();
    $Subscriptions = $this->get('jms_serializer')->deserialize($data, 'AppBundle\Entity\Subscription', 'json');
    
     $sn = $this->getDoctrine()->getManager();
     $Subscription = $this->getDoctrine()->getRepository('AppBundle:Subscription')->find($id);
     if (empty($contact)) {
       return new Response("contact not found", Response::HTTP_NOT_FOUND);
     } 
     if (empty($product)) {
       return new Response("product not found", Response::HTTP_NOT_FOUND);
     } 
    if (empty($Subscription)) {
       return new Response("Subscription not found", Response::HTTP_NOT_FOUND);
     } 

        $Subscriptions->setId(intval($id));
        $Subscriptions->setContact($contact);
        $Subscriptions->setProduct($product);
        $em = $this->getDoctrine()->getManager();
        $em->merge($Subscriptions);
        $em->flush();
       return new Response("Subscription Updated Successfully", Response::HTTP_OK);
    }
    /**
     * @Route("/subscription/{id}", name="subscription_delete")
     * @Method({"DELETE"})
     */
     public function deleteAction($id)
     {

      $em = $this->getDoctrine()->getManager();
      $Subscription = $this->getDoctrine()->getRepository('AppBundle:Subscription')->find($id);
    if (empty($Subscription)) {
      
       return new Response('Subscription not found', Response::HTTP_NOT_FOUND);
     }
     else {
      $em->remove($Subscription);
      $em->flush();
     }
     return new Response('deleted successfully',  Response::HTTP_OK);
     
     }
}

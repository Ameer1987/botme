<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\CartType;
use AppBundle\Entity\Item;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cart controller.
 *
 */
class CartController extends Controller
{
    public function addProductAction($product_id, $type_id)
    {
        $em = $this->getDoctrine()->getManager();

        /* @var $em EntityManager */
        $type = $em->getRepository('AppBundle:CartType')->find($type_id);
        $product = $em->getRepository('AppBundle:Product')->find($product_id);

        // Check if there is an open cart of the same type
        $cart = $em->getRepository('AppBundle:Cart')->findOneBy(['type' => $type, 'state' => 'NEW']);

        // Else create an open cart for that type
        if (null === $cart) {
            $cart = new Cart();
            $cart->setState('NEW');
            $cart->setType($type);
        }

        // Create new item for the product
        $item = new Item();
        $item->setCart($cart);
        $item->setProduct($product);
        $item->setUnitPrice($product->getPrice());
        $item->setQuantity(1);
        $cart->addItem($item);

        $em->persist($cart);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }

    public function viewByTypeAction(CartType $type)
    {
        /* @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();
        $cart = $em->getRepository('AppBundle:Cart')->findOneBy(['type' => $type, 'state' => 'NEW']);

        return $this->render('cart/show.html.twig', ['cart' => $cart]);
    }

    public function deleteItemAction(Item $item)
    {
        /* @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }

    public function clearAction(Cart $cart)
    {
        /* @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        foreach ($cart->getItems() as $item) {
            $cart->removeItem($item);
        }
        $em->flush();

        return $this->redirectToRoute('homepage');
    }

    public function editItemsAction(Request $request, Cart $cart)
    {
        $form = $this->createForm('AppBundle\Form\CartType', $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $em EntityManager */
            $em = $this->getDoctrine()->getManager();
            $em->persist($cart);
            $em->flush();

            return $this->redirectToRoute('cart_view_by_type', array('id' => $cart->getType()->getId()));
        }

        return $this->render('cart/edit_items.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

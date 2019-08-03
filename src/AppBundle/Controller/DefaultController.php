<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('AppBundle:Product')->findAll();
        $cartTypes = $em->getRepository('AppBundle:CartType')->findAll();

        return $this->render('default/index.html.twig', [
            'products' => $products,
            'cartTypes' => $cartTypes,
        ]);
    }
}

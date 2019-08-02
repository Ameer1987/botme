<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    public function adminIndexAction(Request $request)
    {
        return $this->render('default/admin_index.html.twig');
    }

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('AppBundle:Product')->findAll();

        return $this->render('default/index.html.twig', [
            'products' => $products,
        ]);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CartType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Carttype controller.
 *
 */
class CartTypeController extends Controller
{
    /**
     * Lists all cartType entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cartTypes = $em->getRepository('AppBundle:CartType')->findAll();

        return $this->render('carttype/index.html.twig', array(
            'cartTypes' => $cartTypes,
        ));
    }

    /**
     * Creates a new cartType entity.
     *
     */
    public function newAction(Request $request)
    {
        $cartType = new Carttype();
        $form = $this->createForm('AppBundle\Form\CartTypeType', $cartType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cartType);
            $em->flush();

            return $this->redirectToRoute('admin_carttype_show', array('id' => $cartType->getId()));
        }

        return $this->render('carttype/new.html.twig', array(
            'cartType' => $cartType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cartType entity.
     *
     */
    public function showAction(CartType $cartType)
    {
        $deleteForm = $this->createDeleteForm($cartType);

        return $this->render('carttype/show.html.twig', array(
            'cartType' => $cartType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cartType entity.
     *
     */
    public function editAction(Request $request, CartType $cartType)
    {
        $deleteForm = $this->createDeleteForm($cartType);
        $editForm = $this->createForm('AppBundle\Form\CartTypeType', $cartType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_carttype_edit', array('id' => $cartType->getId()));
        }

        return $this->render('carttype/edit.html.twig', array(
            'cartType' => $cartType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cartType entity.
     *
     */
    public function deleteAction(Request $request, CartType $cartType)
    {
        $form = $this->createDeleteForm($cartType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cartType);
            $em->flush();
        }

        return $this->redirectToRoute('admin_carttype_index');
    }

    /**
     * Creates a form to delete a cartType entity.
     *
     * @param CartType $cartType The cartType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CartType $cartType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_carttype_delete', array('id' => $cartType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

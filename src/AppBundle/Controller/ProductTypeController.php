<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Producttype controller.
 *
 */
class ProductTypeController extends Controller
{
    /**
     * Lists all productType entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $productTypes = $em->getRepository('AppBundle:ProductType')->findAll();

        return $this->render('producttype/index.html.twig', array(
            'productTypes' => $productTypes,
        ));
    }

    /**
     * Creates a new productType entity.
     *
     */
    public function newAction(Request $request)
    {
        $productType = new Producttype();
        $form = $this->createForm('AppBundle\Form\ProductTypeType', $productType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($productType);
            $em->flush();

            return $this->redirectToRoute('admin_producttype_show', array('id' => $productType->getId()));
        }

        return $this->render('producttype/new.html.twig', array(
            'productType' => $productType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a productType entity.
     *
     */
    public function showAction(ProductType $productType)
    {
        $deleteForm = $this->createDeleteForm($productType);

        return $this->render('producttype/show.html.twig', array(
            'productType' => $productType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing productType entity.
     *
     */
    public function editAction(Request $request, ProductType $productType)
    {
        $deleteForm = $this->createDeleteForm($productType);
        $editForm = $this->createForm('AppBundle\Form\ProductTypeType', $productType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_producttype_edit', array('id' => $productType->getId()));
        }

        return $this->render('producttype/edit.html.twig', array(
            'productType' => $productType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a productType entity.
     *
     */
    public function deleteAction(Request $request, ProductType $productType)
    {
        $form = $this->createDeleteForm($productType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($productType);
            $em->flush();
        }

        return $this->redirectToRoute('admin_producttype_index');
    }

    /**
     * Creates a form to delete a productType entity.
     *
     * @param ProductType $productType The productType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProductType $productType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_producttype_delete', array('id' => $productType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

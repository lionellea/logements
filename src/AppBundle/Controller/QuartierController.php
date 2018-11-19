<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Quartier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Quartier controller.
 *
 */
class QuartierController extends Controller
{
    /**
     * Lists all quartier entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $quartiers = $em->getRepository('AppBundle:Quartier')->findAll();

        return $this->render('quartier/index.html.twig', array(
            'quartiers' => $quartiers,
        ));
    }

    /**
     * Creates a new quartier entity.
     *
     */
    public function newAction(Request $request)
    {
        $quartier = new Quartier();
        $form = $this->createForm('AppBundle\Form\QuartierType', $quartier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quartier);
            $em->flush();

            return $this->redirectToRoute('quartier_index', array('id' => $quartier->getId()));
        }

        return $this->render('quartier/new.html.twig', array(
            'quartier' => $quartier,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a quartier entity.
     *
     */
    public function showAction(Quartier $quartier)
    {
        $deleteForm = $this->createDeleteForm($quartier);

        return $this->render('quartier/show.html.twig', array(
            'quartier' => $quartier,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing quartier entity.
     *
     */
    public function editAction(Request $request, Quartier $quartier)
    {
        $deleteForm = $this->createDeleteForm($quartier);
        $editForm = $this->createForm('AppBundle\Form\QuartierType', $quartier);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quartier_edit', array('id' => $quartier->getId()));
        }

        return $this->render('quartier/edit.html.twig', array(
            'quartier' => $quartier,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a quartier entity.
     *
     */
    public function deleteAction(Request $request, Quartier $quartier)
    {
        
            $em = $this->getDoctrine()->getManager();
            $em->remove($quartier);
            $em->flush();
        

        return $this->redirectToRoute('quartier_index');
    }

    /**
     * Creates a form to delete a quartier entity.
     *
     * @param Quartier $quartier The quartier entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Quartier $quartier)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('quartier_delete', array('id' => $quartier->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

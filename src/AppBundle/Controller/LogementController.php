<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Logement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Logement controller.
 *
 */
class LogementController extends Controller
{
    /**
     * Lists all logement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $logements = $em->getRepository('AppBundle:Logement')->findAll();

        return $this->render('logement/index.html.twig', array(
            'logements' => $logements,
        ));
    }

    /**
     * Creates a new logement entity.
     *
     */
    public function newAction(Request $request)
    {
        $logement = new Logement();
        $form = $this->createForm('AppBundle\Form\LogementType', $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($logement);
            $em->flush();

            return $this->redirectToRoute('logement_index', array('id' => $logement->getId()));
        }

        return $this->render('logement/new.html.twig', array(
            'logement' => $logement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a logement entity.
     *
     */
    public function showAction(Logement $logement)
    {
        $deleteForm = $this->createDeleteForm($logement);

        return $this->render('logement/show.html.twig', array(
            'logement' => $logement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing logement entity.
     *
     */
    public function editAction(Request $request, Logement $logement)
    {
        $deleteForm = $this->createDeleteForm($logement);
        $editForm = $this->createForm('AppBundle\Form\LogementType', $logement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('logement_edit', array('id' => $logement->getId()));
        }

        return $this->render('logement/edit.html.twig', array(
            'logement' => $logement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a logement entity.
     *
     */
    public function deleteAction(Request $request, Logement $logement)
    {
        
            $em = $this->getDoctrine()->getManager();
            $em->remove($logement);
            $em->flush();
       

        return $this->redirectToRoute('logement_index');
    }

    /**
     * Creates a form to delete a logement entity.
     *
     * @param Logement $logement The logement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Logement $logement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('logement_delete', array('id' => $logement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

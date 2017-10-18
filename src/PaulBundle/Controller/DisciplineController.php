<?php

namespace PaulBundle\Controller;

use PaulBundle\Entity\Discipline;
use PaulBundle\Form\DisciplineType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DisciplineController extends Controller
{
    /**
     * @Route("/discipline/", name="paul_discipline_index")
     */
    public function indexAction(Request $request)
    {
    	$repository = $this->getDoctrine()->getRepository('PaulBundle:Discipline');

    	$disciplines = $repository->findAll();

        return $this->render('PaulBundle:Discipline:index.html.twig', array(
        	'disciplines' => $disciplines
        ));
    }

    /**
     * @Route("/discipline/add", name="paul_discipline_add")
     */
    public function addAction(Request $request)
    {
    	$discipline = new Discipline();

        $form = $this->createForm(DisciplineType::class, $discipline);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
	        $discipline = $form->getData();

	        $em = $this->getDoctrine()->getManager();
	        $em->persist($discipline);
            $em->flush();

            $this->addFlash('notice', $this->get('translator')->trans('sportAdded'));

	        return $this->redirectToRoute('paul_discipline_index');
	    }

        return $this->render('PaulBundle:Discipline:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/discipline/edit/{disciplineId}", name="paul_discipline_edit")
     */
    public function editAction($disciplineId, Request $request)
    {
    	$repository = $this->getDoctrine()->getRepository('PaulBundle:Discipline');

    	$discipline = $repository->findOneById($disciplineId);

        $form = $this->createForm(DisciplineType::class, $discipline);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
	        $discipline = $form->getData();

	        $em = $this->getDoctrine()->getManager();
	        $em->persist($discipline);
            $em->flush();

            $this->addFlash('notice', $this->get('translator')->trans('sportEdited'));

	        return $this->redirectToRoute('paul_discipline_index');
	    }

        return $this->render('PaulBundle:Discipline:edit.html.twig', array(
        	'form' => $form->createView(), 
        	'discipline' => $discipline)
    	);
    }

    /**
     * @Route("/discipline/delete/{disciplineId}", name="paul_discipline_delete")
     */
    public function deleteAction($disciplineId, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('PaulBundle:Discipline');

        $discipline = $repository->findOneById($disciplineId);

        $em = $this->getDoctrine()->getManager();

        $athletes = $discipline->getAthletes();

        foreach ($athletes as $a) {
            $em->remove($a);
        }

        $em->remove($discipline);
        $em->flush();

        $this->addFlash('notice', $this->get('translator')->trans('sportDeleted'));

        return $this->redirectToRoute('paul_discipline_index');
    }
}

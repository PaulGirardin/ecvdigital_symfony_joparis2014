<?php

namespace PaulBundle\Controller;

use PaulBundle\Entity\Pays;
use PaulBundle\Form\PaysType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PaysController extends Controller
{
    /**
     * @Route("/pays/", name="paul_pays_index")
     */
    public function indexAction(Request $request)
    {
    	$repository = $this->getDoctrine()->getRepository('PaulBundle:Pays');

    	$pays = $repository->findAll();

        return $this->render('PaulBundle:Pays:index.html.twig', array('pays' => $pays));
    }

    /**
     * @Route("/pays/add", name="paul_pays_add")
     */
    public function addAction(Request $request)
    {
    	$pays = new Pays();

        $form = $this->createForm(PaysType::class, $pays);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
	        $pays = $form->getData();
            $file = $pays->getDrapeau();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('pays_drapeau_directory'),
                $fileName
            );

            $pays->setDrapeau($fileName);

	        $em = $this->getDoctrine()->getManager();
	        $em->persist($pays);
            $em->flush();

            $this->addFlash('notice', $this->get('translator')->trans('countryAdded'));

	        return $this->redirectToRoute('paul_pays_index');
	    }

        return $this->render('PaulBundle:Pays:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/pays/edit/{paysId}", name="paul_pays_edit")
     */
    public function editAction($paysId, Request $request)
    {
    	$repository = $this->getDoctrine()->getRepository('PaulBundle:Pays');

    	$pays = $repository->findOneById($paysId);

        $oldFile = $pays->getDrapeau();

        $form = $this->createForm(PaysType::class, $pays);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (file_exists($this->getParameter('pays_drapeau_directory') . '/' . $oldFile)) {
                unlink($this->getParameter('pays_drapeau_directory') . '/' . $oldFile);
            }

	        $pays = $form->getData();
            $file = $pays->getDrapeau();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('pays_drapeau_directory'),
                $fileName
            );

            $pays->setDrapeau($fileName);

	        $em = $this->getDoctrine()->getManager();
	        $em->persist($pays);
            $em->flush();

            $this->addFlash('notice', $this->get('translator')->trans('countryEdited'));

	        return $this->redirectToRoute('paul_pays_index');
	    }

        return $this->render('PaulBundle:Pays:edit.html.twig', 
            array(
            	'form' => $form->createView(), 
            	'pays' => $pays
            )
    	);
    }

    /**
     * @Route("/pays/delete/{paysId}", name="paul_pays_delete")
     */
    public function deleteAction($paysId, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('PaulBundle:Pays');

        $pays = $repository->findOneById($paysId);

        $flag = $pays->getDrapeau();
        if (file_exists($this->getParameter('pays_drapeau_directory') . '/' . $flag)) {
            unlink($this->getParameter('pays_drapeau_directory') . '/' . $flag);
        }

        $em = $this->getDoctrine()->getManager();

        $athletes = $pays->getAthletes();

        foreach ($athletes as $a) {
            $em->remove($a);
        }

        $em->remove($pays);
        $em->flush();

        $this->addFlash('notice', $this->get('translator')->trans('countryDeleted'));

        return $this->redirectToRoute('paul_pays_index');
    }
}

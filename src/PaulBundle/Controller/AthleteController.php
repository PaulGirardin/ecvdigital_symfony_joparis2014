<?php

namespace PaulBundle\Controller;

use PaulBundle\Entity\Athlete;
use PaulBundle\Entity\Discipline;
use PaulBundle\Entity\Pays;
use PaulBundle\Form\AthleteType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AthleteController extends Controller
{
    /**
     * @Route("/athlete/", name="paul_athlete_index")
     */
    public function indexAction(Request $request)
    {
    	$repository = $this->getDoctrine()->getRepository('PaulBundle:Athlete');

    	$athletes = $repository->findAll();

        return $this->render('PaulBundle:Athlete:index.html.twig', 
            array(
                'athletes' => $athletes
            )
        );
    }

    /**
     * @Route("/athlete/add", name="paul_athlete_add")
     */
    public function addAction(Request $request)
    {
    	$athlete = new Athlete();

        $form = $this->createForm(AthleteType::class, $athlete);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
	        $athlete = $form->getData();
            $file = $athlete->getPhoto();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('athlete_photos_directory'),
                $fileName
            );

            $athlete->setPhoto($fileName);

	        $em = $this->getDoctrine()->getManager();
	        $em->persist($athlete);
            $em->flush();

            $this->addFlash('notice', $this->get('translator')->trans('athleteAdded'));

	        return $this->redirectToRoute('paul_athlete_index');
	    }

        return $this->render('PaulBundle:Athlete:add.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * @Route("/athlete/edit/{athleteId}", name="paul_athlete_edit")
     */
    public function editAction($athleteId, Request $request)
    {
    	$repository = $this->getDoctrine()->getRepository('PaulBundle:Athlete');

    	$athlete = $repository->findOneById($athleteId);

        $oldFile = $athlete->getPhoto();

        $form = $this->createForm(AthleteType::class, $athlete);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (file_exists($this->getParameter('athlete_photos_directory') . '/' . $oldFile)) {
                unlink($this->getParameter('athlete_photos_directory') . '/' . $oldFile);
            }

            $athlete = $form->getData();
            $file = $athlete->getPhoto();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('athlete_photos_directory'),
                $fileName
            );

            $athlete->setPhoto($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($athlete);
            $em->flush();

            $this->addFlash('notice', $this->get('translator')->trans('athleteEdited'));

            return $this->redirectToRoute('paul_athlete_index');
        }

        return $this->render('PaulBundle:Athlete:edit.html.twig', 
            array(
            	'form' => $form->createView(), 
            	'athlete' => $athlete
            )
    	);
    }

    /**
     * @Route("/athlete/delete/{athleteId}", name="paul_athlete_delete")
     */
    public function deleteAction($athleteId, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('PaulBundle:Athlete');

        $athlete = $repository->findOneById($athleteId);

        $photo = $athlete->getPhoto();
        if (file_exists($this->getParameter('athlete_photos_directory') . '/' . $photo)) {
            unlink($this->getParameter('athlete_photos_directory') . '/' . $photo);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($athlete);
        $em->flush();

        $this->addFlash('notice', $this->get('translator')->trans('athleteDeleted'));

        return $this->redirectToRoute('paul_athlete_index');
    }
}

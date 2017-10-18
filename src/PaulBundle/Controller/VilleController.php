<?php

namespace PaulBundle\Controller;

use PaulBundle\Entity\Ville;
use PaulBundle\Form\VilleType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class VilleController extends Controller
{
    /**
     * @Route("/ville/", name="paul_ville_index")
     */
    public function indexAction(Request $request)
    {
    	$repository = $this->getDoctrine()->getRepository('PaulBundle:Ville');

    	$villes = $repository->findAll();

        return $this->render('PaulBundle:Ville:index.html.twig', array(
            	'villes' => $villes
            )
        );
    }

    /**
     * @Route("/ville/add", name="paul_ville_add")
     */
    public function addAction(Request $request)
    {
    	$ville = new Ville();

        if ($request->isXmlHttpRequest()) {
            $form = $request->get('ville');
            $translator = $this->get('translator');
            $msg = [];
            $type = 201;

            if (empty($form['nom'])) {
                $msg = array('type' => 'error', 'msg' => $translator->trans('cityAddFail'));
                $type = 500;
            } else {
                $ville->setNom($form['nom']);

                $em = $this->getDoctrine()->getManager();
                $em->persist($ville);
                $em->flush();

                $msg = array('type' => 'success', 'msg' => $translator->trans('cityAdded'));
            }

            return new JsonResponse($msg, $type);
        }

        $form = $this->createForm(VilleType::class, $ville);

        return $this->render('PaulBundle:Ville:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/ville/edit/{villeId}", defaults={"villeId" = 0}, name="paul_ville_edit")
     */
    public function editAction($villeId, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $form = $request->get('ville');
            $translator = $this->get('translator');
            $repository = $this->getDoctrine()->getRepository('PaulBundle:Ville');
            $msg = [];
            $type = 200;

            if (empty($form['nom'])) {
                $msg = array('type' => 'error', 'msg' => $translator->trans('cityEditFail'));
                $type = 500;
            } else {
                $ville = $repository->findOneById($villeId);
                $ville->setNom($form['nom']);

                $em = $this->getDoctrine()->getManager();
                $em->persist($ville);
                $em->flush();

                $msg = array('type' => 'success', 'msg' => $translator->trans('cityEdited'));
            }

            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);

            $return = [
                'message' => $msg, 
                'villes' => json_decode($serializer->serialize($repository->findAll(), 'json'))
            ];

            return new JsonResponse($return, $type);
        }

        return $this->redirectToRoute('paul_ville_index');
    }

    /**
     * @Route("/ville/delete/{villeId}", defaults={"villeId" = 0}, name="paul_ville_delete")
     */
    public function deleteAction($villeId, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $msg = [];
            $translator = $this->get('translator');
            $repository = $this->getDoctrine()->getRepository('PaulBundle:Ville');
            $type = 200;

            if (empty($villeId)) {
                $msg = array('type' => 'error', 'msg' => $translator->trans('cityDeleteFail'));
                $type = 500;
            } else {
                $ville = $repository->findOneById($villeId);

                $em = $this->getDoctrine()->getManager();
                $em->remove($ville);
                $em->flush();

                $msg = array('type' => 'success', 'msg' => $translator->trans('cityDeleted'));
            }

            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);

            $return = [
                'message' => $msg, 
                'villes' => json_decode($serializer->serialize($repository->findAll(), 'json'))
            ];

            return new JsonResponse($return, $type);
        }

        return $this->redirectToRoute('paul_ville_index');
    }
}

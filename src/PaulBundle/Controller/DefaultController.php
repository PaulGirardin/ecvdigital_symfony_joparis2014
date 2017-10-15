<?php

namespace PaulBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="paul_default_index")
     */
    public function indexAction(Request $request)
    {
        return $this->render('PaulBundle:Default:index.html.twig');
    }
}

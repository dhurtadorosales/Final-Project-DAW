<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SocioController extends Controller
{
    /**
     * @Route("/socios/listar", name="socios_listar")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $socios = $em->getRepository('AppBundle\Repository\SocioRepository');

        return $this->render('socio/listar.html.twig', [
            'socios' => $socios
        ]);
    }
}

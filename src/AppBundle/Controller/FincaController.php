<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FincaController extends Controller
{
    /**
     * @Route("/fincas/listar", name="fincas_listar")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $fincas = $em->createQueryBuilder()
            ->select('f')
            ->from('AppBundle:Finca', 'f')
            ->getQuery()
            ->getResult();

        return $this->render('finca/listar.html.twig', [
            'fincas' => $fincas
        ]);
    }
}

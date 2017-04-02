<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Socio;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoteController extends Controller
{
    /**
     * @Route("/lotes/listar", name="lotes_listar")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $lotes = $em->createQueryBuilder()
            ->select('l')
            ->from('AppBundle:Lote', 'l')
            ->getQuery()
            ->getResult();

        return $this->render('lote/listar.html.twig', [
            'lotes' => $lotes
        ]);
    }
}

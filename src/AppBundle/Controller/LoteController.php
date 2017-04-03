<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lote;
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

    /**
     * @Route("/lotes/listar/{lote}", name="lotes_listar_lote")
     */
    public function listarFincasAction(Lote $lote)
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $resultados = $em->createQueryBuilder()
            ->select('l')
            ->from('AppBundle:Lote', 'l')
            ->where('l.id = :lot')
            ->setParameter('lot', $lote)
            ->getQuery()
            ->getResult();

        return $this->render('lote/detalle.html.twig', [
            'resultados' => $resultados
        ]);
    }
}

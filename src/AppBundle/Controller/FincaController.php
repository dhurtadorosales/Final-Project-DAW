<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lote;
use AppBundle\Entity\Socio;
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

    /**
     * @Route("/fincas/listar/{lote}", name="fincas_listar_lote")
     */
    public function Action(Lote $lote)
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $fincas = $em->createQueryBuilder()
            ->select('f')
            ->addSelect('e')
            ->addSelect('a')
            ->addSelect('d')
            ->addSelect('l')
            ->from('AppBundle:Finca', 'f')
            ->join('f.entregas', 'e')
            ->join('e.amasada', 'a')
            ->join('a.deposito', 'd')
            ->join('d.lotes', 'l')
            ->where('l = :lot')
            ->setParameter('lot', $lote)
            ->getQuery()
            ->getResult();

        return $this->render('finca/listar.html.twig', [
            'fincas' => $fincas
        ]);
    }
}

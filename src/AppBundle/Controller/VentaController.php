<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Socio;
use AppBundle\Entity\Venta;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VentaController extends Controller
{
    /**
     * @Route("/ventas/listar", name="ventas_listar")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $ventas = $em->createQueryBuilder()
            ->select('v')
            ->from('AppBundle:Venta', 'v')
            ->getQuery()
            ->getResult();

        return $this->render('venta/listar.html.twig', [
            'ventas' => $ventas
        ]);
    }
}

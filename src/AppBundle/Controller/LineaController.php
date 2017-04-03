<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Socio;
use AppBundle\Entity\Venta;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LineaController extends Controller
{
    /**
     * @Route("/ventas/detalle/{venta}", name="ventas_detalle")
     */
    public function detalleAction(Venta $venta)
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $lineas = $em->createQueryBuilder()
            ->select('l')
            ->from('AppBundle:Linea', 'l')
            ->where('l.venta = :venta')
            ->setParameter('venta', $venta)
            ->getQuery()
            ->getResult();

        return $this->render('venta/detalle.html.twig', [
            'lineas' => $lineas
        ]);
    }
}

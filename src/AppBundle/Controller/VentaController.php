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

    /**
     * @Route("/ventas/insertar", name="ventas_insertar")
     */
    public function insertarAction()
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $lotes = $em->createQueryBuilder()
            ->select('l')
            ->from('AppBundle:Lote', 'l')
            ->getQuery()
            ->getResult();

        $ventas = [
            [0, "2017-04-28", 0, $lotes[0]],
            [0, "2017-04-28", 0, $lotes[1]],
            [0, "2017-04-28", 0, $lotes[1]]
        ];

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        foreach ($ventas as $item) {
            $venta = new Venta();
            $em->persist($venta);
            $venta
                ->setFecha(new \DateTime($item[1]))
                ->setCantidad($item[2])
                ->setLote($item[3]);

            $em->flush();
        }
        $mensaje = 'Ventas insertadas correctamente';

        return $this->render('venta/operaciones.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}

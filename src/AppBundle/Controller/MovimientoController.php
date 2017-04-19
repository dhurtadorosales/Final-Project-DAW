<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Liquidacion;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Movimiento;
use AppBundle\Entity\Temporada;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class MovimientoController extends Controller
{
    /**
     * @Route("/movimientos/listar/temporada/{temporada}", name="movimientos_listar_temporada")
     */
    public function listarMovimientosTemporadaAction(Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención movimientos
        $movimientos = $em->getRepository('AppBundle:Movimiento')
            ->getMovimientosTemporada($temporada);

        //Obtención de ventas
        $ventas = $em->getRepository('AppBundle:Venta')
            ->getVentasTemporada($temporada);

        $sumaVentas = 0;
        foreach ($ventas as $venta) {
            $sumaVenta = $venta->getSuma();
            $descuento = $sumaVenta * $venta->getDescuento();
            $baseImponible = $sumaVenta - $descuento;
            $sumaIva = $baseImponible * $venta->getIva();
            $totalVenta = $baseImponible + $sumaIva;
            $sumaVentas = $sumaVentas + $totalVenta;
        }

        return $this->render('movimiento/listar.html.twig', [
            'movimientos' => $movimientos,
            'temporada' => $temporada,
            'sumaVentas' => $sumaVentas
        ]);
    }


    /**
     * @Route("/movimientos/insertar", name="movimientos_insertar")
     */
    public function insertarLiquidacionAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtenemos la temporada vigente
        $temporadas = $resultados = $em->getRepository('AppBundle:Temporada')
            ->findAll();
        $temporada = $temporadas[sizeof($temporadas) - 1];

        //Creación de un nuevo movimiento
        $movimiento = new Movimiento();
        $movimiento2 = new Movimiento();
        $em->persist($movimiento);
        $em->persist($movimiento2);

        //Obtencion de la fecha actual
        $fecha = new \DateTime('now');

        $movimiento
            ->setConcepto("Paga nóminas enero")
            ->setCantidad(-25000)
            ->setFecha($fecha)
            ->setTemporada($temporada);

        $movimiento2
            ->setConcepto("Venta maquinaria antigua")
            ->setCantidad(60000)
            ->setFecha($fecha)
            ->setTemporada($temporada);

        $em->flush();

        $mensaje = 'Movimiento insertado correctamente';


        return $this->render('movimiento/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}

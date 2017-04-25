<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Movimiento;
use AppBundle\Entity\Temporada;
use AppBundle\Service\TemporadaActual;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MovimientoController extends Controller
{
    /**
     * @Route("/movimientos/listar", name="movimientos_listar")
     * @Route("/movimientos/listar/temporada/{temporada}", name="movimientos_listar_temporada")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_SOCIO')")
     */
    public function listarMovimientosTemporadaAction(Temporada $temporada = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Si no recibe ninguna temporada se obtendrá la actual
        if (null === $temporada) {
            //Creamos una instancia del servicio
            $temporadaActual = new TemporadaActual($em);
            $temporada = $temporadaActual->temporadaActualAction();
        }

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
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
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

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Movimiento;
use AppBundle\Entity\Temporada;
use AppBundle\Form\Type\MovimientoType;
use AppBundle\Service\TemporadaActual;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MovimientoController extends Controller
{
    /**
     * @Route("/movimientos/listar", name="movimientos_listar")
     * @Route("/movimientos/listar/temporada/{temporada}", name="movimientos_listar_temporada")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_SOCIO')")
     */
    public function listarMovimientosTemporadaAction(Request $request, Temporada $temporada = null)
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

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $movimientos,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('movimiento/virgen_extra.html.twig', [
            'movimientos' => $movimientos,
            'temporada' => $temporada,
            'sumaVentas' => $sumaVentas,
            'pagination' => $pagination
        ]);
    }


    /**
     * @Route("/movimientos/insertar", name="movimientos_insertar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function insertarMovimientoAction()
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

    /**
     * @Route("/movimientos/nuevo", name="movimientos_nuevo")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function formMovimientoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //Obtenemos la temporada vigente
        $temporadaActual = new TemporadaActual($em);
        $temporada = $temporadaActual->temporadaActualAction();

        //Obtenemos la fecha actual
        $fecha = new \DateTime('now');

        //Creación de un nuevo movimiento
        $movimiento = new Movimiento();
        $em->persist($movimiento);
        $movimiento->setTemporada($temporada);
        $movimiento->setFecha($fecha);

        $form = $this->createForm(MovimientoType::class, $movimiento, [
            'fecha' => $fecha,
            'temporada' => $temporada,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $concepto = $form['concepto']->getData();
                $tipo = $form['tipo']->getData();
                $cantidad = $form['cantidad']->getData();

                //Concepto se pasa a mayúscula
                $concepto = strtoupper($concepto);
                $movimiento->setConcepto($concepto);

                //La cantidad es negativa si es un pago
                if ($tipo == 'pago') {
                    $cantidad = 0 - $cantidad;
                    $movimiento->setCantidad($cantidad);
                }
                $em->flush();
                $this->addFlash('estado', 'Movimiento creado con éxito');
                return $this->redirectToRoute('movimientos_listar');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido crear el movimiento');
            }
        }

        return $this->render('movimiento/form.html.twig', [
            'movimiento' => $movimiento,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/movimientos/temporadas/listar", name="movimientos_temporadas_listar")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or is_granted('ROLE_SOCIO')")
     */
    public function listarTemporadasAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $temporadas = $em->getRepository('AppBundle:Temporada')
            ->getTemporadas();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $temporadas,
            $request->query->getInt('page', 1), 10
        );

        return $this->render('movimiento/principal.html.twig', [
            'temporadas' => $temporadas,
            'pagination' => $pagination
        ]);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cliente;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Temporada;
use AppBundle\Entity\Venta;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VentaController extends Controller
{
    /**
     * @Route("/ventas/listar/temporada/{temporada}", name="ventas_listar_temporada")
     */
    public function listarTemporadaAction(Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $ventas = $em->getRepository('AppBundle:Venta')
            ->getVentasTemporada($temporada);

        return $this->render('venta/listar.html.twig', [
            'ventas' => $ventas,
            'temporada' => $temporada
        ]);
    }

    /**
     * @Route("/ventas/detalle/{venta}", name="ventas_detalle")
     */
    public function detalleAction(Venta $venta)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención de la venta
        $ventas = $em->getRepository('AppBundle:Venta')
            ->getVenta($venta);

        //Obtención de las líneas de la venta
        $lineas = $em->getRepository('AppBundle:Linea')
            ->getLineasVenta($venta);

        if ($ventas[0]->getSocio() != null) {
            $persona = $ventas[0]->getSocio();
        }
        else {
            $persona = $ventas[0]->getCliente();
        }

        return $this->render('venta/detalle.html.twig', [
            'ventas' => $ventas,
            'lineas' => $lineas,
            'persona' => $persona
        ]);
    }

    /**
     * @Route("/ventas/listar/socio/temporada/{socio}/{temporada}", name="ventas_listar_socio_temporada")
     */
    public function listarTemporadaSocioAction(Temporada $temporada, Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $ventas = $em->getRepository('AppBundle:Venta')
            ->getVentasSocioTemporada($socio, $temporada);

        return $this->render('venta/listar.html.twig', [
            'ventas' => $ventas,
            'temporada' => $temporada
        ]);
    }

    /**
     * @Route("/ventas/listar/cliente/{cliente}", name="ventas_listar_cliente")
     */
    public function listarClienteAction(Cliente $cliente)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $ventas = $em->getRepository('AppBundle:Venta')
            ->getVentasCliente($cliente);

        return $this->render('venta/listar.html.twig', [
            'ventas' => $ventas,
            'temporada' => null
        ]);
    }

    /**
     * @Route("/ventas/insertar/cliente/{cliente}", name="ventas_insertar_cliente")
     */
    public function insertarClienteAction(Cliente $cliente)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtenemos los porcentajes
        $porcentajes = $em->getRepository('AppBundle:Porcentaje')
            ->findAll();
        $iva = $porcentajes[0]->getCantidad();

        //Obtenemos el número de ventas de este año
        $fecha = new \DateTime('now');
        $anio = $fecha->format('Y');
        $numero = $em->getRepository('AppBundle:Porcentaje')
            ->getVentasAnio($anio);
        $numero ++;

        //Creación de nueva venta
        $venta = new Venta();

        $em->persist($venta);
        $venta
            ->setNumero($numero)
            ->setFecha(new \DateTime('now'))
            ->setSuma(0)
            ->setIva($iva)
            ->setCliente($cliente)
            ->setDescuento($cliente->getDescuento());

        $em->flush();

        $mensaje = 'Venta insertada correctamente';

        return $this->render('venta/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }

    /**
     * @Route("/ventas/insertar/socio/{socio}", name="ventas_insertar_socio")
     */
    public function insertarSocioAction(Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtenemos la temporada vigente
        $temporadas = $resultados = $em->getRepository('AppBundle:Temporada')
            ->findAll();
        $temporada = $temporadas[sizeof($temporadas) - 1];

        //Obtenemos los porcentajes
        $porcentajes = $em->getRepository('AppBundle:Porcentaje')
            ->findAll();
        $ivaReducido = $porcentajes[1]->getCantidad();

        //Obtenemos el número de ventas de este año
        $fecha = new \DateTime('now');
        $anio = $fecha->format('Y');
        $numero = $em->getRepository('AppBundle:Porcentaje')
            ->getVentasAnio($anio);
        $numero ++;

        //Creación de nueva venta
        $venta = new Venta();

        $em->persist($venta);
        $venta
            ->setNumero($numero)
            ->setFecha(new \DateTime('now'))
            ->setSuma(0)
            ->setIva($ivaReducido)
            ->setSocio($socio)
            ->setTemporada($temporada)
            ->setDescuento($socio->getDescuento());

        $em->flush();

        $mensaje = 'Venta insertada correctamente';

        return $this->render('venta/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}

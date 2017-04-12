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

        return $this->render('venta/listarTemporada.html.twig', [
            'ventas' => $ventas,
            'temporada' => $temporada
        ]);
    }

    /**
     * @Route("/ventas/listar/temporada/socio/{temporada}/{socio}", name="ventas_listar_temporada_socio")
     */
    public function listarTemporadaSocioAction(Temporada $temporada, Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $ventas = $em->getRepository('AppBundle:Venta')
            ->getVentasTemporadaSocio($temporada, $socio);

        return $this->render('venta/listarSocioTemporada.html.twig', [
            'ventas' => $ventas,
            'socio' => $socio,
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

        return $this->render('venta/listarCliente.html.twig', [
            'ventas' => $ventas,
            'cliente' => $cliente
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

        //Creación de nueva venta
        $venta = new Venta();

        $em->persist($venta);
        $venta
            ->setFecha(new \DateTime('now'))
            ->setBaseImponible(0)
            ->setIva($iva)
            ->setCliente($cliente);

        $em->flush();

        $mensaje = 'Venta insertada correctamente';

        return $this->render('venta/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }

    /**
     * @Route("/ventas/insertar/socio/{socio}{temporada}", name="ventas_insertar_socio")
     */
    public function insertarSocioAction(Socio $socio, Temporada $temporada)
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
        $iva = $porcentajes[0]->getCantidad();

        //Creación de nueva venta
        $venta = new Venta();

        $em->persist($venta);
        $venta
            ->setFecha(new \DateTime('now'))
            ->setBaseImponible(0)
            ->setIva($iva)
            ->setSocio($socio)
            ->setTemporada($temporada);

        $em->flush();

        $mensaje = 'Venta insertada correctamente';

        return $this->render('venta/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cliente;
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
    public function listarAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $ventas = $em->getRepository('AppBundle:Venta')
            ->findAll();

        return $this->render('venta/listar.html.twig', [
            'ventas' => $ventas
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
     * @Route("/ventas/insertar/socio/{socio}", name="ventas_insertar_socio")
     */
    public function insertarSocioAction(Socio $socio)
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
            ->setSocio($socio);

        $em->flush();

        $mensaje = 'Venta insertada correctamente';

        return $this->render('venta/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}

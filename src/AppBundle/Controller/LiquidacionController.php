<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Linea;
use AppBundle\Entity\Liquidacion;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Porcentaje;
use AppBundle\Entity\Producto;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Venta;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Tests\Compiler\Lille;
use Symfony\Component\HttpFoundation\Request;

class LiquidacionController extends Controller
{
    /**
     * @Route("/liquidaciones/detalle/{socio}{temporada}", name="liquidaciones_detalle")
     */
    public function detalleAction(Socio $socio, $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $liquidacion = $em->getRepository('AppBundle:Linea')
            ->getLiquidacionDetalle($socio, $temporada);

        return $this->render('venta/detalle.html.twig', [
            'liquidacion' => $liquidacion,
            'socio' => $socio,
            'temporada' => $temporada
        ]);
    }

    /**
     * @Route("/liquidaciones/insertar/{socio}/{temporada}", name="liquidaciones_insertar")
     */
    public function insertarLiquidacionAction(Venta $venta, $cantidad, Producto $producto)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención de todos los socios
        $socios = $em->getRepository('AppBundle:Socio')
            ->findAll();

        //Obtención de los porcentajes vigentes


        //Creación de la liquidación de cada socio
        foreach ($socios as $item) {
            $liquidacion = new  Liquidacion();
            $liquidacion
                ->setFecha()
                ->setBeneficio()
                ->setGasto()
                ->setIva()
                ->setIvaReducido()
                ->setRetencion()
                ->setIndiceCorrector();
        }

        $linea = new Linea();
        $em->persist($linea);
        $linea
            ->setVenta($venta)
            ->setCantidad($cantidad)
            ->setPrecio($precio)
            ->setProducto($producto);

        //Añadimos la cantidad a la base imponible de la venta
        $base = $venta->getBaseImponible();
        $em->persist($venta);
        $venta->setBaseImponible($base + ($cantidad * $precio));

        //Quitamos cantidad al producto
        $em->persist($producto);
        $producto
            ->setStock($producto->getStock() - $cantidad);

        $em->flush();

        $mensaje = 'Linea insertada correctamente';

        return $this->render('venta/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }

    /**
     * @Route("/2lineas/insertar/lote/{venta}/{cantidad}/{lote}", name="lineas_insertar_lote")
     */
    public function insertarLineaClienteAction(Venta $venta, $cantidad, Lote $lote)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención del precio del lote
        $precio = $lote->getAceite()->getPrecioKg() * $lote->getAceite()->getDensidadKgLitro();

        //Creación de línea
        $linea = new Linea();
        $em->persist($linea);
        $linea
            ->setVenta($venta)
            ->setCantidad($cantidad)
            ->setPrecio($precio)
            ->setLote($lote);

        //Añadimos la cantidad a la base imponible de la venta
        $base = $venta->getBaseImponible();
        $venta->setBaseImponible($base + ($cantidad * $precio));

        //Quitamos cantidad al lote
        $em->persist($lote);
        $lote
            ->setStock($lote->getStock() - $cantidad);

        $em->flush();

        $mensaje = 'Linea insertada correctamente';

        return $this->render('venta/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}

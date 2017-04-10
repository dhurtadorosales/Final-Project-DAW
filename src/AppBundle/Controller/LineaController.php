<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Linea;
use AppBundle\Entity\Porcentaje;
use AppBundle\Entity\Producto;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Venta;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Tests\Compiler\Lille;
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
            'lineas' => $lineas,
            'venta' => $venta
        ]);
    }

    /**
     * @Route("/lineas/insertar/producto/{venta}/{cantidad}/{producto}/{porcentaje}", name="lineas_insertar_producto")
     */
    public function insertarProductoAction(Venta $venta, $cantidad, Producto $producto, Porcentaje $porcentaje)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Creación de línea
        $linea = new Linea();
        $em->persist($linea);
        $linea
            ->setVenta($venta)
            ->setCantidad($cantidad)
            ->setProducto($producto)
            ->setPorcentaje($porcentaje);

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
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Aceite;
use AppBundle\Entity\Envase;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Partida;
use AppBundle\Entity\Producto;
use AppBundle\Entity\Socio;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductoController extends Controller
{
    /**
     * @Route("/productos/listar", name="productos_listar")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $productos = $em->getRepository('AppBundle:Producto')
            ->findAll();

        return $this->render('producto/listar.html.twig', [
            'productos' => $productos
        ]);
    }

    /**
     * @Route("/productos/envasar/{lote}/{producto}/{cantidad}", name="productos_envasar")
     */
    public function productosEnvasadosAction(Lote $lote, Producto $producto, $cantidad)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtenemos el lote
        $lote = $em->getRepository('AppBundle:Lote')
            ->find($lote);

        //Añadimos cantidad al producto
        $stock = $producto->getStock() + $cantidad;
        $em->persist($producto);
        $producto
            ->setStock($stock);

        //Restamos la cantidad del stock del lote del que procede
        $stock = $lote->getStock() - $cantidad;
        $em->persist($lote);
        $lote
            ->setStock($stock);

        $em->flush();

        $mensaje = 'Producto envasado correctamente';

        return $this->render('producto/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }

    /**
     * @Route("/productos/asignar/precio/", name="productos_envasar")
     */
    public function productosPrecioAction()
    {

    }
}

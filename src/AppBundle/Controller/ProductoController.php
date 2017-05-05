<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Aceite;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Producto;
use AppBundle\Form\Model\ListaProductos;
use AppBundle\Form\Type\ListaProductosType;
use AppBundle\Form\Type\Producto2Type;
use AppBundle\Service\TemporadaActual;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductoController extends Controller
{
    /**
     * @Route("/productos/listar", name="productos_listar")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or is_granted('ROLE_EMPLEADO')")
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
     * @Route("/productos/principal", name="productos_principal")
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function productosPrincipalAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtenemos los productos
        $productos = $em->getRepository('AppBundle:Producto')
            ->findAll();

        return $this->render('producto/principal.html.twig', [
            'productos' => $productos
        ]);
    }

    /*
     * @Route("/productos/envasar/{lote}/{producto}/{cantidad}", name="productos_envasar")
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
   /* public function productosEnvasadosAction(Lote $lote, Producto $producto, $cantidad)
    {
        /** @var EntityManager $em */
       /* $em = $this->getDoctrine()->getManager();

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
    }*/

    /**
     * @Route("/productos/aceite", name="productos_aceite")
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function productoAceiteAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtenemos las calidades de aceite
        $aceites = $em->getRepository('AppBundle:Aceite')
            ->findAll();

        return $this->render('producto/formAceite.html.twig', [
            'aceites' => $aceites
        ]);
    }

    /**
     * @Route("/modificar/producto", name="modificar_producto")
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function modificarProductoAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención temporada actual
        $temporadaActual = new TemporadaActual($em);
        $temporada = $temporadaActual->temporadaActualAction();

        //Creación de un objeto de la clase ListaLotes
        $lista = new ListaProductos();

        //Obtenemos todos los productos
        $productos = $em->getRepository('AppBundle:Producto')
            ->findAll();

        //Añadimos los productos a la lista de productos
        foreach ($productos as $producto) {
            $lista->getProductos()->add($producto);
        }

        //Ejecución de formulario
        $form = $this->createForm(ListaProductosType::class, $lista, [
            'temporada' => $temporada
        ]);
        $form->handleRequest($request);

        //Si es válido
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('principal');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }

        return $this->render('producto/form.html.twig', [
            'lista' => $lista,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/producto/form/{producto}", name="producto_form")
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function formProductoAction(Request $request, Producto $producto)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención temporada actual
        $temporadaActual = new TemporadaActual($em);
        $temporada = $temporadaActual->temporadaActualAction();

        //Obtenemos el aceite del producto
        $aceite = $producto->getLotes()[0]->getAceite();

        //Obtención cantidad del producto
        $cantidadProducto = $producto->getStock();
        ///pasar lista de lotes
        ////////////////////////////
        $form = $this->createForm(Producto2Type::class, $producto, [
            'temporada' => $temporada,
            'aceite' => $aceite
        ]);
        $form->handleRequest($request);

        //Si es válido
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                //Obtención de la cantidad que se ha envasado
                $cantidadEnvasar = $form['stock']->getData();

                //Obtención del lote del que procede
                $lote = $form['lotes']->getData();


                //Suma cantidad al producto
                $em->persist($producto);
                $producto
                     ->setStock($cantidadProducto + $cantidadEnvasar);

                //Restamos la cantidad del stock del lote del que procede
                $em->persist($lote);
                $lote
                    ->setStock($lote->getStock() - $cantidadEnvasar);

                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('principal');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }

        return $this->render('producto/form.html.twig', [
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/productos/confirmar/{lote}/{producto}/{cantidad}", name="productos_confirmar")
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function productoConfirmarAction(Lote $lote, Producto $producto, $cantidad)
    {
        return $this->render('producto/confirma.html.twig', [
            'lote' => $lote,
            'producto' => $producto,
            'cantidad' => $cantidad
        ]);
    }
}

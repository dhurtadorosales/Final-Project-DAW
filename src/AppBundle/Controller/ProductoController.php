<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lote;
use AppBundle\Entity\Producto;
use AppBundle\Form\Type\ProductoNuevoType;
use AppBundle\Form\Type\ProductoPrecioType;
use AppBundle\Form\Type\ProductoType;
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
    public function productosPrincipalAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtenemos los productos
        $productos = $em->getRepository('AppBundle:Producto')
            ->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $productos,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('producto/principal.html.twig', [
            'productos' => $productos,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/producto/nuevo", name="producto_nuevo")
     * @Security("is_granted('ROLE_COMERCIAL')")
     */
    public function formProductoNuevoAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Nuevo producto
        $producto = new Producto();
        $em->persist($producto);

        //stock a 0
        $producto->setStock(0);

        //Obtenemos la temporada auxiliar
        $temporadas = $em->getRepository('AppBundle:Temporada')
            ->getTemporadaAuxiliar();

        $form = $this->createForm(ProductoNuevoType::class, $producto, [
            'temporada' => $temporadas[0]
        ]);
        $form->handleRequest($request);

        //Si es válido
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $loteAuxiliar = $form['lotes']->getData();

                //Asignamos al producto nuevo el lote auxiliar obtenido
                $producto->addLote($loteAuxiliar[0]);

                $em->flush();
                $this->addFlash('estado', 'Producto guardado con éxito');
                return $this->redirectToRoute('productos_listar');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se ha podido guardar el producto');
            }
        }

        return $this->render('producto/formNuevo.html.twig', [
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/productos/form/{producto}", name="productos_form")
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

        $form = $this->createForm(ProductoType::class, $producto, [
            'temporada' => $temporada,
            'aceite' => $aceite
        ]);
        $form->handleRequest($request);

        //Si es válido
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                //Obtención de la cantidad en peso que se va a envasar
                $pesoEnvasar = $form['stock']->getData();

                //Obtención del lote del que procede
                $lote = $form['lotes']->getData();

                //Obtención stock de ese lote
                $lote->getStock();

                //Si la cantidad a envasar no es superior a las existencias del lote
                if ($pesoEnvasar <= $lote->getStock()) {
                    //Pasamos ese peso a unidades de producto
                    $cantidadEnvasar = (int)(($pesoEnvasar * $producto->getLotes()[0]->getAceite()->getDensidadKgLitro()) / ($producto->getEnvase()->getCapacidadLitros()));

                    //Suma cantidad al producto
                    $em->persist($producto);
                    $producto
                        ->setStock($cantidadProducto + $cantidadEnvasar);

                    //Restamos la cantidad del stock del lote del que procede
                    $em->persist($lote);
                    $lote
                        ->setStock($lote->getStock() - $pesoEnvasar);

                    $em->flush();
                    $this->addFlash('estado', 'Cambios guardados con éxito');
                    return $this->redirectToRoute('productos_principal');
                }
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
     * @Route("/productos/precio/modificar/{producto}", name="productos_precio_modificar")
     * @Security("is_granted('ROLE_COMERCIAL')")
     */
    public function precioProductoAction(Request $request, Producto $producto)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ProductoPrecioType::class, $producto);
        $form->handleRequest($request);

        //Si es válido
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('productos_listar');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }

        return $this->render('producto/formPrecio.html.twig', [
            'formulario' => $form->createView()
        ]);
    }
}

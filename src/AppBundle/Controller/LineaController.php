<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Linea;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Porcentaje;
use AppBundle\Entity\Producto;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Venta;
use AppBundle\Form\Type\LineaType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Tests\Compiler\Lille;
use Symfony\Component\HttpFoundation\Request;

class LineaController extends Controller
{

    /**
     * @Route("/lineas/insertar/producto/{venta}/{cantidad}/{producto}", name="lineas_insertar_producto")
     */
    public function insertarLineaSocioAction(Venta $venta, $cantidad, Producto $producto)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención del precio del producto
        $precio = $producto->getPrecio();

        //Creación de línea
        $linea = new Linea();
        $em->persist($linea);
        $linea
            ->setVenta($venta)
            ->setCantidad($cantidad)
            ->setPrecio($precio)
            ->setProducto($producto);

        //Añadimos la cantidad a la base imponible de la venta
        $suma = $venta->getSuma();
        $venta->setSuma($suma + ($cantidad * $precio));

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
     * @Route("/lineas/insertar/lote/{venta}/{cantidad}/{lote}", name="lineas_insertar_lote")
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
        $suma = $venta->getSuma();
        $venta->setSuma($suma + ($cantidad * $precio));

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

    /*
     * @Route("/lineas/nueva/{venta}", name="lineas_nueva")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE')")
     */
    /*public function formLineaAction(Request $request)
    {
        /** @var EntityManager $em */
        /*$em = $this->getDoctrine()->getManager();

        $venta = new Linea();
        $em->persist($venta);

        $form = $this->createForm(LineaType::class, $venta);
        $form->handleRequest($request);

        //Si es válido
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Línea insertada con éxito');
                return $this->redirectToRoute('ventas_modificar');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido crear la venta');
            }

            return $this->render('venta/form.html.twig', [
                'venta' => $venta,
                'formulario' => $form->createView()
            ]);
        }
    }*/

    /**
     * @Route("/ventas/lineas/nueva/{venta}", name="ventas_lineas_nueva")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE')")
     */
    public function formNuevaLineaAction(Request $request, Venta $venta)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        //Creación de un objeto de la clase Linea
        $linea = new Linea();
        $em->persist($linea);

        //Ejecución de formulario
        $form = $this->createForm(LineaType::class, $linea, [
            'venta' => $venta
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                //Obtención de la cantidad
                $cantidad = $form['cantidad']->getData();

				//Obtención campos producto y lote (si tienen valor)
				$producto = $form['producto']->getData();
				$lote = $form['lote']->getData();

				//Si la línea es de un producto quitamos cantidad al stock de producto. Si no es así la quitamos del lote
				if ($producto != '[Ninguno]') {
                    $em->persist($producto);
                    $producto
                        ->setStock($producto->getStock() - $cantidad);

                    //Precio del producto
                    $precio = $producto->getPrecio();
                }
                else {
                    $em->persist($lote);
                    $lote
                        ->setStock($lote->getStock() - $cantidad);

                    //Precio del lote
                    $precio = $lote->getPrecioKg();
                }

				//Añadimos la cantidad a la base imponible de la venta
				$suma = $venta->getSuma();
				$venta->setSuma($suma + ($cantidad * $precio));

                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('ventas_listar');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }
        return $this->render('venta/formLineas.html.twig', [
            'venta' => $venta,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/lineas/eliminar/{linea}/{venta}", name="lineas_eliminar")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE')")
     */
    public function eliminarLineaAction(Linea $linea, Venta $venta)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        try {
            //Obtención de la cantidad
            $cantidad = $linea->getCantidad();

            //Obtención del producto
            $producto = $linea->getProducto();

            //Obtención del lote
            $lote = $linea->getLote();

            //Si la línea es de un producto quitamos cantidad al stock de producto. Si no es así la quitamos del lote
            if ($producto != null) {
                $em->persist($producto);
                $producto
                    ->setStock($producto->getStock() + $cantidad);

                //Precio del producto
                $precio = $producto->getPrecio();
            }
            else {
                $em->persist($lote);
                $lote
                    ->setStock($lote->getStock() + $cantidad);

                //Precio del lote
                $precio = $lote->getPrecioKg();
            }

            //Restamos la cantidad a la base imponible de la venta
            $suma = $venta->getSuma();
            $venta->setSuma($suma - ($cantidad * $precio));

            //Borrado de línea
            $em->remove($linea);

            $em->flush();
            $this->addFlash('estado', 'Cambios guardados con éxito');
        }
        catch(\Exception $e) {
            $this->addFlash('error', 'No se han podido guardar los cambios');
        }

        return $this->redirectToRoute('ventas_detalle', [
            'venta' => $venta
        ]);
    }
}

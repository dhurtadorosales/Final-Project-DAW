<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lote;
use AppBundle\Entity\Producto;
use AppBundle\Form\Type\ProductoType;
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
     * @Route("/productos/envasar/{lote}/{producto}/{cantidad}", name="productos_envasar")
     * @Security("is_granted('ROLE_ENCARGADO')")
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
     * @Route("/modificar/producto/{id}", name="modificar_producto")
     */
    public function formProductoAction(Request $request, Producto $producto)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);

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
            'producto' => $producto,
            'formulario' => $form->createView()
        ]);
    }
}

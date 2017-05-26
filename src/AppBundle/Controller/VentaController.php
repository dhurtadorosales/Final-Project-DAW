<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cliente;
use AppBundle\Entity\Linea;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Temporada;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Venta;
use AppBundle\Form\Model\ListaLineas;
use AppBundle\Form\Type\LineaType;
use AppBundle\Form\Type\VentaType;
use Doctrine\ORM\EntityManager;
use Sasedev\MpdfBundle\Service\MpdfService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\TemporadaActual;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class VentaController extends Controller
{
    /**
     * @Route("/ventas/listar", name="ventas_listar")
     * @Route("/ventas/listar/temporada/{temporada}", name="ventas_listar_temporada")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE')")
     */
    public function listarTemporadaAction(Request $request, Temporada $temporada = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Si no recibe ninguna temporada se obtendrá la actual
        if (null === $temporada) {
            //Creamos una instancia del servicio
            $temporadaActual = new TemporadaActual($em);
            $temporada = $temporadaActual->temporadaActualAction();
        }

        $ventas = $em->getRepository('AppBundle:Venta')
            ->getVentasTemporada($temporada);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $ventas,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('venta/listar.html.twig', [
            'ventas' => $ventas,
            'temporada' => $temporada,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/ventas/detalle/{venta}", name="ventas_detalle")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE') or user.getNif() == venta.getUsuario().getNif()")")
     */
    public function detalleAction(Venta $venta)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención de las líneas de la venta
        $lineas = $em->getRepository('AppBundle:Linea')
            ->getLineasVenta($venta);
        dump($lineas);
        $persona = $venta->getUsuario();

        return $this->render('venta/detalle.html.twig', [
            'venta' => $venta,
            'lineas' => $lineas,
            'persona' => $persona
        ]);
    }

    /**
     * @Route("/ventas/listar/socio/{socio}", name="ventas_listar_socio")
     * @Route("/ventas/listar/socio/temporada/{socio}/{temporada}", name="ventas_listar_socio_temporada")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE') or user.getNif() == socio.getUsuario().getNif()")")
     */
    public function listarTemporadaSocioAction(Request $request, Socio $socio, Temporada $temporada = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Si no recibe ninguna temporada se obtendrá la actual
        if (null === $temporada) {
            //Creamos una instancia del servicio
            $temporadaActual = new TemporadaActual($em);
            $temporada = $temporadaActual->temporadaActualAction();
        }

        $ventas = $em->getRepository('AppBundle:Venta')
            ->getVentasTemporadaSocio($temporada, $socio);

        //Obtención del usuario asociado al socio
        $usuario = $socio->getUsuario();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $ventas,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('venta/listar.html.twig', [
            'ventas' => $ventas,
            'temporada' => $temporada,
            'usuario' => $usuario,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/ventas/listar/usuario/{id}", name="ventas_listar_usuario")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE') or user.getNif() == usuario.getNif()")")
     */
    public function listarUsuarioAction(Request $request, Usuario $usuario)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $ventas = $em->getRepository('AppBundle:Venta')
            ->getVentasUsuario($usuario);

        $temporada = false;

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $ventas,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('venta/listar.html.twig', [
            'ventas' => $ventas,
            'temporada' => $temporada,
            'usuario' => $usuario,
            'pagination' => $pagination
        ]);
    }

    /*
     * @Route("/ventas/insertar/cliente/{usuario}", name="ventas_insertar_cliente")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE')")
     */
    /*public function insertarClienteAction(Usuario $usuario)
    {
        /** @var EntityManager $em */
       /* $em = $this->getDoctrine()->getManager();

        //Obtenemos la temporada vigente
        //Si no recibe ninguna temporada se obtendrá la actual
        $temporadaActual = new TemporadaActual($em);
        $temporada = $temporadaActual->temporadaActualAction();

        //Obtenemos los porcentajes. Si el usuario es socio solo paga el iva reducido
        $porcentajes = $em->getRepository('AppBundle:Porcentaje')
            ->findAll();

        if ($usuario->getRolSocio() == true) {
            $iva = $porcentajes[1]->getCantidad();
        }
        else {
            $iva = $porcentajes[0]->getCantidad();
        }

        //Obtenemos el número de ventas de este año
        $fecha = new \DateTime('now');
        $anio = $fecha->format('Y');
        $numero = $em->getRepository('AppBundle:Venta')
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
            ->setUsuario($usuario)
            ->setTemporada($temporada)
            ->setDescuento($usuario->getDescuento());

        $em->flush();

        $mensaje = 'Venta insertada correctamente';

        return $this->render('venta/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }*/

    /**
     * @Route("/ventas/nueva/{usuario}", name="ventas_nueva")
     * * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE')")
     */
    public function nuevaVentaAction(Request $request, Usuario $usuario)
    {
        /** @var EntityManager $em */
         $em = $this->getDoctrine()->getManager();

         //Obtenemos la temporada vigente
         $temporadaActual = new TemporadaActual($em);
         $temporada = $temporadaActual->temporadaActualAction();

         //Obtenemos los porcentajes. Si el usuario es socio solo paga el iva reducido
         $porcentajes = $em->getRepository('AppBundle:Porcentaje')
             ->findAll();

         if ($usuario->getRolSocio() == true) {
             $iva = $porcentajes[1]->getCantidad();
         }
         else {
             $iva = $porcentajes[0]->getCantidad();
         }

         //Obtenemos el número de ventas de este año
         $fecha = new \DateTime('now');
         $anio = $fecha->format('Y');
         $numero = $em->getRepository('AppBundle:Venta')
             ->getVentasAnio($anio);
         $numero ++;

         try {
             //Creación de nueva venta
             $venta = new Venta();
             $em->persist($venta);

             $venta
                 ->setNumero($numero)
                 ->setFecha(new \DateTime('now'))
                 ->setSuma(0)
                 ->setIva($iva)
                 ->setUsuario($usuario)
                 ->setTemporada($temporada)
                 ->setDescuento($usuario->getDescuento())
                 ->setCerrada(false);

             $em->flush();
             $this->addFlash('estado', 'Venta creada con éxito');
         } catch (\Exception $e) {
             $this->addFlash('error', 'No se ha podido crear la venta');
         }

         if ($usuario->getRolSocio() != true) {
             $temporada = false;
         }

         //Obtención de todas las ventas de ese usuario
         $ventas = $em->getRepository('AppBundle:Venta')
             ->getVentasUsuario($usuario);

            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $ventas,
                $request->query->getInt('page', 1), 4
            );

         return $this->redirectToRoute('ventas_listar_usuario', [
             'id' => $usuario->getId()
         ]);
     }

     /**
      * @Route("/ventas/modificar/{venta}", name="ventas_modificar")
      * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE')")
      */
    public function formVentaAction(Request $request, Venta $venta = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(VentaType::class, $venta);
        $form->handleRequest($request);

        //Obtención del usuario al que pertenece la venta
        $usuario = $venta->getUsuario();

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                //Dejamos la venta abierta para añadir líneas
                $venta->setCerrada(false);

                $em->flush();
                $this->addFlash('estado', 'Venta modificada con éxito');
                return $this->redirectToRoute('ventas_listar_usuario', [
                    'id' => $usuario
                ]);
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido modificar la venta');
            }
        }

        return $this->render('venta/form.html.twig', [
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/ventas/principal/{id}", name="ventas_principal")
     * @Security("is_granted('ROLE_USUARIO')")
     */
    public function irPrincipalAction(Request $request, Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $temporadas = $em->getRepository('AppBundle:Temporada')
            ->getTemporadas();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $temporadas,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('venta/principal.html.twig', [
            'temporadas' => $temporadas,
            'socio' => $socio,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/ventas/cerrar/{venta}", name="ventas_cerrar")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE')")
     */
    public function eliminarLineaAction(Venta $venta)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        try {
            //Obtención de la cantidad
            $venta->setCerrada(true);
            $em->persist($venta);

            $em->flush();
            $this->addFlash('estado', 'Venta cerrada con éxito');
        }
        catch(\Exception $e) {
            $this->addFlash('error', 'No se ha podido cerrar la venta');
        }

        return $this->redirectToRoute('ventas_listar_usuario', [
            'id' => $venta->getUsuario()->getId()
        ]);
    }

    /**
     * @Route("/ventas/imprimir/{venta}", name="ventas_imprimir")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE') or user.getNif() == venta.getUsuario().getNif()")")
     */
    public function pdfAction(Venta $venta)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención de las líneas de la venta
        $lineas = $em->getRepository('AppBundle:Linea')
            ->getLineasVenta($venta);

        $persona = $venta->getUsuario();

        $filename = 'factura' . '_' . $venta->getNumero() . '_' . $venta->getFecha()->format('Y') . '.pdf';

        /** @var MpdfService $mpdf */
        $mpdf = $this->get('sasedev_mpdf');
        $mpdf->init('', 'A4');
        $mpdf->getMpdf();
        $mpdf->useTwigTemplate('venta/informe.html.twig', [
            'titulo' => $filename,
            'venta' => $venta,
            'lineas' => $lineas,
            'persona' => $persona
        ]);

        return $mpdf->generateInlineFileResponse($filename);
    }
}

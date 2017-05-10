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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\TemporadaActual;
use Symfony\Component\HttpFoundation\Request;

class VentaController extends Controller
{
    /**
     * @Route("/ventas/listar", name="ventas_listar")
     * @Route("/ventas/listar/temporada/{temporada}", name="ventas_listar_temporada")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE')")
     */
    public function listarTemporadaAction(Temporada $temporada = null)
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

        return $this->render('venta/listar.html.twig', [
            'ventas' => $ventas,
            'temporada' => $temporada
        ]);
    }

    /**
     * @Route("/ventas/detalle/{venta}", name="ventas_detalle")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE') or user.getNif() == usuario.getNif()")")
     */
    public function detalleAction(Venta $venta)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención de las líneas de la venta
        $lineas = $em->getRepository('AppBundle:Linea')
            ->getLineasVenta($venta);


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
    public function listarTemporadaSocioAction(Socio $socio, Temporada $temporada = null)
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

        return $this->render('venta/listar.html.twig', [
            'ventas' => $ventas,
            'temporada' => $temporada,
            'usuario' => $usuario
        ]);
    }

    /**
     * @Route("/ventas/listar/usuario/{id}", name="ventas_listar_usuario")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE') or user.getNif() == usuario.getNif()")")
     */
    public function listarUsuarioAction(Usuario $usuario)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $ventas = $em->getRepository('AppBundle:Venta')
            ->getVentasUsuario($usuario);

        $temporada = false;

        return $this->render('venta/listar.html.twig', [
            'ventas' => $ventas,
            'temporada' => $temporada,
            'usuario' => $usuario
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
     * @Route("/ventas/modificar/{venta}", name="ventas_modificar")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE')")
     */
    public function formVentaAction(Request $request, Usuario $usuario = null, Venta $venta = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtenemos la temporada vigente
        $temporadaActual = new TemporadaActual($em);
        $temporada = $temporadaActual->temporadaActualAction();

        //Obtenemos el número de ventas de este año
        $fecha = new \DateTime('now');
        $anio = $fecha->format('Y');
        $numero = $em->getRepository('AppBundle:Venta')
            ->getVentasAnio($anio);
        $numero ++;

        if (null == $venta) {
            //Creación de una nueva venta
            $venta = new Venta();
            $em->persist($venta);
        }
        else {
            $usuario = $venta->getUsuario();
        }

        $form = $this->createForm(VentaType::class, $venta, [
            'numero' => $numero,
            'fecha' => $fecha,
            'temporada' => $temporada,
            'usuario' => $usuario
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                //Dejamos la venta abiera para añadir líneas
                $venta->setCerrada(false);

                $em->flush();
                $this->addFlash('estado', 'Venta creada con éxito');
                return $this->redirectToRoute('ventas_listar_usuario', [
                    'id' => $usuario->getId()
                ]);
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido crear la venta');
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
    public function irPrincipalAction(Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $temporadas = $em->getRepository('AppBundle:Temporada')
            ->getTemporadas();

        return $this->render('venta/principal.html.twig', [
            'temporadas' => $temporadas,
            'socio' => $socio
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
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Liquidacion;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\SocioType;
use AppBundle\Service\TemporadaActual;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class SocioController extends Controller
{
    /**
     * @Route("/socios/listar", name="socios_listar")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or is_granted('ROLE_ENCARGADO')")
     */
    public function listarAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $socios = $em->getRepository('AppBundle:Socio')
            ->getSocios();

        //Variable auxiliar
        $baja = false;

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $socios,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('socio/virgen_extra.html.twig', [
            'socios' => $socios,
            'baja' => $baja,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/socios/buscar", name="socios_buscar")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or is_granted('ROLE_ENCARGADO')")
     */
    public function buscarSociosAction(Request $request)
    {
        if ('' === $request) {
            return $this->listarAction($request);
        }
        else {
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            if ($request->get('baja') == false) {
                $socios = $em->getRepository('AppBundle:Socio')
                    ->buscarSocios($request->get('buscar'));
            }
            else {
                $socios = $em->getRepository('AppBundle:Socio')
                    ->buscarSociosBaja($request->get('buscar'));
            }

            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $socios,
                $request->query->getInt('page', 1), 4
            );
        }

        //Variable auxiliar
        $baja = $request->get('baja');

        return $this->render('socio/virgen_extra.html.twig', [
            'socios' => $socios,
            'baja' => $baja,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/socios/nuevo", name="socios_nuevo")
     * @Route("/socios/modificar/{socio}", name="socios_modificar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function formClienteAction(Request $request, Socio $socio = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtenemos la fecha actual
        $fecha = new \DateTime('now');

        //Obtención de la temporada actual
        $temporadaActual = new TemporadaActual($em);
        $temporada = $temporadaActual->temporadaActualAction();

        if (null == $socio) {
            //Nuevo socio
            $socio = new Socio();
            $em->persist($socio);

            //Nuevo usuario que debe ser asignado al nuevo socio
            $usuario = new  Usuario();
            $em->persist($usuario);

            $usuario
                ->setAdministrador(false)
                ->setEmpleado(false)
                ->setComercial(false)
                ->setDependiente(false)
                ->setEncargado(false)
                ->setCliente(false)
                ->setRolSocio(true)
                ->setActivo(true)
                ->setclave(0)
                ->setSocio($socio);

            //Asignación fecha de alta, activo y usuario
            $socio
                ->setFechaAlta($fecha)
                ->setActivo(true)
                ->setUsuario($usuario);

            $form = $this->createForm(SocioType::class, $socio);
            $form->handleRequest($request);

            //Si es válido
            if ($form->isSubmitted() && $form->isValid()) {
                try {
                    //Letra del socio a mayúscula
                    $nif = $socio->getUsuario()->getNif();
                    $nif = strtoupper($nif);
                    $socio->getUsuario()->setNif($nif);

                    //Asignación de la clave. Será la misma que su nif
                    $clave = $this->get('security.password_encoder')
                        ->encodePassword($socio->getUsuario(), $nif);
                    $socio->getUsuario()->setClave($clave);

                    //Crear la liquidación del socio
                    $liquidacion = new  Liquidacion();
                    $em->persist($liquidacion);
                    $liquidacion
                        ->setTemporada($temporada)
                        ->setFecha(null)
                        ->setIva(0.1)
                        ->setRetencion(0.02)
                        ->setSocio($socio);

                    $em->flush();
                    $this->addFlash('estado', 'Socio guardado con éxito');
                    return $this->redirectToRoute('socios_listar');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'No se ha podido guardar el socio');
                }
            }
        }
        else {
            $form = $this->createForm(SocioType::class, $socio);
            $form->handleRequest($request);

            //Si es válido
            if ($form->isSubmitted() && $form->isValid()) {
                try {
                    $em->flush();
                    $this->addFlash('estado', 'Socio guardado con éxito');
                    return $this->redirectToRoute('socios_listar');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'No se ha podido guardar el socio');
                }
            }
        }

        $socio = false;

        return $this->render('socio/form.html.twig', [
            'socio' => $socio,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/socios/eliminar/{socio}", name="confirmar_socios_eliminar", methods={"POST"})
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function confirmarBorradoAction(Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $em->persist($socio);
        try {
            //Obtenemos el usuario correspondiente al socio
            $usuario = $socio->getUsuario();
            $em->persist($usuario);

            //Desactivamos al socio y al usuario si no es el administrador
            if ($usuario->getAdministrador() == true) {
                $this->addFlash('error', 'No se puede dar de baja a este usuario ya que es el administrador');
            }
            else {
                $socio
                    ->setActivo(false)
                    ->setFechaBaja(new \DateTime('now'));
                $usuario
                    ->setActivo(false);

                $em->flush();

                $this->addFlash('estado', 'Socio eliminado con éxito');
            }
        }
        catch(Exception $e) {
            $this->addFlash('error', 'No se ha podido eliminar el socio');
        }

        return $this->redirectToRoute('socios_listar');
    }

    /**
     * @Route("/socios/listar/baja", name="socios_listar_baja")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function listarBajaAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtenemos los socios desactivos
        $socios = $em->getRepository('AppBundle:Socio')
            ->getSociosBaja();

        //Variable auxiliar
        $baja = true;

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $socios,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('socio/virgen_extra.html.twig', [
            'socios' => $socios,
            'baja' => $baja,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/socios/reactivar/{socio}", name="socios_reactivar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function reactivarAction(Request $request, Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Activación del socio con fecha de alta hoy y con su dni como clave
        $socio
            ->setActivo(true)
            ->setFechaAlta(new \DateTime('now'))
            ->setFechaBaja(null);
        $em->persist($socio);

        $usuario = $socio->getUsuario()->setActivo(true);

        $em->flush();

        //Obtención de todos los socios activos para mostrarlos
        $socios = $em->getRepository('AppBundle:Socio')
            ->getSocios();

        //Variable auxiliar
        $baja = false;

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $socios,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('socio/virgen_extra.html.twig', [
            'socios' => $socios,
            'baja' => $baja,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/socios/pass/{socio}", name="socios_pass")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function passAction(Request $request, Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        try {
            //Establecimiento de la contraseña con su nif
            $usuario = $socio->getUsuario();
            $nif = $usuario->getNif();
            $clave = $this->get('security.password_encoder')
                ->encodePassword($usuario, $nif);
            $socio
                ->getUsuario()->setClave($clave);
            $em->persist($socio);

            $this->addFlash('estado', 'Contraseña reestablecida con éxito');
            $em->flush();
        }
        catch(Exception $e) {
            $this->addFlash('error', 'No se ha podido reestablecer la contraseña');
        }

        //Obtención de todos los socios activos
        $socios = $em->getRepository('AppBundle:Socio')
            ->getSocios();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $socios,
            $request->query->getInt('page', 1), 4
        );

        //Variable auxiliar
        $baja = false;

        return $this->render('socio/virgen_extra.html.twig', [
            'socios' => $socios,
            'baja' => $baja,
            'pagination' => $pagination
        ]);
    }
}

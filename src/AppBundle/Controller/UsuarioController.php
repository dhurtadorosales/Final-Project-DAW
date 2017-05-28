<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\ClienteType;
use AppBundle\Form\Type\EmpleadoType;
use AppBundle\Form\Type\UsuarioType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class UsuarioController extends Controller
{
    /**
     * @Route("/usuarios/listar", name="usuarios_listar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function listarUsuariosAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $usuarios = $em->getRepository('AppBundle:Usuario')
            ->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $usuarios,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('usuario/listar.html.twig', [
            'usuarios' => $usuarios,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/clientes/listar", name="clientes_listar")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE')")
     */
    public function listarClientesAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $clientes = $em->getRepository('AppBundle:Usuario')
            ->getClientes();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $clientes,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('usuario/listarClientes.html.twig', [
            'clientes' => $clientes,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/empleados/listar", name="empleados_listar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function listarEmpleadosAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $empleados = $em->getRepository('AppBundle:Usuario')
            ->getEmpleados();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $empleados,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('usuario/listarEmpleados.html.twig', [
            'empleados' => $empleados,
            'pagination' =>$pagination
        ]);
    }

    /**
     * @Route("/empleados/buscar", name="empleados_buscar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function buscarEmpleadosAction(Request $request)
    {
        if ('' === $request) {
            return $this->listarEmpleadosAction($request);
        }
        else {
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $empleados = $em->getRepository('AppBundle:Usuario')
                ->buscarEmpleados($request->get('buscar'));

            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $empleados,
                $request->query->getInt('page', 1), 4
            );
        }

        return $this->render('usuario/listarEmpleados.html.twig', [
            'empleados' => $empleados,
            'pagination' =>$pagination
        ]);
    }

    /**
     * @Route("/clientes/buscar", name="clientes_buscar")
     * @Security("is_granted('ROLE_COMERCIAL') or is_granted('ROLE_DEPENDIENTE)'")
     */
    public function buscarClientesAction(Request $request)
    {
        if ('' === $request) {
            return $this->listarClientesAction($request);
        }
        else {
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $clientes = $em->getRepository('AppBundle:Usuario')
                ->buscarClientes($request->get('buscar'));

            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $clientes,
                $request->query->getInt('page', 1), 4
            );
        }

        return $this->render('usuario/listarClientes.html.twig', [
            'empleados' => $clientes,
            'pagination' =>$pagination
        ]);
    }

    /**
     * @Route("/entrar", name="entrar")
     */
    public function indexAction()
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render('usuario/login.html.twig', [
            'ultimo_usuario' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/comprobar", name="comprobar")
     * @Route("/salir", name="salir")
     */
    public function comprobarAction()
    {

    }

    /**
     * @Route("/perfil", name="perfil")
     */
    public function cambiarPerfilAction(Request $request)
    {
        $usuario = $this->getUser();

        $form = $this->createForm(UsuarioType::class, $usuario);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            try {
            $claveFormulario = $form->get('nueva')->get('first')->getData();

            if ($claveFormulario) {
                $clave = $this->get('security.password_encoder')
                    ->encodePassword($usuario, $claveFormulario);

                $usuario->setClave($clave);
            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('estado', 'Contraseña guardada con éxito');
            return $this->redirectToRoute('principal');

            } catch (Exception $e) {
                $this->addFlash('error', 'No se ha podido guardar la contraseña');
            }
        }

        return $this->render('usuario/perfil.html.twig', [
            'formulario' => $form->createView(),
            'usuario' => $usuario
        ]);
    }

    /**
     * @Route("/empleados/nuevo", name="empleados_nuevo")
     * @Route("/empleados/modificar/{id}", name="empleados_modificar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function formEmpleadoAction(Request $request, Usuario $usuario = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $usuario) {
            $usuario = new Usuario();
            $em->persist($usuario);
            $usuario
                ->setAdministrador(false)
                ->setEmpleado(true)
                ->setComercial(false)
                ->setDependiente(false)
                ->setEncargado(false)
                ->setCliente(false)
                ->setRolSocio(false)
                ->setActivo(true)
                ->setclave(0);
        }

        $form = $this->createForm(EmpleadoType::class, $usuario);
        $form->handleRequest($request);

        //Si es válido
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $clave = $this->get('security.password_encoder')
                    ->encodePassword($usuario, $usuario->getNif());

                $usuario->setClave($clave);

                $em->flush();
                $this->addFlash('estado', 'Empleado guardado con éxito');
                return $this->redirectToRoute('empleados_listar');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se ha podido guardar el empleado');
            }
        }

        return $this->render('usuario/formEmpleado.html.twig', [
            'formulario' => $form->createView(),
            'usuario' => $usuario
        ]);
    }

    /**
     * @Route("/clientes/nuevo", name="clientes_nuevo")
     * @Route("/clientes/modificar/{id}", name="clientes_modificar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function formClienteAction(Request $request, Usuario $usuario = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        dump($usuario);
        if (null == $usuario) {
            $usuario = new Usuario();
            $em->persist($usuario);

            $usuario
                ->setAdministrador(false)
                ->setEmpleado(false)
                ->setComercial(false)
                ->setDependiente(false)
                ->setEncargado(false)
                ->setCliente(true)
                ->setRolSocio(false)
                ->setActivo(true)
                ->setclave(0);
        }

        $form = $this->createForm(ClienteType::class, $usuario);
        $form->handleRequest($request);

        //Si es válido
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $clave = $this->get('security.password_encoder')
                    ->encodePassword($usuario, $usuario->getNif());

                $usuario->setClave($clave);

                $em->flush();
                $this->addFlash('estado', 'Cliente guardado con éxito');
                return $this->redirectToRoute('clientes_listar');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se ha podido guardar el cliente');
            }
        }

        return $this->render('usuario/formCliente.html.twig', [
            'formulario' => $form->createView(),
            'usuario' => $usuario
        ]);
    }

    /**
     * @Route("/empleados/eliminar/{nif}", name="confirmar_empleados_eliminar", methods={"POST"})
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function confirmarBorradoAction(Usuario $usuario)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        try {
            //Desactivamos al usuario si no es el administrador
            if ($usuario->getAdministrador() == true) {
                $this->addFlash('error', 'No se puede dar de baja a este empleado ya que es el administrador');
            }
            else {
                $em->remove($usuario);
                $em->flush();
                $this->addFlash('estado', 'Empleado eliminado con éxito');
            }
        }
        catch(Exception $e) {
            $this->addFlash('error', 'No se ha podido eliminar el empleado');
        }

        return $this->redirectToRoute('empleados_listar');
    }

    /**
     * @Route("/usuarios/pass/{usuario}", name="usuarios_pass")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function passAction(Usuario $usuario)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        try {
            //Establecimiento de la contraseña con su nif
            $nif = $usuario->getNif();
            $clave = $this->get('security.password_encoder')
                ->encodePassword($usuario, $nif);
            $usuario
                ->setClave($clave);
            $em->persist($usuario);

            $this->addFlash('estado', 'Contraseña reestablecida con éxito');
            $em->flush();
        }
        catch(Exception $e) {
            $this->addFlash('error', 'No se ha podido reestablecer la contraseña');
        }

        if ($usuario->getEmpleado() == true) {
            return $this->redirectToRoute('empleados_listar');
        }
        if ($usuario->getCliente() == true) {
            return $this->redirectToRoute('clientes_listar');
        }
    }
}

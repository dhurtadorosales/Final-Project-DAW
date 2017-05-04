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
use Symfony\Component\HttpFoundation\Request;

class UsuarioController extends Controller
{
    /**
     * @Route("/clientes/listar", name="clientes_listar")
     */
    public function listarClientesAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $clientes = $em->getRepository('AppBundle:Usuario')
            ->getClientes();

        return $this->render('usuario/listarClientes.html.twig', [
            'clientes' => $clientes
        ]);
    }

    /**
     * @Route("/empleados/listar", name="empleados_listar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function listarAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $empleados = $em->getRepository('AppBundle:Usuario')
            ->getEmpleados();

        return $this->render('usuario/listarEmpleados.html.twig', [
            'empleados' => $empleados
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
     * @Route("/usuario", name="usuario")
     * @Route("/usuarios/{usuario}", name="usuarios")
     */
    public function principalAction(Usuario $usuario = null)
    {
        if (null === $usuario) {
            $usuario = $this->getUser();
        }
        return $this->render('usuario/principal.html.twig');
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

        $form = $this->createForm(UsuarioType::class, $usuario, [
            'es_administrador' => $this->isGranted('ROLE_ADMINISTRADOR')
        ]);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            $claveFormulario = $form->get('nueva')->get('first')->getData();

            if ($claveFormulario) {
                $clave = $this->get('security.password_encoder')
                    ->encodePassword($usuario, $claveFormulario);

                $usuario->setClave($clave);
            }

            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render('usuario/perfil.html.twig', [
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/empleados/nuevo", name="empleados_nuevo")
     * @Route("/empleados/modificar/{empleado}", name="empleados_modificar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function formEmpleadoAction(Request $request, Usuario $usuario = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $usuario) {
            $usuario = new Usuario();
            $em->persist($usuario);
            $usuario->setEmpleado(true);
        }

        $form = $this->createForm(EmpleadoType::class, $usuario);
        $form->handleRequest($request);

        //Si es válido
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Empleado guardado con éxito');
                return $this->redirectToRoute('principal');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar el empleado');
            }
        }

        return $this->render('usuario/formEmpleado.html.twig', [
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/clientes/nuevo", name="clientes_nuevo")
     * @Route("/clientes/modificar/{cliente}", name="clientes_modificar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function formClienteAction(Request $request, Usuario $usuario = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $usuario) {
            $usuario = new Usuario();
            $em->persist($usuario);
            $usuario->setCliente(true);
        }

        $form = $this->createForm(ClienteType::class, $usuario);
        $form->handleRequest($request);

        //Si es válido
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Empleado guardado con éxito');
                return $this->redirectToRoute('principal');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar el empleado');
            }
        }

        return $this->render('usuario/formCliente.html.twig', [
            'formulario' => $form->createView()
        ]);
    }
}

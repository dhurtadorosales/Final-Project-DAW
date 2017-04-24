<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
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
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\UsuarioType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UsuarioController extends Controller
{
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

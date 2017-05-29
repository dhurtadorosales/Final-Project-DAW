<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;

class PaginaController extends Controller
{
    /**
     * @Route("/virgen/extra", name="virgen_extra")
     *
     */
    public function virgenExtraAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USUARIO')) {
            return $this->render('default/principal.html.twig', [
                'temporadas' => false
            ]);
        } else {

            $this->get('translator')->trans('layout.inicio');

            return $this->render('pagina/virgen_extra.html.twig', [
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                'locale' => $request->getLocale(),
            ]);
        }
    }

    /**
     * @Route("/virgen", name="virgen")
     *
     */
    public function virgenAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USUARIO')) {
            return $this->render('default/principal.html.twig', [
                'temporadas' => false
            ]);
        } else {

            $this->get('translator')->trans('layout.inicio');

            return $this->render('pagina/virgen.html.twig', [
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                'locale' => $request->getLocale(),
            ]);
        }
    }

    /**
     * @Route("/lampante", name="lampante")
     *
     */
    public function lampanteAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USUARIO')) {
            return $this->render('default/principal.html.twig', [
                'temporadas' => false
            ]);
        } else {

            $this->get('translator')->trans('layout.inicio');

            return $this->render('pagina/lampante.html.twig', [
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                'locale' => $request->getLocale(),
            ]);
        }
    }

    /**
     * @Route("/picual", name="picual")
     *
     */
    public function picualAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USUARIO')) {
            return $this->render('default/principal.html.twig', [
                'temporadas' => false
            ]);
        } else {

            $this->get('translator')->trans('layout.inicio');

            return $this->render('pagina/picual.html.twig', [
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                'locale' => $request->getLocale(),
            ]);
        }
    }

    /**
     * @Route("/alberquina", name="alberquina")
     *
     */
    public function alberquinaAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USUARIO')) {
            return $this->render('default/principal.html.twig', [
                'temporadas' => false
            ]);
        } else {

            $this->get('translator')->trans('layout.inicio');

            return $this->render('pagina/alberquina.html.twig', [
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                'locale' => $request->getLocale(),
            ]);
        }
    }

    /**
     * @Route("/gordal", name="gordal")
     *
     */
    public function gordalAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USUARIO')) {
            return $this->render('default/principal.html.twig', [
                'temporadas' => false
            ]);
        } else {

            $this->get('translator')->trans('layout.inicio');

            return $this->render('pagina/gordal.html.twig', [
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                'locale' => $request->getLocale(),
            ]);
        }
    }

    /**
     * @Route("/hojiblanca", name="hojiblanca")
     *
     */
    public function hojiblancaAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USUARIO')) {
            return $this->render('default/principal.html.twig', [
                'temporadas' => false
            ]);
        } else {

            $this->get('translator')->trans('layout.inicio');

            return $this->render('pagina/hojiblanca.html.twig', [
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                'locale' => $request->getLocale(),
            ]);
        }
    }

    /**
     * @Route("/lechin", name="lechin")
     *
     */
    public function lechinAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USUARIO')) {
            return $this->render('default/principal.html.twig', [
                'temporadas' => false
            ]);
        } else {

            $this->get('translator')->trans('layout.inicio');

            return $this->render('pagina/lechin.html.twig', [
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                'locale' => $request->getLocale(),
            ]);
        }
    }
}
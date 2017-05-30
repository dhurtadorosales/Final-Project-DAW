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
     * @Route("/virgen/extra", name="virgen_extra", defaults={"_locale"="es"}, requirements={"_locale"="%app.locales%"})
     * @Route("/virgen/extra/{_locale}", name="virgen_extra_locale", requirements={"_locale" = "%app.locales%"})
     * @Route("/virgen", name="virgen", defaults={"_locale"="es"}, requirements={"_locale"="%app.locales%"})
     * @Route("/virgen/{_locale}", name="virgen_locale", requirements={"_locale" = "%app.locales%"})
     * @Route("/lampante", name="lampante", defaults={"_locale"="es"}, requirements={"_locale"="%app.locales%"})
     * @Route("/lampante/{_locale}", name="lampante_locale", requirements={"_locale" = "%app.locales%"})
     * @Route("/picual", name="picual", defaults={"_locale"="es"}, requirements={"_locale"="%app.locales%"})
     * @Route("/picual/{_locale}", name="picual_locale", requirements={"_locale" = "%app.locales%"})
     * @Route("/alberquina", name="alberquina", defaults={"_locale"="es"}, requirements={"_locale"="%app.locales%"})
     * @Route("/alberquina/{_locale}", name="alberquina_locale", requirements={"_locale" = "%app.locales%"})
     * @Route("/gordal", name="gordal", defaults={"_locale"="es"}, requirements={"_locale"="%app.locales%"})
     * @Route("/gordal/{_locale}", name="gordal_locale", requirements={"_locale" = "%app.locales%"})
     * @Route("/hojiblanca", name="hojiblanca", defaults={"_locale"="es"}, requirements={"_locale"="%app.locales%"})
     * @Route("/hojiblanca/{_locale}", name="hojiblanca_locale", requirements={"_locale" = "%app.locales%"})
     * @Route("/lechin", name="lechin", defaults={"_locale"="es"}, requirements={"_locale"="%app.locales%"})
     * @Route("/lechin/{_locale}", name="lechin_locale", requirements={"_locale" = "%app.locales%"})
     */
    public function indexAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USUARIO')) {
            return $this->render('default/principal.html.twig', [
                'temporadas' => false
            ]);
        }
        else {
            //ruta actual
            $ruta = $request->get('_route');

            //Se comprueba que contiene la subcadena _locale
            if (strpos($ruta, '_locale') != false) {
                $ruta = str_replace('_locale', '', $ruta);
            }

            $titulo = 'pagina.titulo_' . $ruta;
            $cuerpo = 'pagina.cuerpo_' . $ruta;

            $this->get('translator')->trans('layout.inicio');

            return $this->render('pagina/pagina.html.twig', [
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                'locale' => $request->getLocale(),
                'titulo' => $titulo,
                'cuerpo' => $cuerpo
            ]);
        }
    }
}
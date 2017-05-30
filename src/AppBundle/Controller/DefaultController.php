<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="inicio", defaults={"_locale"="es"}, requirements={"_locale"="%app.locales%"})
     * @Route("/{_locale}", name="inicio_locale", requirements={"_locale" = "%app.locales%"})
     */
    public function indexAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USUARIO')){
            return $this->render('default/principal.html.twig', [
                'temporadas' => false
            ]);
        }
        else {

            $this->get('translator')->trans('layout.inicio');

            return $this->render('default/index.html.twig', [
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                'locale' => $request->getLocale()
            ]);
        }
    }

    /**
     * @Route("/principal", name="principal")
     * @Security("is_granted('ROLE_USUARIO')")
     */
    public function principalAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención del número de temporadas
        $temporadas = $em->getRepository('AppBundle:Temporada')
            ->getNumeroTemporadas();

        //Obtención del número de avisos
        $numeroAvisos = $em->getRepository('AppBundle:Aviso')
            ->getNumeroAvisos();

        return $this->render('default/principal.html.twig', [
            'temporadas' => $temporadas,
            'numeroAvisos' => $numeroAvisos
        ]);
    }

    /**
     * @Route("/correo", name="correo")
     * @Security("is_granted('ROLE_USUARIO')")
     */
    public function correoAction()
    {
        try {
            $mensaje = \Swift_Message::newInstance()
                ->setSubject('Hello Email')
                ->setFrom($this->getParameter('mailer_user'))
                ->setTo('dhurtadorosales@gmail.com')
                ->setBody(
                    $this->renderView(
                        'default/email.html.twig'
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($mensaje);
            $this->addFlash('estado', 'Correo mandado correctamente');
        }
        catch (Exception $e) {
            $this->addFlash('error', 'Error al enviar el correo');
        }

        return $this->redirectToRoute('principal');
    }
}

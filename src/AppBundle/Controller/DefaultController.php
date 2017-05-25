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
     * @Route("/", name="inicio")
     *
     */
    public function indexAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USUARIO')){
            return $this->render('default/virgen_extra.html.twig', [
                'temporadas' => false
            ]);
        }
        else {
            $titulos = [
                "Aceite Virgen Extra",
                "Aceite Virgen",
                "Aceite Lampante",
                "Aceituna Picual",
                "Un mar de olivos..."
            ];

            $subtitulos = [
                "La joya de la corona",
                "El segundo de a bordo",
                "El gran subestimado",
                "Nuestra principal materia prima",
                "La tierra que nos da sus frutos"
            ];

            $fotos = [
                "virgen_extra.jpg",
                "virgen.jpg",
                "lampante.jpg",
                "picual.jpg",
                "paisaje2.jpg"
            ];
            $this->get('translator')->trans('layout.inicio');

            return $this->render('default/index.html.twig', [
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
                'locale' => $request->getLocale(),
                'titulos' => $titulos,
                'subtitulos' => $subtitulos,
                'fotos' => $fotos
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

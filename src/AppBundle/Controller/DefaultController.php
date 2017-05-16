<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Config\Definition\Exception\Exception;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="inicio")
     *
     */
    public function indexAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USUARIO')){
            return $this->render('default/listar.html.twig', [
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

            return $this->render('default/index.html.twig', [
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

    /**
     * @Route("/pdf", name="pdf")
     * @Security("is_granted('ROLE_USUARIO')")
     */
    public function pdfAction(Request $request)
    {
        if('POST' === $request->getMethod()) {
            //$html = $request->get('html');
        dump($request);
        $html = '<h2>hola</h2>';

            $mpdf = new \mPDF('es-ES', 'A4', '', '', 32, 25, 27, 25, 16, 13);
            $mpdf->onlyCoreFonts = true;
            //$stylesheet = file_get_contents('web/styles/main.css');
            //$mpdf->WriteHTML($stylesheet, 1); //Solo contenido css y no html
            $mpdf->WriteHTML($html, 2);
            $mpdf->Output('liquidacion_2017_2018.pdf', 'D');
        }



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

        return $this->render('default/index.html.twig', [
            'titulos' => $titulos,
            'subtitulos' => $subtitulos,
            'fotos' => $fotos
        ]);
    }
}

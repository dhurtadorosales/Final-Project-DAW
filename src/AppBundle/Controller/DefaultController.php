<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}

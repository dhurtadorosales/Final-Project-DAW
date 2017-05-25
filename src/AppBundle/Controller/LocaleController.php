<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Aceite;
use AppBundle\Entity\Lote;
use AppBundle\Form\Model\ListaAceites;
use AppBundle\Form\Type\AceiteNuevoType;
use AppBundle\Form\Type\ListaAceitesType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LocaleController extends Controller
{

    public function indexAction(Request $request)
    {
        dump($request->getLocale());

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
        }


        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
            'locale' => $request->getLocale(),
            'titulos' => $titulos,
            'subtitulos' => $subtitulos,
            'fotos' => $fotos
        ]);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Amasada;
use AppBundle\Entity\Partida;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PartidaController extends Controller
{
    /**
     * @Route("/partidas/listar", name="partidas_listar")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $partidas = $em->getRepository('AppBundle:Partida')
            ->getPartidas();

        return $this->render('partida/listarTemporada.html.twig', [
            'partidas' => $partidas
        ]);
    }

    /**
     * @Route("/partidas/insertar", name="partidas_insertar")
     */
    public function insertarAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $partidas = [
            [0, "2017-03-28", 0, null],
            [0, "2017-03-28", 0, null],
            [0, "2017-03-28", 0, null]
        ];

        //Crea partida
        foreach ($partidas as $item) {
            $partida = new Partida();
            $em->persist($partida);
            $partida
                ->setFechaFabricacion(new \DateTime($item[1]))
                ->setCantidad($item[2]);

            $em->flush();
        }

        $mensaje = 'Partidas insertadas correctamente';

        return $this->render('partida/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}

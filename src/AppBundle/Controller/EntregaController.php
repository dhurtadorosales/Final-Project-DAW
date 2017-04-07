<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Entrega;
use AppBundle\Entity\Finca;
use AppBundle\Entity\Socio;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EntregaController extends Controller
{
    /**
     * @Route("/entregas/listar", name="entregas_listar")
     */
    public function listarAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $entregas = $em->getRepository('AppBundle:Entrega')
            ->getEntregas();

        return $this->render('entrega/listar.html.twig', [
            'entregas' => $entregas,
        ]);
    }

    /**
     * @Route("/entregas/listar/socio/{socio}", name="entregas_listar_socio")
     */
    public function listarPorSocioAction(Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $entregas = $em->getRepository('AppBundle:Entrega')
            ->getEntregasSocio($socio);

        return $this->render('entrega/listar.html.twig', [
            'entregas' => $entregas,
            'socio' => $socio,
        ]);
    }

    /**
     * @Route("/entregas/detalle/{entrega}/{socio}", name="entregas_detalle")
     */
    public function detalleAction(Entrega $entrega, Socio $socio)
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();
        $resultado = $em->getRepository('AppBundle:Entrega')
            ->getEntregasDetalle($entrega, $socio);

        return $this->render('entrega/detalle.html.twig', [
            'resultado' => $resultado,
            'socio' => $socio,
            'entrega' => $entrega
        ]);
    }

    /**
     * @Route("/entregas/insertar", name="entregas_insertar")
     */
    public function insertarAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención de procedencias
        $procedencias = $em->getRepository('AppBundle:Procedencia')
            ->getProcedencias();

        //Obtención de fincas
        $fincas = $em->getRepository('AppBundle:Finca')
            ->getFincas();

        $entregas = [
            [0, "2017-03-28", "16:15", "16:20", 1500, 18, 0, null, 1, $procedencias[0], null, $fincas[0]],
            [0, "2017-03-28", "16:20", "16:25", 500, 23, 0.10, "Muy sucia", 1, $procedencias[1], null, $fincas[0]],
            [0, "2017-03-28", "16:25", "16:30", 200, 25, 0, null, 2, $procedencias[1], null, $fincas[2]],
            [0, "2017-03-28", "16:30", "17:03", 1000, 22, 0.10, "Atasco de tolva", 3, $procedencias[1], null, $fincas[1]],
            [0, "2017-03-28", "17:07", "17:20", 900, 18, 0, null, 3, $procedencias[0], null, $fincas[2]]
        ];

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        foreach ($entregas as $item) {
            $entrega = new Entrega();
            $em->persist($entrega);
            $entrega
                ->setFecha(new \DateTime($item[1]))
                ->setHoraInicio(new \DateTime($item[2]))
                ->setHoraFin(new \DateTime($item[3]))
                ->setPeso($item[4])
                ->setRendimiento($item[5])
                ->setSancion($item[6])
                ->setObservaciones($item[7])
                ->setBascula($item[8])
                ->setProcedencia($item[9])
                ->setFinca($item[11]);

            $em->flush();
        }
        $mensaje = 'Entradas insertadas correctamente';

        return $this->render('entrega/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }

    /**
     * @Route("/entregas/asignar/partida", name="entregas_asignar_partida")
     */
    public function asignarPartidaAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención de procedencias
        $partidas = $em->getRepository('AppBundle:Partida')
            ->getPartidas();

        //Obtención de entregas
        $entregas = $em->getRepository('AppBundle:Entrega')
            ->getEntregas();

        $asignaciones = [
            $partidas[0],
            $partidas[1],
            $partidas[2],
            $partidas[2],
            $partidas[0],
        ];

        //Asigna partida a cada entrega
        for ($i = 0; $i < sizeof($asignaciones); $i++) {
            $em->persist($entregas[$i]);
            $entregas[$i]
                ->setPartida($asignaciones[$i]);

            $em->flush();
        }

        //Suma cantidad a cada partida
        foreach ($entregas as $item) {
            $entrega = new Entrega();
            $em->persist($entrega);
            $entrega
                ->setFecha(new \DateTime($item[1]))
                ->setHoraInicio(new \DateTime($item[2]))
                ->setHoraFin(new \DateTime($item[3]))
                ->setPeso($item[4])
                ->setRendimiento($item[5])
                ->setSancion($item[6])
                ->setObservaciones($item[7])
                ->setBascula($item[8])
                ->setProcedencia($item[9])
                ->setFinca($item[11]);

            $em->flush();
        }

        $mensaje = 'Partidas asignadas correctamente';

        return $this->render('entrega/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}

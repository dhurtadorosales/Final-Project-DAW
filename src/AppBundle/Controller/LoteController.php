<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lote;
use AppBundle\Entity\Socio;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoteController extends Controller
{
    /**
     * @Route("/lotes/listar", name="lotes_listar")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $lotes = $em->getRepository('AppBundle:Lote')
            ->getLotes();

        return $this->render('lote/listar.html.twig', [
            'lotes' => $lotes
        ]);
    }

    /**
     * @Route("/lotes/listar/{lote}", name="lotes_listar_lote")
     */
    public function listarFincasAction(Lote $lote)
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $resultados = $em->getRepository('AppBundle:Lote')
            ->getLoteUnico();

        return $this->render('lote/detalle.html.twig', [
            'resultados' => $resultados
        ]);
    }

    /**
     * @Route("/lotes/insertar", name="lotes_insertar")
     */
    public function insertarAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $numLotes = 90;
        $cantidad = 0;
        $temporada = '16/17';

        for ($i = 0; $i < $numLotes; $i++) {
            $lote = new Lote();
            $em->persist($lote);
            $lote
                ->setTemporada($temporada)
                ->setCantidad($cantidad);

            $em->flush();
        }
        $mensaje = 'Lotes insertados correctamente';

        return $this->render('lote/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }

    /**
     * @Route("/lotes/partidas/asignar", name="lotes_partidas_asignar")
     */
    public function partidasAsignarAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtener lotes
        $lotes = $em->getRepository('AppBundle:Lote')
            ->getLotes();

        //Obtener cantidad
        $cantidad = $em->getRepository('AppBundle:Lote')
            ->getLoteUnico($lotes[0]);

        //Obtener partidas
        $partidas = $em->getRepository('AppBundle:Partida')
            ->getPartidas();

        //Asigna lote a la partida
        $em->persist($partidas[0]);
        $partidas[0]
            ->setLote($lotes[0]);
        $em->flush();

        //Suma cantidad al lote
        $em->$em->persist($lotes[0]);
        $lotes[0]
            ->setCantidad($cantidad);


 /*       for ($i = 0; $i < sizeof($partidas); $i++) {
            $em->persist($partidas[$i]);
            $partidas[$i]
                ->setLote($lotes[$i]);

            $em->flush();
        }*/
        $mensaje = 'Partidas asignadas correctamente';

        return $this->render('lote/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}

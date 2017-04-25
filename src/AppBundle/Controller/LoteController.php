<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Aceite;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Partida;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Temporada;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoteController extends Controller
{
    /**
     * @Route("/lotes/listar/{temporada}", name="lotes_listar")
     */
    public function indexAction(Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $lotes = $em->getRepository('AppBundle:Lote')
            ->getLotesTemporada($temporada);

        return $this->render('lote/listar.html.twig', [
            'lotes' => $lotes,
            'temporada' => $temporada
        ]);
    }

    /**
     * @Route("/lotes/listar/lote/{lote}", name="lotes_listar_lote")
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
     * @Route("/lotes/partidas/asignar/{partida}/{lote}", name="lotes_partidas_asignar")
     */
    public function partidasAsignarAction(Partida $partida, Lote $lote)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Asigna la partida al lote
        $em->persist($partida);
        $partida
            ->setLote($lote);
        $em->flush();

        //Obtener cantidad del lote
        $cantidadLote = $lote->getCantidad();

        //Obtener cantidad de la partida
        $cantidadPartida = $partida->getCantidad();

        //Suma cantidad al lote
        $cantidadNueva = $cantidadLote + $cantidadPartida;

        $em->persist($lote);
        $lote
            ->setCantidad($cantidadNueva)
            ->setStock($cantidadNueva);

        $em->flush();

        $mensaje = 'Partida asignada correctamente';

        return $this->render('lote/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }

    /**
     * @Route("/lotes/aceite/asignar/{aceite}/{lote}", name="lotes_aceite_asignar")
     */
    public function aceiteAsignarAction(Aceite $aceite, Lote $lote)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Asigna el aceite al lote
        $em->persist($lote);
        $lote
            ->setAceite($aceite);
        $em->flush();

        $mensaje = 'Aceite asignado correctamente';

        return $this->render('lote/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}

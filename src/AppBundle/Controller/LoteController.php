<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Aceite;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Partida;

use AppBundle\Entity\Temporada;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\TemporadaActual;

class LoteController extends Controller
{
    /**
     * @Route("/lotes/listar", name="lotes_listar")
     * @Route("/lotes/listar/{temporada}", name="lotes_listar_temporada")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or is_granted('ROLE_EMPLEADO')")
     */
    public function listarLotesAction(Temporada $temporada = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Si no recibe ninguna temporada se obtendrá la actual
        if (null === $temporada) {
            //Creamos una instancia del servicio
            $temporadaActual = new TemporadaActual($em);
            $temporada = $temporadaActual->temporadaActualAction();
        }

        $lotes = $em->getRepository('AppBundle:Lote')
            ->getLotesTemporada($temporada);

        return $this->render('lote/listar.html.twig', [
            'lotes' => $lotes,
            'temporada' => $temporada
        ]);
    }

    /**
     * @Route("/lotes/listar/asignacion", name="lotes_listar_asignacion")
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function listarLotesAsignacionAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención temporada actual
        $temporadaActual = new TemporadaActual($em);
        $temporada = $temporadaActual->temporadaActualAction();

        $lotes = $em->getRepository('AppBundle:Lote')
            ->getLotesTemporadaNoNulos($temporada);

        return $this->render('lote/listarAsignacion.html.twig', [
            'lotes' => $lotes,
            'temporada' => $temporada
        ]);
    }

    /**
     * @Route("/lotes/listar/lote/{lote}", name="lotes_listar_lote")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or is_granted('ROLE_EMPLEADO')")
     */
    public function listarLotesLoteAction(Lote $lote)
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
     * @Route("/lotes/aceite/asignar/{aceite}/{lote}", name="lotes_aceite_asignar")
     * @Security("is_granted('ROLE_ENCARGADO')")
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

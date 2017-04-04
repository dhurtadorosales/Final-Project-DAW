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

        $lotes = $em->createQueryBuilder()
            ->select('l')
            ->from('AppBundle:Lote', 'l')
            ->getQuery()
            ->getResult();

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

        $resultados = $em->createQueryBuilder()
            ->select('l')
            ->from('AppBundle:Lote', 'l')
            ->where('l.id = :lot')
            ->setParameter('lot', $lote)
            ->getQuery()
            ->getResult();

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
        }
        $mensaje = 'Entradas insertadas correctamente';

        return $this->render('lote/operaciones.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}

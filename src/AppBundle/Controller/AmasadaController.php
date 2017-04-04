<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Amasada;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AmasadaController extends Controller
{
    /**
     * @Route("/amasadas/listar", name="amasadas_listar")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $amasadas = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Amasada', 'a')
            ->getQuery()
            ->getResult();

        return $this->render('amasada/listar.html.twig', [
            'amasadas' => $amasadas
        ]);
    }

    /**
     * @Route("/amasadas/insertar", name="amasadas_insertar")
     */
    public function insertarAction()
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $lotes = $em->createQueryBuilder()
            ->select('l')
            ->from('AppBundle:Lote', 'l')
            ->getQuery()
            ->getResult();

        $amasadas = [
            [0, "2017-03-28", 0, $lotes[0]],
            [0, "2017-03-28", 0, $lotes[1]],
            [0, "2017-03-28", 0, $lotes[1]]
        ];

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        foreach ($amasadas as $item) {
            $amasada = new Amasada();
            $em->persist($amasada);
            $amasada
                ->setFechaFabricacion(new \DateTime($item[1]))
                ->setCantidad($item[2])
                ->setLote($item[3]);

            $em->flush();
        }
        $mensaje = 'Amasadas insertadas correctamente';

        return $this->render('amasada/operaciones.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}

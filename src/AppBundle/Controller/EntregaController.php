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
     * @Route("/entregas/listar/{socio}", name="entregas_listar")
     */
    public function indexAction(Socio $socio)
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $entregas = $em->createQueryBuilder()
            ->select('e')
            ->addSelect('f')
            ->addSelect('p')
            ->from('AppBundle:Entrega', 'e')
            ->join('e.finca', 'f')
            ->join('f.propietario', 'p')
            ->join('f.arrendatario', 'a')
            ->where('p = :socio')
            ->orwhere('a = :socio')
            ->setParameter('socio', $socio)
            ->getQuery()
            ->getResult();

        return $this->render('entrega/listar.html.twig', [
            'entregas' => $entregas,
            'socio' => $socio,
        ]);
    }

    /**
     * @Route("/entregas/insertar", name="entregas_insertar")
     */
    public function insertarAction()
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $tipos = $em->createQueryBuilder()
            ->select('t')
            ->from('AppBundle:Tipo', 't')
            ->getQuery()
            ->getResult();

        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $amasadas = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Amasada', 'a')
            ->getQuery()
            ->getResult();

        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $fincas = $em->createQueryBuilder()
            ->select('f')
            ->from('AppBundle:Finca', 'f')
            ->getQuery()
            ->getResult();

        $entregas = [
            [0, "2017-03-28", "16:15", "16:20", 1500, 18, 0, null, 1, $tipos[0], $amasadas[0], $fincas[0]],
            [0, "2017-03-28", "16:20", "16:25", 500, 23, 10, "Muy sucia", 1, $tipos[1], $amasadas[2], $fincas[0]],
            [0, "2017-03-28", "16:25", "16:30", 200, 25, 0, null, 2, $tipos[1], $amasadas[2], $fincas[2]],
            [0, "2017-03-28", "16:30", "17:03", 1000, 22, 10, "Atasco de tolva", 3, $tipos[1], $amasadas[2], $fincas[1]],
            [0, "2017-03-28", "17:07", "17:20", 900, 18, 0, null, 3, $tipos[0], $amasadas[0], $fincas[2]]
        ];

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        foreach ($entregas as $item) {
            $entrega = new Entrega();
            $em->persist($entrega);
            $entrega
                ->setFecha($item[1])
                ->setHoraInicio($item[2])
                ->setHoraFin($item[3])
                ->setPeso($item[4])
                ->setRendimiento($item[5])
                ->setSancion($item[6])
                ->setObservaciones($item[7])
                ->setBascula($item[8])
                ->setTipo($item[9])
                ->setAmasada($item[10])
                ->setFinca($item[11]);

            $em->flush();
        }
        $mensaje = 'Entradas insertadas correctamente';

        return $this->render('entrega/operaciones.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}

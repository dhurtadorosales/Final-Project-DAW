<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Entrega;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Temporada;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\TemporadaActual;
use Symfony\Component\HttpFoundation\Request;


class EntregaController extends Controller
{
    /**
     * @Route("/entregas/listar/socio/{socio}", name="entregas_listar_socio")
     * @Route("/entregas/listar/socio/{socio}/{temporada}", name="entregas_listar_socio_temporada")
     * @Security("is_granted('ROLE_ENCARGADO') or user.getNif() == socio.getUsuario().getNif()")")
     */
    public function listarPorSocioAction(Request $request, Socio $socio, Temporada $temporada = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Si no recibe ninguna temporada se obtendrá la actual
        if (null === $temporada) {
            //Creamos una instancia del servicio
            $temporadaActual = new TemporadaActual($em);
            $temporada = $temporadaActual->temporadaActualAction();
        }

        $entregas = $em->getRepository('AppBundle:Entrega')
            ->getEntregasSocioTemporada($socio, $temporada);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entregas,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('entrega/listar.html.twig', [
            'entregas' => $entregas,
            'socio' => $socio,
            'temporada' => $temporada,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/entregas/listar/lote/{lote}", name="entregas_listar_lote")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or is_granted('ROLE_EMPLEADO') or is_granted('ROLE_SOCIO')")
     */
    public function listarEntregasLoteAction(Request $request, Lote $lote)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $entregas = $em->getRepository('AppBundle:Entrega')
            ->getEntregasLote($lote);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entregas,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('entrega/listarLote.html.twig', [
            'entregas' => $entregas,
            'lote' => $lote,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/entregas/detalle/{entrega}/{socio}", name="entregas_detalle")
     * @Security("is_granted('ROLE_ENCARGADO') or user.getNif() == socio.getUsuario().getNif()")")
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
     * @Route("/entregas/insertar", name="entregas_insertar", methods={"GET"})
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function insertarEntregasAction()
    {
        return $this->render('entrega/confirma.html.twig');
    }


    /**
     * @Route("/entregas/insertar", name="entregas_insertar_confirmar", methods={"POST"})
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function confirmarInsertarEntregasAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención de procedencias
        $procedencias = $em->getRepository('AppBundle:Procedencia')
            ->findAll();

        //Obtención de fincas
        $fincas = $em->getRepository('AppBundle:Finca')
            ->findAll();

        //Obtención de la temporada en vigor
        $temporadaActual = new TemporadaActual($em);
        $temporada = $temporadaActual->temporadaActualAction();

        //Obtención de los lotes esta temporada
        $lotes = $em->getRepository('AppBundle:Lote')
            ->getLotesTemporada($temporada);

        $entregas = [
            [0, "2017-03-28", "16:15", "16:20", 1500, 0.18, null, null, 1, $procedencias[0], null, $fincas[0], $temporada, $lotes[0]],
            [0, "2017-03-28", "16:20", "16:25", 500, 0.23, 0.15, "Muy sucia", 1, $procedencias[1], null, $fincas[0], $temporada, $lotes[1]],
            [0, "2017-03-28", "16:25", "16:30", 200, 0.25, null, null, 2, $procedencias[1], null, $fincas[2], $temporada, $lotes[1]],
            [0, "2017-03-28", "16:30", "17:03", 1000, 0.22, 0.15, "Atasco de tolva", 3, $procedencias[1], null, $fincas[1], $temporada, $lotes[1]],
            [0, "2017-03-28", "17:07", "17:20", 900, 0.18, null, null, 3, $procedencias[0], null, $fincas[2], $temporada, $lotes[0]]
        ];

        try {

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
                    ->setFinca($item[11])
                    ->setTemporada($item[12])
                    ->setLote($item[13]);

                //Obtención cantidad a sumar a la cantidad y stock del lote
                $cantidadLote = $entrega->getPeso() * $entrega->getRendimiento();

                $em->persist($entrega->getLote());

                //Sumamos la cantidad y el stock de aceite de la nueva entrega
                $entrega->getLote()->setCantidad($entrega->getLote()->getCantidad() + $cantidadLote);
                $entrega->getLote()->setStock($entrega->getLote()->getStock() + $cantidadLote);

                $em->flush();
            }

            $this->addFlash('estado', 'Entradas insertadas correctamente');
        } catch (UniqueConstraintViolationException $exception) {
            $this->addFlash('error', 'No se han podido insertar las entradas');
        }

        return $this->redirectToRoute('principal');
    }
}

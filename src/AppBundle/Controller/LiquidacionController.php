<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Liquidacion;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Temporada;
use AppBundle\Service\CalculoLiquidacion;
use Doctrine\ORM\EntityManager;
use Sasedev\MpdfBundle\Service\MpdfService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\TemporadaActual;
use Symfony\Component\HttpFoundation\Request;

class LiquidacionController extends Controller
{
    /**
     * @Route("/liquidaciones/listar", name="liquidaciones_listar")
     * @Route("/liquidaciones/listar/{temporada}", name="liquidaciones_listar_temporada")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function listarAction(Request $request, Temporada $temporada = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Si no recibe ninguna temporada se obtendrá la actual
        if (null === $temporada) {
            //Creamos una instancia del servicio
            $temporadaActual = new TemporadaActual($em);
            $temporada = $temporadaActual->temporadaActualAction();
        }

        //Obtención de las liquidaciones
        $liquidaciones = $em->getRepository('AppBundle:Liquidacion')
            ->getLiquidacionTemporada($temporada);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $liquidaciones,
            $request->query->getInt('page', 1), 4
        );

        return $this->render('liquidacion/listar.html.twig', [
            'liquidaciones' => $liquidaciones,
            'temporada' => $temporada,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/liquidaciones/detalle/{socio}/{temporada}", name="liquidaciones_detalle_temporada")
     * @Route("/liquidaciones/detalle/{socio}", name="liquidaciones_detalle")
     * @Security("has_role('ROLE_ADMINISTRADOR') or user.getNif() == socio.getUsuario().getNif()")
     */
    public function detalleAction(Socio $socio, Temporada $temporada = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Si no recibe ninguna temporada se obtendrá la actual
        if (null === $temporada) {
            //Creamos una instancia del servicio
            $temporadaActual = new TemporadaActual($em);
            $temporada = $temporadaActual->temporadaActualAction();
        }

        //Para el cálculo de la liquidación creamos un objeto del servicio
        $objeto = new CalculoLiquidacion($em);
        $calculo = $objeto->calculoLiquidacionAction($socio, $temporada);

        return $this->render('liquidacion/detalle.html.twig', [
            'socio' => $socio,
            'temporada' => $temporada,
            'liquidacion' => $calculo[0],
            'sumaEntregas' => $calculo[1],
            'sumaVentas' => $calculo[2],
            'pesoAceituna' => $calculo[3],
            'pesoAceite' => $calculo[4],
            'rendimientoMedio' => $calculo[5],
            'porcentajes' => $calculo[6],
            'sumaBonificacion' => $calculo[7],
            'precioLiquidacion' => $calculo[8]
        ]);
    }

    /**
     * @Route("/liquidaciones/temporadas/listar", name="liquidaciones_temporadas_listar")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or is_granted('ROLE_SOCIO')")
     */
    public function listarTemporadasAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $temporadas = $em->getRepository('AppBundle:Temporada')
            ->getTemporadas();

        return $this->render('liquidacion/principal.html.twig', [
            'temporadas' => $temporadas
        ]);
    }

    /**
     * @Route("/liquidaciones/imprimir/{socio}/{temporada}", name="liquidaciones_imprimir")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function pdfAction(Socio $socio, Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Para el cálculo de la liquidación creamos un objeto del servicio
        $objeto = new CalculoLiquidacion($em);
        $calculo = $objeto->calculoLiquidacionAction($socio, $temporada);

        $filename = 'liquidacion' . '_' . $socio->getId() . '_' . $temporada . '.pdf';
        $filename = str_replace('/', '_', $filename);

        /** @var MpdfService $mpdf */
        $mpdf = $this->get('sasedev_mpdf');
        $mpdf->init('', 'A4');
        $mpdf->getMpdf();
        $mpdf->useTwigTemplate('liquidacion/informe.html.twig', [
            'titulo' => $filename,
            'socio' => $socio,
            'temporada' => $temporada,
            'liquidacion' => $calculo[0],
            'sumaEntregas' => $calculo[1],
            'sumaVentas' => $calculo[2],
            'pesoAceituna' => $calculo[3],
            'pesoAceite' => $calculo[4],
            'rendimientoMedio' => $calculo[5],
            'porcentajes' => $calculo[6],
            'sumaBonificacion' => $calculo[7],
            'precioLiquidacion' => $calculo[8]
        ]);

        return $mpdf->generateInlineFileResponse($filename);
    }
}

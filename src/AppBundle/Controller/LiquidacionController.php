<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Linea;
use AppBundle\Entity\Liquidacion;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Porcentaje;
use AppBundle\Entity\Producto;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Venta;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Tests\Compiler\Lille;
use Symfony\Component\HttpFoundation\Request;

class LiquidacionController extends Controller
{
    /**
     * @Route("/liquidaciones/listar/{temporada}", name="liquidaciones_listar_temporada")
     */
    public function listarAction($temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $liquidacion = $em->getRepository('AppBundle:Liquidacion')
            ->getLiquidacionTemporada($temporada);

        return $this->render('liquidacion/listar.html.twig', [
            'liquidacion' => $liquidacion,
            'temporada' => $temporada
        ]);
    }

    /**
     * @Route("/liquidaciones/detalle/{socio}{temporada}", name="liquidaciones_detalle")
     */
    public function detalleAction(Socio $socio, $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $liquidacion = $em->getRepository('AppBundle:Liquidacion')
            ->getLiquidacionDetalle($socio, $temporada);

        return $this->render('liquidacion/detalle.html.twig', [
            'liquidacion' => $liquidacion,
            'socio' => $socio,
            'temporada' => $temporada
        ]);
    }

    /**
     * @Route("/liquidaciones/insertar", name="liquidaciones_insertar")
     */
    public function insertarLiquidacionAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención de la fecha actual
        $fecha = new \DateTime('now');
        $anio = $fecha->format('Y');

        //Como se liquidará al año siguiente le sumamos uno
        $anio = (int)$anio;
        $anio2 = $anio++;
        $temporada = $anio . "/" . $anio2;

        //Obtención de todos los socios
        $socios = $em->getRepository('AppBundle:Socio')
            ->findAll();

        //Obtención de los porcentajes vigentes
        $porcentajes = $em->getRepository('AppBundle:Porcentaje')
            ->findAll();

        //Creación de la liquidación de cada socio
        for ($i = 0; $i < sizeof($socios); $i++) {
            $liquidacion = new  Liquidacion();
            $em->persist($liquidacion);
            $liquidacion
                ->setTemporada($temporada)
                ->setBeneficio(0)
                ->setGasto(0)
                ->setIva($porcentajes[0]->getCantidad())
                ->setIvaReducido($porcentajes[1]->getCantidad())
                ->setRetencion($porcentajes[2]->getCantidad())
                ->setIndiceCorrector($porcentajes[3]->getCantidad())
                ->setSocio($socios[$i]);
        }
        $em->flush();

        $mensaje = 'Liquidacion insertada correctamente';

        return $this->render('liquidacion/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}

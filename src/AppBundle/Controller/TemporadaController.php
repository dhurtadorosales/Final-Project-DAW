<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Linea;
use AppBundle\Entity\Liquidacion;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Porcentaje;
use AppBundle\Entity\Producto;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Temporada;
use AppBundle\Entity\Venta;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Tests\Compiler\Lille;
use Symfony\Component\HttpFoundation\Request;

class TemporadaController extends Controller
{
    /**
     * @Route("/liquidaciones/listar/{temporada}", name="liquidaciones_listar_temporada")
     */
    public function listarAction(Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $liquidaciones = $em->getRepository('AppBundle:Temporada')
            ->getLiquidacionTemporada($temporada);

        return $this->render('temporada/listarTemporada.html.twig', [
            'liquidaciones' => $liquidaciones,
            'temporada' => $temporada
        ]);
    }


    /**
     * @Route("/temporada/comenzar", name="liquidaciones_insertar")
     */
    public function insertarLiquidacionAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtenemos la temporada aún vigente
        $temporadas = $resultados = $em->getRepository('AppBundle:Temporada')
            ->findAll();
        $temporada = $temporadas[sizeof($temporadas) - 1];

        //Si existe la temporada anterior
        if ($temporada != null) {
            //Obtención de las liquidaciones de la temporada aún vigente
            $liquidaciones = $em->getRepository('AppBundle:Liquidacion')
                ->getLiquidacionTemporada($temporada);

            //Añadimos fecha a la liquidación. Con lo cual está finalizada
            foreach ($liquidaciones as $item) {
                $em->persist($item);
                $item
                    ->setFecha(new \DateTime('now'));
            }
        }

        //Creación de una nueva temporada
        $nuevaTemporada = new Temporada();
        $em->persist($nuevaTemporada);

        //Obtencion de la fecha actual
        $fecha = new \DateTime('now');
        $fecha = $fecha->format('Y');
        $anio1 = (int)$fecha;
        $anio2 = $anio1++;
        $denominacion = $anio1 . "/" . $anio2;

        $nuevaTemporada
                ->setDenominacion($denominacion);

        //Creación de lotes con la temporada nueva
        $numLotes = 90;
        $cantidad = 0;

        for ($i = 0; $i < $numLotes; $i++) {
            $lote = new Lote();
            $em->persist($lote);
            $lote
                ->setTemporada($nuevaTemporada)
                ->setCantidad($cantidad)
                ->setStock($cantidad);
        }

        $em->flush();

        $mensaje = 'Liquidacion insertada correctamente';

        return $this->render('liquidacion/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}

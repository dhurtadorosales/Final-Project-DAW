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
     * @Route("/temporadas/listar", name="temporadas_listar")
     */
    public function listarAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $temporadas = $em->getRepository('AppBundle:Temporada')
            ->findAll();

        return $this->render('temporada/listarTemporada.html.twig', [
            'temporadas' => $temporadas
        ]);
    }


    /**
     * @Route("/temporadas/comenzar", name="temporadas_comenzar")
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
        $anio2 = $anio1 + 1;
        $denominacion = $anio1 . "/" . $anio2;

        $nuevaTemporada
                ->setDenominacion($denominacion);

        //Obtención de todos los socios
        $socios = $em->getRepository('AppBundle:Socio')
            ->findAll();

        //Obtención de los porcentajes vigentes
        $porcentajes = $em->getRepository('AppBundle:Porcentaje')
            ->findAll();

        //Creación de la nueva liquidación de cada socio
        foreach ($socios as $item) {
            $liquidacion = new  Liquidacion();
            $em->persist($liquidacion);
            $liquidacion
                ->setTemporada($nuevaTemporada)
                ->setBeneficio(0)
                ->setGasto(0)
                ->setIva($porcentajes[0]->getCantidad())
                ->setIvaReducido($porcentajes[1]->getCantidad())
                ->setRetencion($porcentajes[2]->getCantidad())
                ->setIndiceCorrector($porcentajes[3]->getCantidad())
                ->setSocio($item);
        }

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

        $mensaje = 'Temporada comenzada correctamente';

        return $this->render('temporada/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}

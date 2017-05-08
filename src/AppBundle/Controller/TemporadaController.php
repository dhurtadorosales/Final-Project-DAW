<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Liquidacion;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Temporada;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use AppBundle\Service\TemporadaActual;

class TemporadaController extends Controller
{
    /**
     * @Route("/temporadas/listar", name="temporadas_listar")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or is_granted('ROLE_SOCIO')")
     */
    public function listarAction()
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
     * @Route("/temporadas/comenzar", name="temporadas_comenzar_confirmar", methods={"POST"})
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function confirmarTemporadaAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtenemos la temporada aún vigente. Usamos el servicio
        $temporadaActual = new TemporadaActual($em);
        $temporada = $temporadaActual->temporadaActualAction();

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
        //$denominacion = '2018/2019';

        try {
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
                    ->setIva($porcentajes[0]->getCantidad())
                    ->setRetencion($porcentajes[2]->getCantidad())
                    ->setSocio($item)
                    ->setFecha(null);
            }

            //Creación de lotes con la temporada nueva
            $numLotes = 10;
            $cantidad = 0;

            for ($i = 1; $i <= $numLotes; $i++) {
                $lote = new Lote();
                $em->persist($lote);
                $lote
                    ->setNumero($i)
                    ->setTemporada($nuevaTemporada)
                    ->setCantidad($cantidad)
                    ->setStock($cantidad);
            }

            $em->flush();

            $this->addFlash('estado', 'Temporada comenzada');
        } catch (UniqueConstraintViolationException $exception) {
            $this->addFlash('error', 'Ya existe esta temporada');
        }

        return $this->redirectToRoute('principal');
    }
}

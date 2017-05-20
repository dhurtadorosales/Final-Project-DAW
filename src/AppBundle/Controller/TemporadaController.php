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

        //Obtención de los porcentajes vigentes
        $porcentajes = $em->getRepository('AppBundle:Porcentaje')
            ->findAll();

        //Si existe la temporada anterior
        if ($temporada != null) {
            //Obtención de las liquidaciones de la temporada aún vigente
            $liquidaciones = $em->getRepository('AppBundle:Liquidacion')
                ->getLiquidacionTemporada($temporada);

            //Añadimos fecha a la liquidación. Con lo cual está finalizada
            //Y se le asignan los porcentajes vigentes en este momento
            foreach ($liquidaciones as $item) {
                $em->persist($item);
                $item
                    ->setFecha(new \DateTime('now'))
                    ->setIva($porcentajes[1]->getCantidad())
                    ->setRetencion($porcentajes[2]->getCantidad());
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
        //$denominacion = $anio1 . "/" . $anio2;
        $denominacion = '2018/2019';

        try {
            $nuevaTemporada
                ->setDenominacion($denominacion);

            //Obtención de todos los socios dados de alta
            $socios = $em->getRepository('AppBundle:Socio')
                ->getSocios();

            //Obtención de los porcentajes vigentes
            $porcentajes = $em->getRepository('AppBundle:Porcentaje')
                ->findAll();

            //Creación de la nueva liquidación de cada socio
            foreach ($socios as $item) {
                $liquidacion = new  Liquidacion();
                $em->persist($liquidacion);
                $liquidacion
                    ->setTemporada($nuevaTemporada)
                    ->setIva($porcentajes[1]->getCantidad())
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

            //Si la temporada no es la auxiliar se envía un email a cada socio informando de que la liquidación está cerrada
            if ($temporada->getId() != 0) {
                foreach ($socios as $socio) {
                    $mensaje = \Swift_Message::newInstance()
                        ->setSubject('Liquidación temporada ' . $temporada)
                        ->setFrom($this->getParameter('mailer_user'))
                        ->setTo($socio->getUsuario()->getEmail())
                        ->setBody(
                            $this->renderView(
                                'default/email.html.twig', [
                                    'socio' => $socio,
                                    'temporada' => $temporada
                                ]
                            ),
                            'text/html'
                        );
                    $this->get('mailer')->send($mensaje);
                    //$this->addFlash('estado', 'Correo mandado correctamente');
                }
            }

            $this->addFlash('estado', 'Temporada comenzada');
        } catch (UniqueConstraintViolationException $exception) {
            $this->addFlash('error', 'Ya existe esta temporada');
        }

        return $this->redirectToRoute('principal');
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Aviso;
use AppBundle\Entity\Entrega;
use AppBundle\Entity\Fichero;
use AppBundle\Form\Type\FicheroType;
use AppBundle\Service\TemporadaActual;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FicheroController extends Controller
{
    /**
     * @Route("/fichero/subir", name="fichero_subir")
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function indexAction(Request $request)
    {
        date_default_timezone_set('UTC');
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $fichero = new Fichero();
        $em->persist($fichero);

        //Ejecución de formulario
        $form = $this->createForm(FicheroType::class, $fichero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                //Creación de los arrays que recogerán los datos
                $entregas = [[]];
                $entrega = [];

                //fichero guarda el xls subido
                /** @var UploadedFile $file */
                $file =$form['entregas']->getData();

                //Se genera un nombre único para el fichero antes de guardarlo y se obtiene su extensión
                $fileName = $file->getClientOriginalName();
                $extension = explode('.', $fileName);

                //Si la extensión del fichero es la correcta
                if ($extension[1] == 'xls') {

                    //Se mueve el fichero a la ruta donde se guardan los ficheros
                    $entregasDir = 'uploads/entregas';
                    $file->move($entregasDir, $fileName);
                    $fichero->setEntregas($entregasDir . '/' . $fileName);

                    //Creación de un objeto de la clase phpexcel con el fichero subido
                    $objetoXls = $this->get('phpexcel')->createPHPExcelObject($entregasDir . '/' . $fileName);

                    //Comprobamos si el fichero existe
                    $numeroFicheros = $em->getRepository('AppBundle:Fichero')
                        ->getNumeroFicherosNombre($entregasDir . '/' . $fileName);

                    //Si ya existe
                    if ($numeroFicheros >= 1) {
                        $this->addFlash('error', 'Este fichero ya existe');
                        return $this->redirectToRoute('fichero_subir');
                    } else {
                        //Se recorren las hojas
                        $hojas = $objetoXls->getWorksheetIterator();
                        foreach ($hojas as $hoja) {
                            //Se recorren las filas
                            $filas = $hoja->getRowIterator();
                            foreach ($filas as $fila) {
                                //Se recorren las columnas de cada fila
                                $celdas = $fila->getCellIterator();
                                $celdas->setIterateOnlyExistingCells(false);
                                $contador = 0;
                                foreach ($celdas as $celda) {
                                    $valor = $celda->getValue();
                                    if (!is_null($celda)) {
                                        if ($contador == 0) {
                                            $valor = date($format = 'Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($valor));
                                        }
                                        if ($contador == 1 || $contador == 2) {
                                            $valor = date($format = 'H:i', \PHPExcel_Shared_Date::ExcelToPHP($valor));
                                        }
                                        if ($contador == 3 || $contador == 7 || $contador == 8 || $contador == 9 || $contador == 10) {
                                            $valor = intval($valor);
                                        }
                                        if ($valor == 'null') {
                                            $valor = null;
                                        }
                                        array_push($entrega, $valor);
                                    }
                                    $contador++;
                                }
                                array_push($entregas, $entrega);
                                $entrega = [];
                            }
                        }

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

                        $entregasGuardar = [[]];
                        $entregaGuardar = [];

                        foreach ($entregas as $item) {
                            for ($i = 0; $i < sizeof($item); $i++) {
                                if ($i == 8) {
                                    if ($item[$i] == null) {
                                        $item[$i] = 0;
                                    }
                                    array_push($entregaGuardar, $procedencias[$item[$i]]);
                                } elseif ($i == 9) {
                                    if ($item[$i] == null) {
                                        $item[$i] = 0;
                                    }
                                    array_push($entregaGuardar, $fincas[$item[$i]]);
                                } elseif ($i == 10) {
                                    if ($item[$i] == null) {
                                        $item[$i] = 0;
                                    }
                                    array_push($entregaGuardar, $lotes[$item[$i]]);
                                } else {
                                    array_push($entregaGuardar, $item[$i]);
                                }
                            }
                            if ($entregaGuardar != []) {
                                array_push($entregasGuardar, $entregaGuardar);
                            }
                            $entregaGuardar = [];
                        }
                        unset($entregasGuardar[0]);
                        array_values($entregasGuardar);

                        foreach ($entregasGuardar as $item) {
                            $pesada = new Entrega();
                            $em->persist($pesada);
                            $pesada
                                ->setFecha(new \DateTime($item[0]))
                                ->setHoraInicio(new \DateTime($item[1]))
                                ->setHoraFin(new \DateTime($item[2]))
                                ->setPeso($item[3])
                                ->setRendimiento($item[4])
                                ->setSancion($item[5])
                                ->setObservaciones($item[6])
                                ->setBascula($item[7])
                                ->setProcedencia($item[8])
                                ->setFinca($item[9])
                                ->setLote($item[10])
                                ->setTemporada($temporada);

                            //Obtención cantidad a sumar a la cantidad y stock del lote
                            $cantidadLote = $pesada->getPeso() * $pesada->getRendimiento();

                            $em->persist($pesada->getLote());

                            //Sumamos la cantidad y el stock de aceite de la nueva entrega
                            $pesada->getLote()->setCantidad($pesada->getLote()->getCantidad() + $cantidadLote);
                            $pesada->getLote()->setStock($pesada->getLote()->getStock() + $cantidadLote);

                            $em->flush();
                        }

                        //Comprobación de avisos
                        $lotesTemporada = $em->getRepository('AppBundle:Lote')
                            ->getLotesTemporadaNoNulos($temporada);

                        //Comprobación de capacidad de lote
                        foreach ($lotesTemporada as $item) {
                            if ($item->getCantidad() >= 90000) {
                                $aviso = new Aviso();
                                $em->persist($aviso);
                                $aviso
                                    ->setDenominacion('¡Atención! El lote ' . $item . ' tiene más cantidad que su capacidad máxima.')
                                    ->setTemporada($temporada);
                                $em->flush();
                            }
                        }

                        //Comprobación de distinta procedencia de aceituna en un mismo lote
                        foreach ($lotesTemporada as $item) {
                            //Recorremos las entregas de cada lote
                            $tipoAceituna = $item->getEntregas()[0]->getProcedencia();
                            foreach ($item->getEntregas() as $itemEntrega) {
                                if ($itemEntrega->getProcedencia() != $tipoAceituna) {
                                    $aviso = new Aviso();
                                    $em->persist($aviso);
                                    $aviso
                                        ->setDenominacion('¡Atención! El lote ' . $item . ' contiene aceituna de vuelo y suelo mezclada.')
                                        ->setTemporada($temporada);
                                    $em->flush();
                                }
                            }
                        }

                        //Comprobación de aceite vertido en un lote ya analizado
                        foreach ($lotesTemporada as $item) {
                            if ($item->getAceite() != null) {
                                $aviso = new Aviso();
                                $em->persist($aviso);
                                $aviso
                                    ->setDenominacion('¡Atención! Se ha vertido aceite en el lote ' . $item . ' ya analizado.')
                                    ->setTemporada($temporada);
                                $em->flush();
                            }
                        }

                        $em->flush();
                        $this->addFlash('estado', 'Entradas insertadas correctamente');
                        return $this->redirectToRoute('principal');
                    }
                }
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'Error. Verifica el formato del fichero');
            }
        }

        return $this->render('fichero/form.html.twig', [
            'formulario' => $form->createView(),
        ]);
    }

}

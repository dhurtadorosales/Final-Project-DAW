<?php

namespace AppBundle\Controller;

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
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

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

                //Se genera un nombre único para el fichero antes de guardarlo
                $fileName = $file->getClientOriginalName();

                //Se mueve el fichero a la ruta donde se guardan los ficheros
                $entregasDir = 'uploads/entregas';
                $file->move($entregasDir, $fileName);
                $fichero->setEntregas($entregasDir.'/'.$fileName);

                //Creación de un objeto de la clase phpexcel con el fichero subido
                $objetoXls = $this->get('phpexcel')->createPHPExcelObject($entregasDir . '/'  . $fileName);

                //Se recorren las hojas
                $hojas = $objetoXls->getWorksheetIterator();
                foreach ($hojas as $hoja) {
                    //Se recorren las filas
                    $filas = $hoja->getRowIterator();
                    foreach ($filas as $fila) {
                        //echo '    Row number - ' , $fila->getRowIndex();
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

                /*$entregas = [
                    [0, "2017-03-28", "16:15", "16:20", 1500, 0.18, null, null, 1, $procedencias[0], null, $fincas[0], $temporada, $lotes[0]],
                    [0, "2017-03-28", "16:20", "16:25", 500, 0.23, 0.15, "Muy sucia", 1, $procedencias[1], null, $fincas[0], $temporada, $lotes[1]],
                    [0, "2017-03-28", "16:25", "16:30", 200, 0.25, null, null, 2, $procedencias[1], null, $fincas[2], $temporada, $lotes[1]],
                    [0, "2017-03-28", "16:30", "17:03", 1000, 0.22, 0.15, "Atasco de tolva", 3, $procedencias[1], null, $fincas[1], $temporada, $lotes[1]],
                    [0, "2017-03-28", "17:07", "17:20", 900, 0.18, null, null, 3, $procedencias[0], null, $fincas[2], $temporada, $lotes[0]]
                ];*/

                $entregasGuardar = [[]];
                $entregaGuardar = [];

                foreach ($entregas as $item) {
                    //dump($item);
                    for ($i = 0; $i < sizeof($item) ; $i++) {
                        if ($i == 8) {
                            if ($item[$i] == null) {
                                $item[$i] = 0;
                            }
                            //dump($procedencias[$item[$i]]);
                            array_push($entregaGuardar, $procedencias[$item[$i]]);
                        }
                        elseif ($i == 9) {
                            if ($item[$i] == null) {
                                $item[$i] = 0;
                            }
                            array_push($entregaGuardar, $fincas[$item[$i]]);
                        }
                        elseif ($i == 10) {
                            if ($item[$i] == null) {
                                $item[$i] = 0;
                            }
                            array_push($entregaGuardar, $lotes[$item[$i]]);
                        }
                        else {
                            array_push($entregaGuardar, $item[$i]);
                        }
                    }
                    //dump($entregasGuardar);
                    if ($entregaGuardar != []) {
                        array_push($entregasGuardar, $entregaGuardar);
                    }
                    //dump($entregaGuardar);
                    $entregaGuardar = [];
                }
                //unset($entregasGuardar[0]);
                //array_values($entregasGuardar);
                dump($entregasGuardar);
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

                $em->flush();
                $this->addFlash('estado', 'Entradas insertadas correctamente');
                return $this->redirectToRoute('principal');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se han podido insertar las entradas');
            }
        }

        return $this->render('fichero/form.html.twig', [
            'formulario' => $form->createView(),
        ]);
    }
}

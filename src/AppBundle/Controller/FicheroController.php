<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Fichero;
use AppBundle\Form\Type\FicheroType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FicheroController extends Controller
{
    /**
     * @Route("/subir/fichero", name="subir_fichero")
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function indexAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $fichero = new Fichero();
        $em->persist($fichero);

        //Ejecución de formulario
        $form = $this->createForm(FicheroType::class, $fichero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                //fichero guarda el xls subido
                /** @var UploadedFile $file */
                $file =$form['entregas']->getData();

                //Se genera un nombre único para el fichero antes de guardarlo
                $fileName = $file->getClientOriginalName();

                //Se mueve el fichero a la ruta donde se guardan los ficheros
                $entregasDir = 'uploads/entregas';
                $file->move($entregasDir, $fileName);
                $fichero->setEntregas($entregasDir.'/'.$fileName);

                $em->flush();
                $this->addFlash('estado', 'Precios guardados con éxito');
                return $this->redirectToRoute('principal');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los precios');
            }
        }

        return $this->render('aceite/form.html.twig', [
            'formulario' => $form->createView()
        ]);
    }
}

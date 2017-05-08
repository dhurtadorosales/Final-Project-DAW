<?php

namespace AppBundle\Controller;

use AppBundle\Form\Model\ListaPorcentajes;
use AppBundle\Form\Type\ListaPorcentajesType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PorcentajeController extends Controller
{
    /**
     * @Route("/porcentajes/modificar", name="porcentajes_modificar")
     * @Security("is_granted('ROLE_COMERCIAL')")
     */
    public function formPorcentajeAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Creación de un objeto de la clase ListaPorcentajes
        $lista = new ListaPorcentajes();

        //Obtención de todos los porcentajes
        $porcentajes = $em->getRepository('AppBundle:Porcentaje')
            ->findAll();

        //Añadimos los porcentajes a la lista de porcentajes
        foreach ($porcentajes as $porcentaje) {
            $lista->getPorcentajes()->add($porcentaje);
        }

        //Ejecución de formulario
        $form = $this->createForm(ListaPorcentajesType::class, $lista);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('principal');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }

        return $this->render('porcentaje/form.html.twig', [
            'lista' => $lista,
            'formulario' => $form->createView()
        ]);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Envase;
use AppBundle\Form\Type\EnvaseType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EnvaseController extends Controller
{
    /**
     * @Route("/envases/nuevo", name="envases_nuevo")
     * @Security("is_granted('ROLE_COMERCIAL')")
     */
    public function formEnvaseAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //Creación de un nuevo envase
        $envase = new Envase();
        $em->persist($envase);

        $form = $this->createForm(EnvaseType::class, $envase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Envase creado con éxito');
                return $this->redirectToRoute('productos_listar');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido crear el envase');
            }
        }

        return $this->render('envase/form.html.twig', [
            'envase' => $envase,
            'formulario' => $form->createView()
        ]);
    }
}

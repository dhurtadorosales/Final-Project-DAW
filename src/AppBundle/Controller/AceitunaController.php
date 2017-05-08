<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Aceite;
use AppBundle\Entity\Aceituna;
use AppBundle\Form\Model\ListaAceites;
use AppBundle\Form\Type\AceiteNuevoType;
use AppBundle\Form\Type\AceitunaType;
use AppBundle\Form\Type\ListaAceitesType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AceitunaController extends Controller
{
    /**
     * @Route("/aceituna/nueva", name="aceituna_nueva")
     * @Security("is_granted('ROLE_COMERCIAL')")
     */
    public function formNuevaAceitunaAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Creación de un nuevo aceite
        $aceituna = new Aceituna();
        $em->persist($aceituna);

        //Ejecución de formulario
        $form = $this->createForm(AceitunaType::class, $aceituna);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Variedad de aceituna guardada con éxito');
                return $this->redirectToRoute('principal');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se ha podido guardar la variedad de aceituna');
            }
        }

        return $this->render('aceituna/form.html.twig', [
            'aceituna' => $aceituna,
            'formulario' => $form->createView()
        ]);
    }
}

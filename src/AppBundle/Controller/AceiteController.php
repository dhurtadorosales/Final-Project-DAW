<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Aceite;
use AppBundle\Entity\Lote;
use AppBundle\Form\Model\ListaAceites;
use AppBundle\Form\Type\AceiteNuevoType;
use AppBundle\Form\Type\ListaAceitesType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AceiteController extends Controller
{
    /**
     * @Route("/aceite/principal", name="aceite_principal")
     * @Security("is_granted('ROLE_COMERCIAL')")
     */
    public function principalAceiteAction()
    {
        return $this->render('aceite/principal.html.twig');
    }

    /**
     * @Route("/aceite/nuevo", name="aceite_nuevo")
     * @Security("is_granted('ROLE_COMERCIAL')")
     */
    public function formNuevoAceiteAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Creación de un nuevo aceite
        $aceite = new Aceite();
        $em->persist($aceite);

        //Ejecución de formulario
        $form = $this->createForm(AceiteNuevoType::class, $aceite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                //Obtención de la primera temporada. Ojo, es un array
                $temporadaAuxiliar = $em->getRepository('AppBundle:Temporada')
                    ->getTemporadaAuxiliar();

                //Se crea un nuevo lote auxiliar perteneciente a la temporada auxiliar y se le asigna el aceite creado
                $lote = new Lote();
                $em->persist($lote);
                $lote
                    ->setNumero(0)
                    ->setTemporada($temporadaAuxiliar[0])
                    ->setCantidad(0)
                    ->setStock(0)
                    ->setAceite($aceite);

                $em->flush();
                $this->addFlash('estado', 'Aceite guardado con éxito');
                return $this->redirectToRoute('aceite_principal');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se ha podido guardar el aceite');
            }
        }

        return $this->render('aceite/formNuevoAceite.html.twig', [
            'aceite' => $aceite,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/aceite/modificar", name="aceite_modificar")
     * @Security("is_granted('ROLE_COMERCIAL')")
     */
    public function formModificarAceiteAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Creación de un objeto de la clase ListaAceites
        $lista = new ListaAceites();

        //Obtención de todos los tipos de aceite
        $aceites = $em->getRepository('AppBundle:Aceite')
            ->findAll();

        //Añadimos los aceites a la lista de aceites
        foreach ($aceites as $aceite) {
            $lista->getAceites()->add($aceite);
        }

        //Ejecución de formulario
        $form = $this->createForm(ListaAceitesType::class, $lista);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Precios guardados con éxito');
                return $this->redirectToRoute('aceite_principal');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los precios');
            }
        }

        return $this->render('aceite/form.html.twig', [
            'lista' => $lista,
            'formulario' => $form->createView()
        ]);
    }
}

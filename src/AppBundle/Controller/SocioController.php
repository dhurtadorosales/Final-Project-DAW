<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Liquidacion;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\SocioType;
use AppBundle\Service\TemporadaActual;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class SocioController extends Controller
{
    /**
     * @Route("/socios/listar", name="socios_listar")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or is_granted('ROLE_ENCARGADO')")
     */
    public function listarAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $socios = $em->getRepository('AppBundle:Socio')
            ->getSocios();

        //Variable auxiliar
        $baja = false;

        return $this->render('socio/listar.html.twig', [
            'socios' => $socios,
            'baja' => $baja
        ]);
    }

    /**
     * @Route("/socios/nuevo", name="socios_nuevo")
     * @Route("/socios/modificar/{socio}", name="socios_modificar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function formClienteAction(Request $request, Socio $socio = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $em2 = $this->getDoctrine()->getManager();
        $em3 = $this->getDoctrine()->getManager();

        //Obtenemos la fecha actual
        $fecha = new \DateTime('now');

        //Obtención de la temporada actual
        $temporadaActual = new TemporadaActual($em);
        $temporada = $temporadaActual->temporadaActualAction();

        if (null == $socio) {
            //Nuevo socio
            $socio = new Socio();
            $em->persist($socio);

            //Nuevo usuario que debe ser asignado al nuevo socio
            $usuario = new Usuario();
            $socio->setUsuario($usuario);
            $em2->persist($usuario);

            $form = $this->createForm(SocioType::class, $socio);
            $form->handleRequest($request);

            //Si es válido
            if ($form->isSubmitted() && $form->isValid()) {
                try {
                    //Asignación fecha de alta y activo
                    $socio
                        ->setFechaAlta($fecha)
                        ->setActivo(true);

                    //Asignación de la clave. Será la misma que su nif
                    $socio
                        ->getUsuario()->setClave($form['nif']->getData());

                    //Crear la liquidación del socio
                    $liquidacion = new  Liquidacion();
                    $em3->persist($liquidacion);
                    $liquidacion
                        ->setTemporada($temporada)
                        ->setFecha($fecha)
                        ->setIva(0.1)
                        ->setRetencion(0.02)
                        ->setSocio($socio);
                    $em->flush();
                   // $em2->flush();
                    //$em3->flush();
                    $this->addFlash('estado', 'Socio guardado con éxito');
                    return $this->redirectToRoute('socios_listar');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'No se ha podido guardar el socio');
                }
            }
        }
        else {
            $form = $this->createForm(SocioType::class, $socio);
            $form->handleRequest($request);

            //Si es válido
            if ($form->isSubmitted() && $form->isValid()) {
                try {
                    $em->flush();
                    $this->addFlash('estado', 'Socio guardado con éxito');
                    return $this->redirectToRoute('socios_listar');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'No se ha podido guardar el socio');
                }
            }
        }

        $socio = false;

        return $this->render('socio/form.html.twig', [
            'socio' => $socio,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/socios/eliminar/{socio}", name="confirmar_socios_eliminar", methods={"POST"})
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function confirmarBorradoAction(Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $em->persist($socio);
        try {
            //Obtenemos el usuario correspondiente al socio
            $usuario = $socio->getUsuario();
            $em->persist($usuario);

            //Desactivamos al socio y al usuario si no es el administrador
            if ($usuario->getAdministrador() == true) {
                $this->addFlash('error', 'No se puede dar de baja a este usuario ya que es el administrador');
            }
            else {
                //Generación de una clave aleatoria
                $aleatorio = random_int(0, 1000000);
                $clave = $this->get('security.password_encoder')
                    ->encodePassword($usuario, $aleatorio);

                $socio
                    ->setActivo(false)
                    ->setFechaBaja(new \DateTime('now'));
                $usuario
                    ->setActivo(false)
                    ->setClave($clave);

                $em->flush();

                //Obtenemos las fincas de las que era arrendatario
                $fincasArrendatario = $em->getRepository('AppBundle:Finca')
                    ->getFincasPorArrendatario($socio);
                $em->persist($fincasArrendatario);

                foreach ($fincasArrendatario as $item) {
                    $item->setActiva(true);
                }
                $em->flush();

                $this->addFlash('estado', 'Socio eliminado con éxito');
            }
        }
        catch(Exception $e) {
            $this->addFlash('error', 'No se ha podido eliminar el socio');
        }

        return $this->redirectToRoute('socios_listar');
    }

    /**
     * @Route("/socios/listar/baja", name="socios_listar_baja")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function listarBajaAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtenemos los socios desactivos
        $socios = $em->getRepository('AppBundle:Socio')
            ->getSociosBaja();

        //Variable auxiliar
        $baja = true;

        return $this->render('socio/listar.html.twig', [
            'socios' => $socios,
            'baja' => $baja
        ]);
    }

    /**
     * @Route("/socios/reactivar/{socio}", name="socios_reactivar")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function reactivarAction(Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Activación del socio con fecha de alta hoy y con su dni como clave
        $nif = $socio->getUsuario()->getNif();
        $clave = $this->get('security.password_encoder')
            ->encodePassword($socio, $nif);

        $socio
            ->setActivo(true)
            ->setFechaAlta(new \DateTime('now'))
            ->getUsuario()->setClave($clave);
        $em->persist($socio);
        $em->flush();

        //Obtenemos las fincas de las que era propietario
        $fincasPropietario = $em->getRepository('AppBundle:Finca')
            ->getFincasPorPropietario($socio);
        $em->persist($fincasPropietario);

        //Activamos las fincas
        foreach ($fincasPropietario as $item) {
            $item->setActiva(true);
        }
        $em->flush();

        //Obtenemos las fincas de las que era arrendatario
        $fincasArrendatario = $em->getRepository('AppBundle:Finca')
            ->getFincasPorArrendatario($socio);
        $em->persist($fincasArrendatario);

        foreach ($fincasArrendatario as $item) {
            $item->setActiva(true);
        }
        $em->flush();

        //Obtención de todos los socios activos
        $socios = $em->getRepository('AppBundle:Socio')
            ->getSocios();

        //Variable auxiliar
        $baja = false;

        return $this->render('socio/listar.html.twig', [
            'socios' => $socios,
            'baja' => $baja
        ]);
    }

    /**
     * @Route("/socios/pass/{socio}", name="socios_pass")
     * @Security("is_granted('ROLE_ADMINISTRADOR')")
     */
    public function passAction(Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        try {
            //Establecimiento de la contraseña con su nif
            $usuario = $socio->getUsuario();
            $nif = $usuario->getNif();
            $clave = $this->get('security.password_encoder')
                ->encodePassword($usuario, $nif);
            $socio
                ->getUsuario()->setClave($clave);
            $em->persist($socio);

            $this->addFlash('estado', 'Contraseña reestablecida con éxito');
            $em->flush();
        }
        catch(Exception $e) {
            $this->addFlash('error', 'No se ha podido reestablecer la contraseña');
        }

        //Obtención de todos los socios activos
        $socios = $em->getRepository('AppBundle:Socio')
            ->getSocios();

        //Variable auxiliar
        $baja = false;

        return $this->render('socio/listar.html.twig', [
            'socios' => $socios,
            'baja' => $baja
        ]);
    }
}

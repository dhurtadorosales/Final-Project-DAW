<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Aceite;
use AppBundle\Entity\Aceituna;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\Envase;
use AppBundle\Entity\Finca;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Porcentaje;
use AppBundle\Entity\Procedencia;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Tipo;
use AppBundle\Entity\Usuario;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Tests\Fixtures\ContainerAwareFixture;


class DatosIniciales extends ContainerAwareFixture implements FixtureInterface
{

    /**
     * @var ContainerInterface
     */
    public $container;

    public function load(ObjectManager $manager)
    {
        //Aceite
        $aceites = [
            [0, "Aceite Virgen Extra", 0.916, 2.98],
            [0, "Aceite Virgen", 0.916, 2.84],
            [0, "Aceite Lampante", 0.916, 2.75]
        ];

        foreach ($aceites as $item) {
            $aceite = new Aceite();
            $aceite
                ->setDenominacion($item[1])
                ->setDensidadKgLitro($item[2])
                ->setPrecioKg($item[3]);

            $manager->persist($aceite);
        }

        //Aceituna
        $variedades = [
            [0, "Alberquina"],
            [0, "Gordal"],
            [0, "Hojiblanca"],
            [0, "Lechín"],
            [0, "Picual"],
        ];
        $variedades2 = [];

        foreach ($variedades as $item) {
            $variedad = new Aceituna();
            $variedad
                ->setDenominacion($item[1]);

            $manager->persist($variedad);
            array_push($variedades2, $variedad);
        }

        //Cliente
        $clientes = [
            [0, "A23548796", "Koipe, S.A.", "", "Ctra/ Arjona", "s/n", "", "", "", "", "24740", "Andújar", "Jaén", "953510065", "atencion.cliente@koipe.com", 0.10],
            [0, "A23548756", "Carbonell, S.A.", "", "C/ Marie Curie", "20", "", "", "", "", "28521", "Rivas Vaciamacrid", "Madrid", "902202107", "atencion.cliente@carbonell.com", 0.15],
            [0, "B41584732", "Grupo Ybarra, S.L.", "", "Ctra/ Isla Menorca", "s/n", "", "", "", "", "41703", "Dos Hermanas", "Sevilla", "902014555", "consumidor@grupoybarra.com", 0.10],
            [0, "A23846985", "Coosur, S.A.", "", "Ctra/ La Carolina", "s/n", "", "", "", "", "23220", "Vilches", "Jaén", "953631165", "info@coosur.com", 0]
        ];

        foreach ($clientes as $item) {
            $cliente = new Cliente();
            $cliente
                ->setNif($item[1])
                ->setNombre($item[2])
                ->setApellidos($item[3])
                ->setCalle($item[4])
                ->setNumero($item[5])
                ->setBloque($item[6])
                ->setEscalera($item[7])
                ->setPiso($item[8])
                ->setLetra($item[9])
                ->setCodigoPostal($item[10])
                ->setLocalidad($item[11])
                ->setProvincia($item[12])
                ->setTelefono($item[13])
                ->setEmail($item[14])
                ->setDescuentoPersonalizado($item[15]);

            $manager->persist($cliente);
        }

        //Socio
        $socios = [
            [0, "75111567F", "Diego", "Hurtado Rosales", "C/ España", "23", "", "", "", "", "23320", "Torreperogil", "Jaén", "651378790", "dhurtadorosales@gmail.com", "2017-03-27", true, null],
            [0, "26354843H", "Valentín", "González Molina", "C/ Cervantes", "9", "", "", "", "", "23700", "Linares", "Jaén", "625782462", null, "2017-03-27", true, null],
            [0, "29478215Z", "Luis", "López Martínez", "C/ Rafael Alberti", "15", "", "", "2", "B", "23700", "Linares", "Jaén", "614783565", null, "2017-03-27", true, null],
        ];
        $socios2 = [];

        foreach ($socios as $item) {
            $socio = new Socio();
            $socio
                ->setNif($item[1])
                ->setNombre($item[2])
                ->setApellidos($item[3])
                ->setCalle($item[4])
                ->setNumero($item[5])
                ->setBloque($item[6])
                ->setEscalera($item[7])
                ->setPiso($item[8])
                ->setLetra($item[9])
                ->setCodigoPostal($item[10])
                ->setLocalidad($item[11])
                ->setProvincia($item[12])
                ->setTelefono($item[13])
                ->setEmail($item[14])
                ->setFechaAlta(new \DateTime($item[15]))
                ->setActivo($item[16]);

            $manager->persist($socio);
            array_push($socios2, $socio);
        }

        //Finca
        $fincas = [
            [0, "Fontarrón", "13", "077", "A", "018", "00039", "0000", "FP", 200, true, 0.30, 0.70, $variedades2[4], $socios2[0], $socios2[1]],
            [0, "Fuente del Ciervo", "13", "077", "A", "018", "00040", "0001", "FP", 300, true, 1, 0, $variedades2[4], $socios2[0], null],
            [0, "Montesina", "13", "077", "A", "018", "00041", "0002", "FP", 600, true, 1, 0, $variedades2[4], $socios2[2], null]
        ];

        foreach ($fincas as $item) {
            $finca = new Finca();
            $finca
                ->setDenominacion($item[1])
                ->setProvincia($item[2])
                ->setMunicipio($item[3])
                ->setSector($item[4])
                ->setPoligono($item[5])
                ->setParcela($item[6])
                ->setIdInmueble($item[7])
                ->setCaracterControl($item[8])
                ->setNumPlantas($item[9])
                ->setRegadio($item[10])
                ->setPartPropietario($item[11])
                ->setPartArrend($item[12])
                ->setVariedad($item[13])
                ->setPropietario($item[14])
                ->setArrendatario($item[15]);

            $manager->persist($finca);
        }

        //Procedencia
        $procedencias = [
            [0, "vuelo", 0.05],
            [0, "suelo", 0.0]
        ];

        foreach ($procedencias as $item) {
            $procedencia = new Procedencia();
            $procedencia
                ->setDenominacion($item[1])
                ->setBonificacion($item[2]);

            $manager->persist($procedencia);
        }

        //Procedencia
        $porcentajes = [
            [0, "iva", 0.21],
            [0, "iva reducido", 0.10],
            [0, "retencion", 0.02],
            [0, "índice corrector", 0.02]
        ];

        foreach ($porcentajes as $item) {
            $porcentaje = new Porcentaje();
            $porcentaje
                ->setDenominacion($item[1])
                ->setCantidad($item[2]);

            $manager->persist($porcentaje);
        }

        //Envase
        $envases = [
            [0, "granel", 0.0],
            [0, "botella pvc 1L", 0.15],
            [0, "bidón pvc 5L", 0.10],
            [0, "botella vidrio 1L", 0.20],
        ];

        foreach ($envases as $item) {
            $envase = new Envase();
            $envase
                ->setDenominacion($item[1])
                ->setIncremento($item[2]);

            $manager->persist($envase);
        }

        //Administrador
        $usuario = new Usuario();

        if ($usuario instanceof UserInterface) {
            $usuario
                ->setNif('75111567F')
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, 'administrador'))
                ->setAdministrador(true)
                ->setEmpleado(true)
                ->setComercial(true)
                ->setDependiente(false)
                ->setEncargado(false)
                ->setSocio(true)
                ->setCliente(false);

            $manager->persist($usuario);
        }

        //Comercial 2
        $usuario = new Usuario();

        if ($usuario instanceof UserInterface) {
            $usuario
                ->setNif('2698364J')
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, '2698364J'))
                ->setAdministrador(false)
                ->setEmpleado(true)
                ->setComercial(true)
                ->setDependiente(false)
                ->setEncargado(false)
                ->setSocio(false)
                ->setCliente(false);

            $manager->persist($usuario);
        }

        //Dependiente
        $usuario = new Usuario();

        if ($usuario instanceof UserInterface) {
            $usuario
                ->setNif('26471698H')
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, '26471698H'))
                ->setAdministrador(false)
                ->setEmpleado(true)
                ->setComercial(false)
                ->setDependiente(true)
                ->setEncargado(false)
                ->setSocio(false)
                ->setCliente(false);

            $manager->persist($usuario);
        }

        //Encargado
        $usuario = new Usuario();

        if ($usuario instanceof UserInterface) {
            $usuario
                ->setNif('26456123A')
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, '26456123A'))
                ->setAdministrador(false)
                ->setEmpleado(true)
                ->setComercial(false)
                ->setDependiente(false)
                ->setEncargado(true)
                ->setSocio(false)
                ->setCliente(false);

            $manager->persist($usuario);
        }

        //Socio 2
        $usuario = new Usuario();

        if ($usuario instanceof UserInterface) {
            $usuario
                ->setNif('26354843H')
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, '26354843H'))
                ->setAdministrador(false)
                ->setEmpleado(false)
                ->setComercial(false)
                ->setDependiente(false)
                ->setEncargado(false)
                ->setSocio(true)
                ->setCliente(false);

            $manager->persist($usuario);
        }

        //Socio 3
        $usuario = new Usuario();

        if ($usuario instanceof UserInterface) {
            $usuario
                ->setNif('29478215Z')
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, '29478215Z'))
                ->setAdministrador(false)
                ->setEmpleado(false)
                ->setComercial(false)
                ->setDependiente(false)
                ->setEncargado(false)
                ->setSocio(true)
                ->setCliente(false);

            $manager->persist($usuario);
        }

        //Cliente 1
        $usuario = new Usuario();

        if ($usuario instanceof UserInterface) {
            $usuario
                ->setNif('A23548796')
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, 'A23548796'))
                ->setAdministrador(false)
                ->setEmpleado(false)
                ->setComercial(false)
                ->setDependiente(false)
                ->setEncargado(false)
                ->setSocio(false)
                ->setCliente(true);

            $manager->persist($usuario);
        }

        $manager->flush();

        //Cliente 2
        $usuario = new Usuario();

        if ($usuario instanceof UserInterface) {
            $usuario
                ->setNif('A23548756')
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, 'A23548756'))
                ->setAdministrador(false)
                ->setEmpleado(false)
                ->setComercial(false)
                ->setDependiente(false)
                ->setEncargado(false)
                ->setSocio(false)
                ->setCliente(true);

            $manager->persist($usuario);
        }

        $manager->flush();

        //Cliente 3
        $usuario = new Usuario();

        if ($usuario instanceof UserInterface) {
            $usuario
                ->setNif('B41584732')
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, 'B41584732'))
                ->setAdministrador(false)
                ->setEmpleado(false)
                ->setComercial(false)
                ->setDependiente(false)
                ->setEncargado(false)
                ->setSocio(false)
                ->setCliente(true);

            $manager->persist($usuario);
        }

        $manager->flush();

        //Cliente 4
        $usuario = new Usuario();

        if ($usuario instanceof UserInterface) {
            $usuario
                ->setNif('A23846985')
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, 'A23846985'))
                ->setAdministrador(false)
                ->setEmpleado(false)
                ->setComercial(false)
                ->setDependiente(false)
                ->setEncargado(false)
                ->setSocio(false)
                ->setCliente(true);

            $manager->persist($usuario);
        }

        $manager->flush();
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
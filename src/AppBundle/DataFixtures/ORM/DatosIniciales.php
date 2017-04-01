<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Aceite;
use AppBundle\Entity\Aceituna;
use AppBundle\Entity\Amasada;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\Deposito;
use AppBundle\Entity\Entrega;
use AppBundle\Entity\Finca;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Tipo;
use AppBundle\Entity\Usuario;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
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
            ["Aceite Virgen Extra", 2.98],
            ["Aceite Virgen", 2.84],
            ["Aceite Lampante", 2.75]
        ];

        foreach ($aceites as $item) {
            $aceite = new Aceite();
            $aceite
                ->setDenominacion($item[1])
                ->setPrecio($item[2]);

            $manager->persist($aceite);
        }

        //Aceituna
        $variedades = [
            ["Alberquina"],
            ["Gordal"],
            ["Hojiblanca"],
            ["Lechín"],
            ["Picual"],
        ];

        foreach ($variedades as $item) {
            $variedad = new Aceituna();
            $variedad
                ->setDenominacion($item[1]);

            $manager->persist($variedad);
        }

        //Cliente
        $clientes = [
            ["A23548796", "Koipe, S.A.", "", "Ctra/ Arjona", "s/n", "", "", "", "", "24740", "Andújar", "Jaén", "953510065", "atencion.cliente@koipe.com", 10],
            ["A23548756", "Carbonell, S.A.", "", "C/ Marie Curie", "20", "", "", "", "", "28521", "Rivas Vaciamacrid", "Madrid", "902202107", "atencion.cliente@carbonell.com", 15],
            ["B41584732", "Grupo Ybarra, S.L.", "", "Ctra/ Isla Menorca", "s/n", "", "", "", "", "41703", "Dos Hermanas", "Sevilla", "902014555", "consumidor@grupoybarra.com", 10],
            ["A23846985", "Coosur, S.A.", "", "Ctra/ La Carolina", "s/n", "", "", "", "", "23220", "Vilches", "Jaén", "953631165", "info@coosur.com", 0]
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
                ->setDescuento(15);

            $manager->persist($cliente);
        }

        //Deposito
        $numDepositos = 90;
        $capacidad = 50000;
        $contenidoInicial = 0;

        for ($i = 0; $i < $numDepositos; $i++) {
            $deposito = new Deposito();
            $deposito
                ->setCapacidad($capacidad)
                ->setContenido($contenidoInicial);

            $manager->persist($deposito);
        }

        //Finca
        $fincas = [
            ["Fontarrón", "13", "077", "A", "018", "00039", "0000", "FP", 200, true, 30, 70, 5, 1, 2],
            ["Fuente del Ciervo", "13", "077", "A", "018", "00040", "0001", "FP", 300, true, 100, 0, 5, 1, null],
            ["Montesina", "13", "077", "A", "018", "00041", "0002", "FP", 600, true, 100, 0, 5, 3, null]
        ];

        foreach ($fincas as $item) {
            $finca = new Finca();
            $finca
                ->setDenominacion($item[1])
                ->setProvincia($item[2])
                ->setDenominacion($item[3])
                ->setMunicipio($item[4])
                ->setSector($item[5])
                ->setPoligono($item[6])
                ->setParcela($item[7])
                ->setIdInmueble($item[8])
                ->setCaracterControl($item[9])
                ->setNumPlantas($item[10])
                ->setRegadio($item[11])
                ->setPartPropietario($item[12])
                ->setPartArrend($item[13])
                ->setVariedad($item[14])
                ->setPropietario($item[15])
                ->setArrendatario($item[16]);

            $manager->persist($finca);
        }

        //Socio
        $socios = [
            ["75111567F", "Diego", "Hurtado Rosales", "C/ España", "23", "", "", "", "", "23320", "Torreperogil", "Jaén", "651378790", "dhurtadorosales@gmail.com", "2017-03-27", true, null],
            ["26354843H", "Valentín", "González Molina", "C/ Cervantes", "9", "", "", "", "", "23700", "Linares", "Jaén", "625782462", null, "2017-03-27", true, null],
            ["29478215Z", "Luis", "López Martínez", "C/ Rafael Alberti", "15", "", "", "2", "B", "23700", "Linares", "Jaén", "614783565", null, "2017-03-27", true, null],
        ];

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
                ->setFechaAlta($item[15])
                ->setActivo($item[16]);

            $manager->persist($socio);
        }

        //Tipo
        $tipos = [
            ["vuelo", 5],
            ["suelo", 0.0]
        ];

        foreach ($tipos as $item) {
            $tipo = new Tipo();
            $tipo
                ->setDenominacion($item[1])
                ->setBonificacion($item[2]);

            $manager->persist($tipo);
        }


        /////////////////////////////////


        //Entrega
        $entregas = [
            ["2017-03-28", "16:15", "16:20", 1500, 18, 0, null, 1, 1, 1],
            ["2017-03-28", "16:20", "16:25", 500, 23, 10, "Muy sucia", 1, 2, 3, 1],
            ["2017-03-28", "16:25", "16:30", 200, 25, 0, null, 2, 2, 3, 3],
            ["2017-03-28", "16:30", "17:03", 1000, 22, 10, "Atasco de tolva", 3, 2, 3, 2],
            ["2017-03-28", "17:07", "17:20", 900, 18, 0, null, 3, 1, 3]
        ];

        foreach ($entregas as $item) {
            $entrega = new Entrega();
            $entrega
                ->setFecha($item[1])
                ->setHoraInicio($item[2])
                ->setHoraFin($item[3])
                ->setPeso($item[4])
                ->setRendimiento($item[5])
                ->setSancion($item[6])
                ->setObservaciones($item[7])
                ->setBascula($item[8])
                ->setTipo($item[9])
                ->setAmasada($item[10])
                ->setFinca($item[11]);

            $manager->persist($entrega);
        }


        ////////////////////////////////

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
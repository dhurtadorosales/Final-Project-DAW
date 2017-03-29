<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Aceite;
use AppBundle\Entity\Aceituna;
use AppBundle\Entity\Bascula;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\Deposito;
use AppBundle\Entity\Finca;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Tipo;
use AppBundle\Entity\Usuario;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Tests\Fixtures\ContainerAwareFixture;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class DatosIniciales extends ContainerAwareFixture
{

    public function load(ObjectManager $manager)
    {
        //Aceite
        $aceites = [
            ["aceite virgen extra", 0.0, 0.0, 0.0],
            ["aceite virgen", 0.0, 0.0, 0.0],
            ["aceite lampante", 0.0, 0.0, 0.0]
        ];

        foreach ($aceites as $item) {
            $aceite = new Aceite();
            $aceite->setDenominacion($item[1])
                ->setPrecio($item[2])
                ->setDescuentoSocios($item[3])
                ->setDescuentoEmpleados($item[4]);

            $manager->persist($aceite);
        }

        //Aceituna
        $variedades = [
            ["alberquina", 0.0],
            ["gordal", 0.0],
            ["hojiblanca", 0.0],
            ["lechín", 0.0],
            ["picual", 0.0],
            ["picudo", 0.0]
        ];

        foreach ($variedades as $item) {
            $variedad = new Aceituna();
            $variedad->setDenominacion($item[1])
                ->setPrecio($item[2]);

            $manager->persist($variedad);
        }

        //Bascula
        $numBasculas = 10;

        for ($i = 0; $i < $numBasculas; $i++) {
            $bascula = new Bascula();

            $manager->persist($bascula);
        }

        //Cliente
        $clientes = [
            ["A23548796", "Koipe, S.A.", "", "Ctra/ Arjona", "s/n", "", "", "", "", "24740", "Andújar", "Jaén", "953510065", "atencion.cliente@koipe.com"],
            ["A23548756", "Carbonell, S.A.", "", "C/ Marie Curie", "20", "", "", "", "", "28521", "Rivas Vaciamacrid", "Madrid", "902202107", "atencion.cliente@carbonell.com"],
            ["B41584732", "Grupo Ybarra, S.L.", "", "Ctra/ Isla Menorca", "s/n", "", "", "", "", "41703", "Dos Hermanas", "Sevilla", "902014555", "consumidor@grupoybarra.com"],
            ["A23846985", "Coosur, S.A.", "", "Ctra/ La Carolina", "s/n", "", "", "", "", "23220", "Vilches", "Jaén", "953631165", "info@coosur.com"]
        ];

        foreach ($clientes as $item) {
            $cliente = new Cliente();
            $cliente->setNif($item[1])
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
                ->setEmail($item[14]);

            $manager->persist($cliente);
        }

        //Deposito
        $numDepositos = 20;
        $capacidad = 50000;
        $contenidoInicial = 0;
        $tipoAceite = "vacío";

        for ($i = 0; $i < $numDepositos; $i++) {
            $deposito = new Deposito();
            $deposito->setCapacidad($capacidad)
                ->setContenido($contenidoInicial)
                ->setTipoAceite($tipoAceite);

            $manager->persist($deposito);
        }

        //Finca
        $fincas = [
            ["13", "077", "A", "018", "00039", "0000", "FP", 200, true, 30, 70, 5, 1, 2],
            ["13", "077", "A", "018", "00040", "0001", "FP", 300, true, 100, 0, 5, 1, null],
            ["13", "077", "A", "018", "00041", "0002", "FP", 600, true, 100, 0, 5, 3, null]
        ];

        foreach ($fincas as $item) {
            $finca = new Finca();
            $finca->setProvincia($item[1])
                ->setMunicipio($item[2])
                ->setSector($item[3])
                ->setPoligono($item[4])
                ->setParcela($item[5])
                ->setIdInmueble($item[6])
                ->setCaracterControl($item[7])
                ->setNumPlantas($item[8])
                ->setRegadio($item[9])
                ->setPartPropietario($item[10])
                ->setPartArrend($item[11])
                ->setVariedad($item[12])
                ->setPropietario($item[13])
                ->setArrendatario($item[14]);

            $manager->persist($finca);
        }

        //Socio
        $socios = [
            ["75111567F", "Diego", "Hurtado Rosales", "C/ España", "23", "", "", "", "", "23320", "Torreperogil", "Jaén", "953777057", "dhurtadorosales@gmail.com", "2017-03-27", true, null],
            ["75111567F", "Diego", "Hurtado Rosales", "C/ España", "23", "", "", "", "", "23320", "Torreperogil", "Jaén", "953777057", "dhurtadorosales@gmail.com", "2017-03-27", true, null],
            ["75111567F", "Diego", "Hurtado Rosales", "C/ España", "23", "", "", "", "", "23320", "Torreperogil", "Jaén", "953777057", "dhurtadorosales@gmail.com", "2017-03-27", true, null],
        ];

        foreach ($socios as $item) {
            $socio = new Socio();
            $socio->setNif($item[1])
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
            ["vuelo", 0.0],
            ["suelo", 0.0]
        ];

        foreach ($tipos as $item) {
            $tipo = new Tipo();
            $tipo->setDenominacion($item[1])
                ->setBonificacion($item[2]);

            $manager->persist($tipo);
        }

        //Administrador
        $usuario = new Usuario();

        if ($usuario instanceof UserInterface) {
            $usuario
                ->setNif('75111567F')
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, 'administrador'))
                ->setAdministrador(true)
                ->setEmpleado(false)
                ->setComercial(false)
                ->setDependiente(false)
                ->setEncargado(false)
                ->setSocio(false)
                ->setCliente(false);

            $manager->persist($usuario);
        }

        //Comercial
        $usuario = new Usuario();

        if ($usuario instanceof UserInterface) {
            $usuario
                ->setNif('75111567F')
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, 'comercial'))
                ->setAdministrador(true)
                ->setEmpleado(false)
                ->setComercial(false)
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
                ->setNif('75111567F')
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, 'dependiente'))
                ->setAdministrador(true)
                ->setEmpleado(false)
                ->setComercial(false)
                ->setDependiente(false)
                ->setEncargado(false)
                ->setSocio(false)
                ->setCliente(false);

            $manager->persist($usuario);
        }

        //Encargado
        $usuario = new Usuario();

        if ($usuario instanceof UserInterface) {
            $usuario
                ->setNif('75111567F')
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, 'encargado'))
                ->setAdministrador(true)
                ->setEmpleado(false)
                ->setComercial(false)
                ->setDependiente(false)
                ->setEncargado(false)
                ->setSocio(false)
                ->setCliente(false);

            $manager->persist($usuario);
        }

        //Socio
        $usuario = new Usuario();

        if ($usuario instanceof UserInterface) {
            $usuario
                ->setNif('75111567F')
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, 'socio'))
                ->setAdministrador(true)
                ->setEmpleado(false)
                ->setComercial(false)
                ->setDependiente(false)
                ->setEncargado(false)
                ->setSocio(false)
                ->setCliente(false);

            $manager->persist($usuario);
        }

        //Cliente
        $usuario = new Usuario();

        if ($usuario instanceof UserInterface) {
            $usuario
                ->setNif('75111567F')
                ->setClave($this->container->get('security.password_encoder')->encodePassword($usuario, 'cliente'))
                ->setAdministrador(true)
                ->setEmpleado(false)
                ->setComercial(false)
                ->setDependiente(false)
                ->setEncargado(false)
                ->setSocio(false)
                ->setCliente(false);

            $manager->persist($usuario);
        }

        $manager->flush();
    }
}
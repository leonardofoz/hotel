<?php
/**
 * @package Gestão Hoteleira
 *
 * APPLICATION-WIDE CONFIGURATION SETTINGS
 *
 * This file contains application-wide configuration settings.  The settings
 * here will be the same regardless of the machine on which the app is running.
 *
 * This configuration should be added to version control.
 *
 * No settings should be added to this file that would need to be changed
 * on a per-machine basic (ie local, staging or production).  Any
 * machine-specific settings should be added to _machine_config.php
 */

/**
 * APPLICATION ROOT DIRECTORY
 * If the application doesn't detect this correctly then it can be set explicitly
 */
if (!GlobalConfig::$APP_ROOT) GlobalConfig::$APP_ROOT = realpath("./");

/**
 * check is needed to ensure asp_tags is not enabled
 */
if (ini_get('asp_tags')) 
	die('<h3>Server Configuration Problem: asp_tags is enabled, but is not compatible with Savant.</h3>'
	. '<p>You can disable asp_tags in .htaccess, php.ini or generate your app with another template engine such as Smarty.</p>');

/**
 * INCLUDE PATH
 * Adjust the include path as necessary so PHP can locate required libraries
 */
set_include_path(
		GlobalConfig::$APP_ROOT . '/libs/' . PATH_SEPARATOR .
		GlobalConfig::$APP_ROOT . '/../phreeze/libs' . PATH_SEPARATOR .
		GlobalConfig::$APP_ROOT . '/vendor/phreeze/phreeze/libs/' . PATH_SEPARATOR .
		get_include_path()
);

/**
 * COMPOSER AUTOLOADER
 * Uncomment if Composer is being used to manage dependencies
 */
// $loader = require 'vendor/autoload.php';
// $loader->setUseIncludePath(true);

/**
 * SESSION CLASSES
 * Any classes that will be stored in the session can be added here
 * and will be pre-loaded on every page
 */
require_once "App/ExampleUser.php";

/**
 * RENDER ENGINE
 * You can use any template system that implements
 * IRenderEngine for the view layer.  Phreeze provides pre-built
 * implementations for Smarty, Savant and plain PHP.
 */
require_once 'verysimple/Phreeze/SavantRenderEngine.php';
GlobalConfig::$TEMPLATE_ENGINE = 'SavantRenderEngine';
GlobalConfig::$TEMPLATE_PATH = GlobalConfig::$APP_ROOT . '/templates/';

/**
 * ROUTE MAP
 * The route map connects URLs to Controller+Method and additionally maps the
 * wildcards to a named parameter so that they are accessible inside the
 * Controller without having to parse the URL for parameters such as IDs
 */
GlobalConfig::$ROUTE_MAP = array(

	// default controller when no route specified
	'GET:' => array('route' => 'Default.Home'),
		
	// example authentication routes
	'GET:loginform' => array('route' => 'SecureExample.LoginForm'),
	'POST:login' => array('route' => 'SecureExample.Login'),
	'GET:secureuser' => array('route' => 'SecureExample.UserPage'),
	'GET:secureadmin' => array('route' => 'SecureExample.AdminPage'),
	'GET:logout' => array('route' => 'SecureExample.Logout'),
		
	// Cidade
	'GET:cidades' => array('route' => 'Cidade.ListView'),
	'GET:cidade/(:num)' => array('route' => 'Cidade.SingleView', 'params' => array('id' => 1)),
	'GET:api/cidades' => array('route' => 'Cidade.Query'),
	'POST:api/cidade' => array('route' => 'Cidade.Create'),
	'GET:api/cidade/(:num)' => array('route' => 'Cidade.Read', 'params' => array('id' => 2)),
	'PUT:api/cidade/(:num)' => array('route' => 'Cidade.Update', 'params' => array('id' => 2)),
	'DELETE:api/cidade/(:num)' => array('route' => 'Cidade.Delete', 'params' => array('id' => 2)),
		
	// Estado
	'GET:estados' => array('route' => 'Estado.ListView'),
	'GET:estado/(:num)' => array('route' => 'Estado.SingleView', 'params' => array('id' => 1)),
	'GET:api/estados' => array('route' => 'Estado.Query'),
	'POST:api/estado' => array('route' => 'Estado.Create'),
	'GET:api/estado/(:num)' => array('route' => 'Estado.Read', 'params' => array('id' => 2)),
	'PUT:api/estado/(:num)' => array('route' => 'Estado.Update', 'params' => array('id' => 2)),
	'DELETE:api/estado/(:num)' => array('route' => 'Estado.Delete', 'params' => array('id' => 2)),
		
	// Hospedagem
	'GET:hospedagens' => array('route' => 'Hospedagem.ListView'),
	'GET:hospedagem/(:num)' => array('route' => 'Hospedagem.SingleView', 'params' => array('id' => 1)),
	'GET:api/hospedagens' => array('route' => 'Hospedagem.Query'),
	'POST:api/hospedagem' => array('route' => 'Hospedagem.Create'),
	'GET:api/hospedagem/(:num)' => array('route' => 'Hospedagem.Read', 'params' => array('id' => 2)),
	'PUT:api/hospedagem/(:num)' => array('route' => 'Hospedagem.Update', 'params' => array('id' => 2)),
	'DELETE:api/hospedagem/(:num)' => array('route' => 'Hospedagem.Delete', 'params' => array('id' => 2)),
		
	// Hospede
	'GET:hospedes' => array('route' => 'Hospede.ListView'),
	'GET:hospede/(:num)' => array('route' => 'Hospede.SingleView', 'params' => array('id' => 1)),
	'GET:api/hospedes' => array('route' => 'Hospede.Query'),
	'POST:api/hospede' => array('route' => 'Hospede.Create'),
	'GET:api/hospede/(:num)' => array('route' => 'Hospede.Read', 'params' => array('id' => 2)),
	'PUT:api/hospede/(:num)' => array('route' => 'Hospede.Update', 'params' => array('id' => 2)),
	'DELETE:api/hospede/(:num)' => array('route' => 'Hospede.Delete', 'params' => array('id' => 2)),
		
	// Meio_de_Transporte
	'GET:meios_de_transporte' => array('route' => 'Meio_de_Transporte.ListView'),
	'GET:meio_de_transporte/(:num)' => array('route' => 'Meio_de_Transporte.SingleView', 'params' => array('id' => 1)),
	'GET:api/meios_de_transporte' => array('route' => 'Meio_de_Transporte.Query'),
	'POST:api/meio_de_transporte' => array('route' => 'Meio_de_Transporte.Create'),
	'GET:api/meio_de_transporte/(:num)' => array('route' => 'Meio_de_Transporte.Read', 'params' => array('id' => 2)),
	'PUT:api/meio_de_transporte/(:num)' => array('route' => 'Meio_de_Transporte.Update', 'params' => array('id' => 2)),
	'DELETE:api/meio_de_transporte/(:num)' => array('route' => 'Meio_de_Transporte.Delete', 'params' => array('id' => 2)),
		
	// Motivo_de_Viagem
	'GET:motivos_de_viagem' => array('route' => 'Motivo_de_Viagem.ListView'),
	'GET:motivo_de_viagem/(:num)' => array('route' => 'Motivo_de_Viagem.SingleView', 'params' => array('id' => 1)),
	'GET:api/motivos_de_viagem' => array('route' => 'Motivo_de_Viagem.Query'),
	'POST:api/motivo_de_viagem' => array('route' => 'Motivo_de_Viagem.Create'),
	'GET:api/motivo_de_viagem/(:num)' => array('route' => 'Motivo_de_Viagem.Read', 'params' => array('id' => 2)),
	'PUT:api/motivo_de_viagem/(:num)' => array('route' => 'Motivo_de_Viagem.Update', 'params' => array('id' => 2)),
	'DELETE:api/motivo_de_viagem/(:num)' => array('route' => 'Motivo_de_Viagem.Delete', 'params' => array('id' => 2)),
		
	// Pais
	'GET:paises' => array('route' => 'Pais.ListView'),
	'GET:pais/(:num)' => array('route' => 'Pais.SingleView', 'params' => array('id' => 1)),
	'GET:api/paises' => array('route' => 'Pais.Query'),
	'POST:api/pais' => array('route' => 'Pais.Create'),
	'GET:api/pais/(:num)' => array('route' => 'Pais.Read', 'params' => array('id' => 2)),
	'PUT:api/pais/(:num)' => array('route' => 'Pais.Update', 'params' => array('id' => 2)),
	'DELETE:api/pais/(:num)' => array('route' => 'Pais.Delete', 'params' => array('id' => 2)),
		
	// Quarto
	'GET:quartos' => array('route' => 'Quarto.ListView'),
	'GET:quarto/(:num)' => array('route' => 'Quarto.SingleView', 'params' => array('id' => 1)),
	'GET:api/quartos' => array('route' => 'Quarto.Query'),
	'POST:api/quarto' => array('route' => 'Quarto.Create'),
	'GET:api/quarto/(:num)' => array('route' => 'Quarto.Read', 'params' => array('id' => 2)),
	'PUT:api/quarto/(:num)' => array('route' => 'Quarto.Update', 'params' => array('id' => 2)),
	'DELETE:api/quarto/(:num)' => array('route' => 'Quarto.Delete', 'params' => array('id' => 2)),
		
	// Tipo_de_Documento
	'GET:tipo_de_documentos' => array('route' => 'Tipo_de_Documento.ListView'),
	'GET:tipo_de_documento/(:num)' => array('route' => 'Tipo_de_Documento.SingleView', 'params' => array('id' => 1)),
	'GET:api/tipo_de_documentos' => array('route' => 'Tipo_de_Documento.Query'),
	'POST:api/tipo_de_documento' => array('route' => 'Tipo_de_Documento.Create'),
	'GET:api/tipo_de_documento/(:num)' => array('route' => 'Tipo_de_Documento.Read', 'params' => array('id' => 2)),
	'PUT:api/tipo_de_documento/(:num)' => array('route' => 'Tipo_de_Documento.Update', 'params' => array('id' => 2)),
	'DELETE:api/tipo_de_documento/(:num)' => array('route' => 'Tipo_de_Documento.Delete', 'params' => array('id' => 2)),

	// catch any broken API urls
	'GET:api/(:any)' => array('route' => 'Default.ErrorApi404'),
	'PUT:api/(:any)' => array('route' => 'Default.ErrorApi404'),
	'POST:api/(:any)' => array('route' => 'Default.ErrorApi404'),
	'DELETE:api/(:any)' => array('route' => 'Default.ErrorApi404')
);

/**
 * FETCHING STRATEGY
 * You may uncomment any of the lines below to specify always eager fetching.
 * Alternatively, you can copy/paste to a specific page for one-time eager fetching
 * If you paste into a controller method, replace $G_PHREEZER with $this->Phreezer
 */
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("TbHospedagem","fk_tb_hospedagem_tb_cidade1",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("TbHospedagem","fk_tb_hospedagem_tb_cidade2",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("TbHospedagem","fk_tb_hospedagem_tb_estado1",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("TbHospedagem","fk_tb_hospedagem_tb_estado2",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("TbHospedagem","fk_tb_hospedagem_tb_hospede1",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("TbHospedagem","fk_tb_hospedagem_tb_meio_transporte1",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("TbHospedagem","fk_tb_hospedagem_tb_motivo_viagem1",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("TbHospedagem","fk_tb_hospedagem_tb_pais1",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("TbHospedagem","fk_tb_hospedagem_tb_pais2",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("TbHospedagem","fk_tb_hospedagem_tb_quarto1",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("TbHospede","fk_tb_hospede_tb_cidade",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("TbHospede","fk_tb_hospede_tb_estado1",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("TbHospede","fk_tb_hospede_tb_pais1",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("TbHospede","fk_tb_hospede_tb_tipo_documento1",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
?>
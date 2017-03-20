<?php
/** @package    DbHotel::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * HospedagemMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the HospedagemDAO to the tb_hospedagem datastore.
 *
 * WARNING: THIS IS AN AUTO-GENERATED FILE
 *
 * This file should generally not be edited by hand except in special circumstances.
 * You can override the default fetching strategies for KeyMaps in _config.php.
 * Leaving this file alone will allow easy re-generation of all DAOs in the event of schema changes
 *
 * @package DbHotel::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class HospedagemMap implements IDaoMap, IDaoMap2
{

	private static $KM;
	private static $FM;
	
	/**
	 * {@inheritdoc}
	 */
	public static function AddMap($property,FieldMap $map)
	{
		self::GetFieldMaps();
		self::$FM[$property] = $map;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public static function SetFetchingStrategy($property,$loadType)
	{
		self::GetKeyMaps();
		self::$KM[$property]->LoadType = $loadType;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function GetFieldMaps()
	{
		if (self::$FM == null)
		{
			self::$FM = Array();
			self::$FM["Id"] = new FieldMap("Id","tb_hospedagem","id",true,FM_TYPE_INT,10,null,true);
			self::$FM["Hospede"] = new FieldMap("Hospede","tb_hospedagem","hospede",false,FM_TYPE_INT,10,null,false);
			self::$FM["TpHospede"] = new FieldMap("TpHospede","tb_hospedagem","tp_hospede",false,FM_TYPE_CHAR,1,null,false);
			self::$FM["Quarto"] = new FieldMap("Quarto","tb_hospedagem","quarto",false,FM_TYPE_INT,10,null,false);
			self::$FM["DtEntrada"] = new FieldMap("DtEntrada","tb_hospedagem","dt_entrada",false,FM_TYPE_DATETIME,null,null,false);
			self::$FM["DtSaida"] = new FieldMap("DtSaida","tb_hospedagem","dt_saida",false,FM_TYPE_DATETIME,null,null,false);
			self::$FM["MotivoViagem"] = new FieldMap("MotivoViagem","tb_hospedagem","motivo_viagem",false,FM_TYPE_INT,10,null,false);
			self::$FM["MeioTransporte"] = new FieldMap("MeioTransporte","tb_hospedagem","meio_transporte",false,FM_TYPE_INT,10,null,false);
			self::$FM["UltimaProcedenciaPais"] = new FieldMap("UltimaProcedenciaPais","tb_hospedagem","ultima_procedencia_pais",false,FM_TYPE_INT,10,null,false);
			self::$FM["UltimaProcedenciaEstado"] = new FieldMap("UltimaProcedenciaEstado","tb_hospedagem","ultima_procedencia_estado",false,FM_TYPE_INT,10,null,false);
			self::$FM["UltimaProcedenciaCidade"] = new FieldMap("UltimaProcedenciaCidade","tb_hospedagem","ultima_procedencia_cidade",false,FM_TYPE_INT,10,null,false);
			self::$FM["ProxDestinoPais"] = new FieldMap("ProxDestinoPais","tb_hospedagem","prox_destino_pais",false,FM_TYPE_INT,10,null,false);
			self::$FM["ProxDestinoEstado"] = new FieldMap("ProxDestinoEstado","tb_hospedagem","prox_destino_estado",false,FM_TYPE_INT,10,null,false);
			self::$FM["ProxDestinoCidade"] = new FieldMap("ProxDestinoCidade","tb_hospedagem","prox_destino_cidade",false,FM_TYPE_INT,10,null,false);
		}
		return self::$FM;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function GetKeyMaps()
	{
		if (self::$KM == null)
		{
			self::$KM = Array();
			self::$KM["fk_tb_hospedagem_tb_cidade1"] = new KeyMap("fk_tb_hospedagem_tb_cidade1", "UltimaProcedenciaCidade", "TbCidade", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			self::$KM["fk_tb_hospedagem_tb_cidade2"] = new KeyMap("fk_tb_hospedagem_tb_cidade2", "ProxDestinoCidade", "TbCidade", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			self::$KM["fk_tb_hospedagem_tb_estado1"] = new KeyMap("fk_tb_hospedagem_tb_estado1", "UltimaProcedenciaEstado", "TbEstado", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			self::$KM["fk_tb_hospedagem_tb_estado2"] = new KeyMap("fk_tb_hospedagem_tb_estado2", "ProxDestinoEstado", "TbEstado", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			self::$KM["fk_tb_hospedagem_tb_hospede1"] = new KeyMap("fk_tb_hospedagem_tb_hospede1", "Hospede", "TbHospede", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			self::$KM["fk_tb_hospedagem_tb_meio_transporte1"] = new KeyMap("fk_tb_hospedagem_tb_meio_transporte1", "MeioTransporte", "TbMeioTransporte", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			self::$KM["fk_tb_hospedagem_tb_motivo_viagem1"] = new KeyMap("fk_tb_hospedagem_tb_motivo_viagem1", "MotivoViagem", "TbMotivoViagem", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			self::$KM["fk_tb_hospedagem_tb_pais1"] = new KeyMap("fk_tb_hospedagem_tb_pais1", "UltimaProcedenciaPais", "TbPais", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			self::$KM["fk_tb_hospedagem_tb_pais2"] = new KeyMap("fk_tb_hospedagem_tb_pais2", "ProxDestinoPais", "TbPais", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			self::$KM["fk_tb_hospedagem_tb_quarto1"] = new KeyMap("fk_tb_hospedagem_tb_quarto1", "Quarto", "TbQuarto", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
		}
		return self::$KM;
	}

}

?>
<?php
/** @package    DbHotel::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * HospedeMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the HospedeDAO to the tb_hospede datastore.
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
class HospedeMap implements IDaoMap, IDaoMap2
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
			self::$FM["Id"] = new FieldMap("Id","tb_hospede","id",true,FM_TYPE_INT,10,null,true);
			self::$FM["Nome"] = new FieldMap("Nome","tb_hospede","nome",false,FM_TYPE_VARCHAR,100,null,false);
			self::$FM["DtNascimento"] = new FieldMap("DtNascimento","tb_hospede","dt_nascimento",false,FM_TYPE_DATE,null,null,false);
			self::$FM["Telefone"] = new FieldMap("Telefone","tb_hospede","telefone",false,FM_TYPE_VARCHAR,45,null,false);
			self::$FM["Profissao"] = new FieldMap("Profissao","tb_hospede","profissao",false,FM_TYPE_VARCHAR,45,null,false);
			self::$FM["Sexo"] = new FieldMap("Sexo","tb_hospede","sexo",false,FM_TYPE_CHAR,1,null,false);
			self::$FM["Cidade"] = new FieldMap("Cidade","tb_hospede","cidade",false,FM_TYPE_INT,10,null,false);
			self::$FM["Estado"] = new FieldMap("Estado","tb_hospede","estado",false,FM_TYPE_INT,10,null,false);
			self::$FM["Pais"] = new FieldMap("Pais","tb_hospede","pais",false,FM_TYPE_INT,10,null,false);
			self::$FM["Cep"] = new FieldMap("Cep","tb_hospede","cep",false,FM_TYPE_INT,10,null,false);
			self::$FM["Endereco"] = new FieldMap("Endereco","tb_hospede","endereco",false,FM_TYPE_VARCHAR,255,null,false);
			self::$FM["TipoDocumento"] = new FieldMap("TipoDocumento","tb_hospede","tipo_documento",false,FM_TYPE_INT,10,null,false);
			self::$FM["NumDocumento"] = new FieldMap("NumDocumento","tb_hospede","num_documento",false,FM_TYPE_VARCHAR,60,null,false);
			self::$FM["Email"] = new FieldMap("Email","tb_hospede","email",false,FM_TYPE_VARCHAR,45,null,false);
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
			self::$KM["fk_tb_hospedagem_tb_hospede1"] = new KeyMap("fk_tb_hospedagem_tb_hospede1", "Id", "TbHospedagem", "Hospede", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
			self::$KM["fk_tb_hospede_tb_cidade"] = new KeyMap("fk_tb_hospede_tb_cidade", "Cidade", "TbCidade", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			self::$KM["fk_tb_hospede_tb_estado1"] = new KeyMap("fk_tb_hospede_tb_estado1", "Estado", "TbEstado", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			self::$KM["fk_tb_hospede_tb_pais1"] = new KeyMap("fk_tb_hospede_tb_pais1", "Pais", "TbPais", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			self::$KM["fk_tb_hospede_tb_tipo_documento1"] = new KeyMap("fk_tb_hospede_tb_tipo_documento1", "TipoDocumento", "TbTipoDocumento", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
		}
		return self::$KM;
	}

}

?>
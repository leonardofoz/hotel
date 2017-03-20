<?php
/** @package    DbHotel::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * PaisMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the PaisDAO to the tb_pais datastore.
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
class PaisMap implements IDaoMap, IDaoMap2
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
			self::$FM["Id"] = new FieldMap("Id","tb_pais","id",true,FM_TYPE_INT,10,null,true);
			self::$FM["Nome"] = new FieldMap("Nome","tb_pais","nome",false,FM_TYPE_VARCHAR,60,null,false);
			self::$FM["Name"] = new FieldMap("Name","tb_pais","name",false,FM_TYPE_VARCHAR,60,null,false);
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
			self::$KM["fk_tb_hospedagem_tb_pais1"] = new KeyMap("fk_tb_hospedagem_tb_pais1", "Id", "TbHospedagem", "UltimaProcedenciaPais", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
			self::$KM["fk_tb_hospedagem_tb_pais2"] = new KeyMap("fk_tb_hospedagem_tb_pais2", "Id", "TbHospedagem", "ProxDestinoPais", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
			self::$KM["fk_tb_hospede_tb_pais1"] = new KeyMap("fk_tb_hospede_tb_pais1", "Id", "TbHospede", "Pais", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
		}
		return self::$KM;
	}

}

?>
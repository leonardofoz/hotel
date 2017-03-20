<?php
/** @package    DbHotel::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * EstadoMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the EstadoDAO to the tb_estado datastore.
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
class EstadoMap implements IDaoMap, IDaoMap2
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
			self::$FM["Id"] = new FieldMap("Id","tb_estado","id",true,FM_TYPE_INT,10,null,true);
			self::$FM["Nome"] = new FieldMap("Nome","tb_estado","nome",false,FM_TYPE_VARCHAR,60,null,false);
			self::$FM["Uf"] = new FieldMap("Uf","tb_estado","uf",false,FM_TYPE_VARCHAR,2,null,false);
			self::$FM["Pais"] = new FieldMap("Pais","tb_estado","pais",false,FM_TYPE_INT,10,null,false);
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
			self::$KM["fk_tb_hospedagem_tb_estado1"] = new KeyMap("fk_tb_hospedagem_tb_estado1", "Id", "TbHospedagem", "UltimaProcedenciaEstado", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
			self::$KM["fk_tb_hospedagem_tb_estado2"] = new KeyMap("fk_tb_hospedagem_tb_estado2", "Id", "TbHospedagem", "ProxDestinoEstado", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
			self::$KM["fk_tb_hospede_tb_estado1"] = new KeyMap("fk_tb_hospede_tb_estado1", "Id", "TbHospede", "Estado", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
		}
		return self::$KM;
	}

}

?>
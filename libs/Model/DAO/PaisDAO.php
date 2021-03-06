<?php
/** @package DbHotel::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/Phreezable.php");
require_once("PaisMap.php");

/**
 * PaisDAO provides object-oriented access to the tb_pais table.  This
 * class is automatically generated by ClassBuilder.
 *
 * WARNING: THIS IS AN AUTO-GENERATED FILE
 *
 * This file should generally not be edited by hand except in special circumstances.
 * Add any custom business logic to the Model class which is extended from this DAO class.
 * Leaving this file alone will allow easy re-generation of all DAOs in the event of schema changes
 *
 * @package DbHotel::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class PaisDAO extends Phreezable
{
	/** @var int */
	public $Id;

	/** @var string */
	public $Nome;

	/** @var string */
	public $Name;


	/**
	 * Returns a dataset of TbHospedagem objects with matching UltimaProcedenciaPais
	 * @param Criteria
	 * @return DataSet
	 */
	public function GetUltimaProcedenciaPaisTbHospedagems($criteria = null)
	{
		return $this->_phreezer->GetOneToMany($this, "fk_tb_hospedagem_tb_pais1", $criteria);
	}

	/**
	 * Returns a dataset of TbHospedagem objects with matching ProxDestinoPais
	 * @param Criteria
	 * @return DataSet
	 */
	public function GetProxDestinoPaisTbHospedagems($criteria = null)
	{
		return $this->_phreezer->GetOneToMany($this, "fk_tb_hospedagem_tb_pais2", $criteria);
	}

	/**
	 * Returns a dataset of TbHospede objects with matching Pais
	 * @param Criteria
	 * @return DataSet
	 */
	public function GetPaisTbHospedes($criteria = null)
	{
		return $this->_phreezer->GetOneToMany($this, "fk_tb_hospede_tb_pais1", $criteria);
	}


}
?>
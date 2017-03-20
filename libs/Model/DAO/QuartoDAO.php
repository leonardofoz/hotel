<?php
/** @package DbHotel::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/Phreezable.php");
require_once("QuartoMap.php");

/**
 * QuartoDAO provides object-oriented access to the tb_quarto table.  This
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
class QuartoDAO extends Phreezable
{
	/** @var int */
	public $Id;

	/** @var int */
	public $NumQuarto;

	/** @var int */
	public $MaxHospede;


	/**
	 * Returns a dataset of TbHospedagem objects with matching Quarto
	 * @param Criteria
	 * @return DataSet
	 */
	public function GetQuartoTbHospedagems($criteria = null)
	{
		return $this->_phreezer->GetOneToMany($this, "fk_tb_hospedagem_tb_quarto1", $criteria);
	}


}
?>
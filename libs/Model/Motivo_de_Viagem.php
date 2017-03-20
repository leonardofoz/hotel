<?php
/** @package    DbHotel::Model */

/** import supporting libraries */
require_once("DAO/Motivo_de_ViagemDAO.php");
require_once("Motivo_de_ViagemCriteria.php");

/**
 * The Motivo_de_Viagem class extends Motivo_de_ViagemDAO which provides the access
 * to the datastore.
 *
 * @package DbHotel::Model
 * @author ClassBuilder
 * @version 1.0
 */
class Motivo_de_Viagem extends Motivo_de_ViagemDAO
{

	/**
	 * Override default validation
	 * @see Phreezable::Validate()
	 */
	public function Validate()
	{
		// example of custom validation
		// $this->ResetValidationErrors();
		// $errors = $this->GetValidationErrors();
		// if ($error == true) $this->AddValidationError('FieldName', 'Error Information');
		// return !$this->HasValidationErrors();

		return parent::Validate();
	}

	/**
	 * @see Phreezable::OnSave()
	 */
	public function OnSave($insert)
	{
		// the controller create/update methods validate before saving.  this will be a
		// redundant validation check, however it will ensure data integrity at the model
		// level based on validation rules.  comment this line out if this is not desired
		if (!$this->Validate()) throw new Exception('Unable to Save Motivo_de_Viagem: ' .  implode(', ', $this->GetValidationErrors()));

		// OnSave must return true or Phreeze will cancel the save operation
		return true;
	}

}

?>

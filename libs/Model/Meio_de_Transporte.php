<?php
/** @package    DbHotel::Model */

/** import supporting libraries */
require_once("DAO/Meio_de_TransporteDAO.php");
require_once("Meio_de_TransporteCriteria.php");

/**
 * The Meio_de_Transporte class extends Meio_de_TransporteDAO which provides the access
 * to the datastore.
 *
 * @package DbHotel::Model
 * @author ClassBuilder
 * @version 1.0
 */
class Meio_de_Transporte extends Meio_de_TransporteDAO
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
		if (!$this->Validate()) throw new Exception('Unable to Save Meio_de_Transporte: ' .  implode(', ', $this->GetValidationErrors()));

		// OnSave must return true or Phreeze will cancel the save operation
		return true;
	}

}

?>

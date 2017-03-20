<?php
/** @package    DbHotel::Model */

/** import supporting libraries */
require_once("DAO/CidadeDAO.php");
require_once("CidadeCriteria.php");

/**
 * The Cidade class extends CidadeDAO which provides the access
 * to the datastore.
 *
 * @package DbHotel::Model
 * @author ClassBuilder
 * @version 1.0
 */
class Cidade extends CidadeDAO
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
		if (!$this->Validate()) throw new Exception('Unable to Save Cidade: ' .  implode(', ', $this->GetValidationErrors()));

		// OnSave must return true or Phreeze will cancel the save operation
		return true;
	}

}

?>

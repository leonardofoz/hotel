<?php
/** @package    DbHotel::Reporter */

/** import supporting libraries */
require_once("verysimple/Phreeze/Reporter.php");

/**
 * This is an example Reporter based on the Hospede object.  The reporter object
 * allows you to run arbitrary queries that return data which may or may not fith within
 * the data access API.  This can include aggregate data or subsets of data.
 *
 * Note that Reporters are read-only and cannot be used for saving data.
 *
 * @package DbHotel::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class HospedeReporter extends Reporter
{

	// the properties in this class must match the columns returned by GetCustomQuery().
	// 'CustomFieldExample' is an example that is not part of the `tb_hospede` table
	public $CustomFieldExample;

	public $Id;
	public $Nome;
	public $DtNascimento;
	public $Telefone;
	public $Profissao;
	public $Sexo;
	public $Cidade;
	public $Estado;
	public $Pais;
	public $Cep;
	public $Endereco;
	public $TipoDocumento;
	public $NumDocumento;
	public $Email;

	/*
	* GetCustomQuery returns a fully formed SQL statement.  The result columns
	* must match with the properties of this reporter object.
	*
	* @see Reporter::GetCustomQuery
	* @param Criteria $criteria
	* @return string SQL statement
	*/
	static function GetCustomQuery($criteria)
	{
		$sql = "select
			'custom value here...' as CustomFieldExample
			,`tb_hospede`.`id` as Id
			,`tb_hospede`.`nome` as Nome
			,`tb_hospede`.`dt_nascimento` as DtNascimento
			,`tb_hospede`.`telefone` as Telefone
			,`tb_hospede`.`profissao` as Profissao
			,`tb_hospede`.`sexo` as Sexo
			,`tb_hospede`.`cidade` as Cidade
			,`tb_hospede`.`estado` as Estado
			,`tb_hospede`.`pais` as Pais
			,`tb_hospede`.`cep` as Cep
			,`tb_hospede`.`endereco` as Endereco
			,`tb_hospede`.`tipo_documento` as TipoDocumento
			,`tb_hospede`.`num_documento` as NumDocumento
			,`tb_hospede`.`email` as Email
		from `tb_hospede`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();
		$sql .= $criteria->GetOrder();

		return $sql;
	}
	
	/*
	* GetCustomCountQuery returns a fully formed SQL statement that will count
	* the results.  This query must return the correct number of results that
	* GetCustomQuery would, given the same criteria
	*
	* @see Reporter::GetCustomCountQuery
	* @param Criteria $criteria
	* @return string SQL statement
	*/
	static function GetCustomCountQuery($criteria)
	{
		$sql = "select count(1) as counter from `tb_hospede`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();

		return $sql;
	}
}

?>
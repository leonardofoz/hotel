<?php
/** @package    DbHotel::Reporter */

/** import supporting libraries */
require_once("verysimple/Phreeze/Reporter.php");

/**
 * This is an example Reporter based on the Hospedagem object.  The reporter object
 * allows you to run arbitrary queries that return data which may or may not fith within
 * the data access API.  This can include aggregate data or subsets of data.
 *
 * Note that Reporters are read-only and cannot be used for saving data.
 *
 * @package DbHotel::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class HospedagemReporter extends Reporter
{

	// the properties in this class must match the columns returned by GetCustomQuery().
	// 'CustomFieldExample' is an example that is not part of the `tb_hospedagem` table
	public $Nome_Hospede;

	public $Id;
	public $Hospede;
	public $TpHospede;
	public $Quarto;
	public $DtEntrada;
	public $DtSaida;
	public $MotivoViagem;
	public $MeioTransporte;
	public $UltimaProcedenciaPais;
	public $UltimaProcedenciaEstado;
	public $UltimaProcedenciaCidade;
	public $ProxDestinoPais;
	public $ProxDestinoEstado;
	public $ProxDestinoCidade;

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
			`tb_hospede`.`nome` as Nome_Hospede
			,`tb_hospedagem`.`id` as Id
			,`tb_hospedagem`.`hospede` as Hospede
			,`tb_hospedagem`.`tp_hospede` as TpHospede
			,`tb_hospedagem`.`quarto` as Quarto
			,`tb_hospedagem`.`dt_entrada` as DtEntrada
			,`tb_hospedagem`.`dt_saida` as DtSaida
			,`tb_hospedagem`.`motivo_viagem` as MotivoViagem
			,`tb_hospedagem`.`meio_transporte` as MeioTransporte
			,`tb_hospedagem`.`ultima_procedencia_pais` as UltimaProcedenciaPais
			,`tb_hospedagem`.`ultima_procedencia_estado` as UltimaProcedenciaEstado
			,`tb_hospedagem`.`ultima_procedencia_cidade` as UltimaProcedenciaCidade
			,`tb_hospedagem`.`prox_destino_pais` as ProxDestinoPais
			,`tb_hospedagem`.`prox_destino_estado` as ProxDestinoEstado
			,`tb_hospedagem`.`prox_destino_cidade` as ProxDestinoCidade
		from `tb_hospedagem`
        inner join tb_hospede on hospede = tb_hospede.id";

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
		$sql = "select count(1) as counter from `tb_hospedagem`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();

		return $sql;
	}
}

?>
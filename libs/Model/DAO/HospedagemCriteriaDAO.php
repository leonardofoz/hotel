<?php
/** @package    DbHotel::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/Criteria.php");

/**
 * HospedagemCriteria allows custom querying for the Hospedagem object.
 *
 * WARNING: THIS IS AN AUTO-GENERATED FILE
 *
 * This file should generally not be edited by hand except in special circumstances.
 * Add any custom business logic to the ModelCriteria class which is extended from this class.
 * Leaving this file alone will allow easy re-generation of all DAOs in the event of schema changes
 *
 * @inheritdocs
 * @package DbHotel::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class HospedagemCriteriaDAO extends Criteria
{

	public $Id_Equals;
	public $Id_NotEquals;
	public $Id_IsLike;
	public $Id_IsNotLike;
	public $Id_BeginsWith;
	public $Id_EndsWith;
	public $Id_GreaterThan;
	public $Id_GreaterThanOrEqual;
	public $Id_LessThan;
	public $Id_LessThanOrEqual;
	public $Id_In;
	public $Id_IsNotEmpty;
	public $Id_IsEmpty;
	public $Id_BitwiseOr;
	public $Id_BitwiseAnd;
	public $Hospede_Equals;
	public $Hospede_NotEquals;
	public $Hospede_IsLike;
	public $Hospede_IsNotLike;
	public $Hospede_BeginsWith;
	public $Hospede_EndsWith;
	public $Hospede_GreaterThan;
	public $Hospede_GreaterThanOrEqual;
	public $Hospede_LessThan;
	public $Hospede_LessThanOrEqual;
	public $Hospede_In;
	public $Hospede_IsNotEmpty;
	public $Hospede_IsEmpty;
	public $Hospede_BitwiseOr;
	public $Hospede_BitwiseAnd;
	public $TpHospede_Equals;
	public $TpHospede_NotEquals;
	public $TpHospede_IsLike;
	public $TpHospede_IsNotLike;
	public $TpHospede_BeginsWith;
	public $TpHospede_EndsWith;
	public $TpHospede_GreaterThan;
	public $TpHospede_GreaterThanOrEqual;
	public $TpHospede_LessThan;
	public $TpHospede_LessThanOrEqual;
	public $TpHospede_In;
	public $TpHospede_IsNotEmpty;
	public $TpHospede_IsEmpty;
	public $TpHospede_BitwiseOr;
	public $TpHospede_BitwiseAnd;
	public $Quarto_Equals;
	public $Quarto_NotEquals;
	public $Quarto_IsLike;
	public $Quarto_IsNotLike;
	public $Quarto_BeginsWith;
	public $Quarto_EndsWith;
	public $Quarto_GreaterThan;
	public $Quarto_GreaterThanOrEqual;
	public $Quarto_LessThan;
	public $Quarto_LessThanOrEqual;
	public $Quarto_In;
	public $Quarto_IsNotEmpty;
	public $Quarto_IsEmpty;
	public $Quarto_BitwiseOr;
	public $Quarto_BitwiseAnd;
	public $DtEntrada_Equals;
	public $DtEntrada_NotEquals;
	public $DtEntrada_IsLike;
	public $DtEntrada_IsNotLike;
	public $DtEntrada_BeginsWith;
	public $DtEntrada_EndsWith;
	public $DtEntrada_GreaterThan;
	public $DtEntrada_GreaterThanOrEqual;
	public $DtEntrada_LessThan;
	public $DtEntrada_LessThanOrEqual;
	public $DtEntrada_In;
	public $DtEntrada_IsNotEmpty;
	public $DtEntrada_IsEmpty;
	public $DtEntrada_BitwiseOr;
	public $DtEntrada_BitwiseAnd;
	public $DtSaida_Equals;
	public $DtSaida_NotEquals;
	public $DtSaida_IsLike;
	public $DtSaida_IsNotLike;
	public $DtSaida_BeginsWith;
	public $DtSaida_EndsWith;
	public $DtSaida_GreaterThan;
	public $DtSaida_GreaterThanOrEqual;
	public $DtSaida_LessThan;
	public $DtSaida_LessThanOrEqual;
	public $DtSaida_In;
	public $DtSaida_IsNotEmpty;
	public $DtSaida_IsEmpty;
	public $DtSaida_BitwiseOr;
	public $DtSaida_BitwiseAnd;
	public $MotivoViagem_Equals;
	public $MotivoViagem_NotEquals;
	public $MotivoViagem_IsLike;
	public $MotivoViagem_IsNotLike;
	public $MotivoViagem_BeginsWith;
	public $MotivoViagem_EndsWith;
	public $MotivoViagem_GreaterThan;
	public $MotivoViagem_GreaterThanOrEqual;
	public $MotivoViagem_LessThan;
	public $MotivoViagem_LessThanOrEqual;
	public $MotivoViagem_In;
	public $MotivoViagem_IsNotEmpty;
	public $MotivoViagem_IsEmpty;
	public $MotivoViagem_BitwiseOr;
	public $MotivoViagem_BitwiseAnd;
	public $MeioTransporte_Equals;
	public $MeioTransporte_NotEquals;
	public $MeioTransporte_IsLike;
	public $MeioTransporte_IsNotLike;
	public $MeioTransporte_BeginsWith;
	public $MeioTransporte_EndsWith;
	public $MeioTransporte_GreaterThan;
	public $MeioTransporte_GreaterThanOrEqual;
	public $MeioTransporte_LessThan;
	public $MeioTransporte_LessThanOrEqual;
	public $MeioTransporte_In;
	public $MeioTransporte_IsNotEmpty;
	public $MeioTransporte_IsEmpty;
	public $MeioTransporte_BitwiseOr;
	public $MeioTransporte_BitwiseAnd;
	public $UltimaProcedenciaPais_Equals;
	public $UltimaProcedenciaPais_NotEquals;
	public $UltimaProcedenciaPais_IsLike;
	public $UltimaProcedenciaPais_IsNotLike;
	public $UltimaProcedenciaPais_BeginsWith;
	public $UltimaProcedenciaPais_EndsWith;
	public $UltimaProcedenciaPais_GreaterThan;
	public $UltimaProcedenciaPais_GreaterThanOrEqual;
	public $UltimaProcedenciaPais_LessThan;
	public $UltimaProcedenciaPais_LessThanOrEqual;
	public $UltimaProcedenciaPais_In;
	public $UltimaProcedenciaPais_IsNotEmpty;
	public $UltimaProcedenciaPais_IsEmpty;
	public $UltimaProcedenciaPais_BitwiseOr;
	public $UltimaProcedenciaPais_BitwiseAnd;
	public $UltimaProcedenciaEstado_Equals;
	public $UltimaProcedenciaEstado_NotEquals;
	public $UltimaProcedenciaEstado_IsLike;
	public $UltimaProcedenciaEstado_IsNotLike;
	public $UltimaProcedenciaEstado_BeginsWith;
	public $UltimaProcedenciaEstado_EndsWith;
	public $UltimaProcedenciaEstado_GreaterThan;
	public $UltimaProcedenciaEstado_GreaterThanOrEqual;
	public $UltimaProcedenciaEstado_LessThan;
	public $UltimaProcedenciaEstado_LessThanOrEqual;
	public $UltimaProcedenciaEstado_In;
	public $UltimaProcedenciaEstado_IsNotEmpty;
	public $UltimaProcedenciaEstado_IsEmpty;
	public $UltimaProcedenciaEstado_BitwiseOr;
	public $UltimaProcedenciaEstado_BitwiseAnd;
	public $UltimaProcedenciaCidade_Equals;
	public $UltimaProcedenciaCidade_NotEquals;
	public $UltimaProcedenciaCidade_IsLike;
	public $UltimaProcedenciaCidade_IsNotLike;
	public $UltimaProcedenciaCidade_BeginsWith;
	public $UltimaProcedenciaCidade_EndsWith;
	public $UltimaProcedenciaCidade_GreaterThan;
	public $UltimaProcedenciaCidade_GreaterThanOrEqual;
	public $UltimaProcedenciaCidade_LessThan;
	public $UltimaProcedenciaCidade_LessThanOrEqual;
	public $UltimaProcedenciaCidade_In;
	public $UltimaProcedenciaCidade_IsNotEmpty;
	public $UltimaProcedenciaCidade_IsEmpty;
	public $UltimaProcedenciaCidade_BitwiseOr;
	public $UltimaProcedenciaCidade_BitwiseAnd;
	public $ProxDestinoPais_Equals;
	public $ProxDestinoPais_NotEquals;
	public $ProxDestinoPais_IsLike;
	public $ProxDestinoPais_IsNotLike;
	public $ProxDestinoPais_BeginsWith;
	public $ProxDestinoPais_EndsWith;
	public $ProxDestinoPais_GreaterThan;
	public $ProxDestinoPais_GreaterThanOrEqual;
	public $ProxDestinoPais_LessThan;
	public $ProxDestinoPais_LessThanOrEqual;
	public $ProxDestinoPais_In;
	public $ProxDestinoPais_IsNotEmpty;
	public $ProxDestinoPais_IsEmpty;
	public $ProxDestinoPais_BitwiseOr;
	public $ProxDestinoPais_BitwiseAnd;
	public $ProxDestinoEstado_Equals;
	public $ProxDestinoEstado_NotEquals;
	public $ProxDestinoEstado_IsLike;
	public $ProxDestinoEstado_IsNotLike;
	public $ProxDestinoEstado_BeginsWith;
	public $ProxDestinoEstado_EndsWith;
	public $ProxDestinoEstado_GreaterThan;
	public $ProxDestinoEstado_GreaterThanOrEqual;
	public $ProxDestinoEstado_LessThan;
	public $ProxDestinoEstado_LessThanOrEqual;
	public $ProxDestinoEstado_In;
	public $ProxDestinoEstado_IsNotEmpty;
	public $ProxDestinoEstado_IsEmpty;
	public $ProxDestinoEstado_BitwiseOr;
	public $ProxDestinoEstado_BitwiseAnd;
	public $ProxDestinoCidade_Equals;
	public $ProxDestinoCidade_NotEquals;
	public $ProxDestinoCidade_IsLike;
	public $ProxDestinoCidade_IsNotLike;
	public $ProxDestinoCidade_BeginsWith;
	public $ProxDestinoCidade_EndsWith;
	public $ProxDestinoCidade_GreaterThan;
	public $ProxDestinoCidade_GreaterThanOrEqual;
	public $ProxDestinoCidade_LessThan;
	public $ProxDestinoCidade_LessThanOrEqual;
	public $ProxDestinoCidade_In;
	public $ProxDestinoCidade_IsNotEmpty;
	public $ProxDestinoCidade_IsEmpty;
	public $ProxDestinoCidade_BitwiseOr;
	public $ProxDestinoCidade_BitwiseAnd;

}

?>
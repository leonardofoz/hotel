<?php
/** @package    DbHotel::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/Criteria.php");

/**
 * HospedeCriteria allows custom querying for the Hospede object.
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
class HospedeCriteriaDAO extends Criteria
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
	public $Nome_Equals;
	public $Nome_NotEquals;
	public $Nome_IsLike;
	public $Nome_IsNotLike;
	public $Nome_BeginsWith;
	public $Nome_EndsWith;
	public $Nome_GreaterThan;
	public $Nome_GreaterThanOrEqual;
	public $Nome_LessThan;
	public $Nome_LessThanOrEqual;
	public $Nome_In;
	public $Nome_IsNotEmpty;
	public $Nome_IsEmpty;
	public $Nome_BitwiseOr;
	public $Nome_BitwiseAnd;
	public $DtNascimento_Equals;
	public $DtNascimento_NotEquals;
	public $DtNascimento_IsLike;
	public $DtNascimento_IsNotLike;
	public $DtNascimento_BeginsWith;
	public $DtNascimento_EndsWith;
	public $DtNascimento_GreaterThan;
	public $DtNascimento_GreaterThanOrEqual;
	public $DtNascimento_LessThan;
	public $DtNascimento_LessThanOrEqual;
	public $DtNascimento_In;
	public $DtNascimento_IsNotEmpty;
	public $DtNascimento_IsEmpty;
	public $DtNascimento_BitwiseOr;
	public $DtNascimento_BitwiseAnd;
	public $Telefone_Equals;
	public $Telefone_NotEquals;
	public $Telefone_IsLike;
	public $Telefone_IsNotLike;
	public $Telefone_BeginsWith;
	public $Telefone_EndsWith;
	public $Telefone_GreaterThan;
	public $Telefone_GreaterThanOrEqual;
	public $Telefone_LessThan;
	public $Telefone_LessThanOrEqual;
	public $Telefone_In;
	public $Telefone_IsNotEmpty;
	public $Telefone_IsEmpty;
	public $Telefone_BitwiseOr;
	public $Telefone_BitwiseAnd;
	public $Profissao_Equals;
	public $Profissao_NotEquals;
	public $Profissao_IsLike;
	public $Profissao_IsNotLike;
	public $Profissao_BeginsWith;
	public $Profissao_EndsWith;
	public $Profissao_GreaterThan;
	public $Profissao_GreaterThanOrEqual;
	public $Profissao_LessThan;
	public $Profissao_LessThanOrEqual;
	public $Profissao_In;
	public $Profissao_IsNotEmpty;
	public $Profissao_IsEmpty;
	public $Profissao_BitwiseOr;
	public $Profissao_BitwiseAnd;
	public $Sexo_Equals;
	public $Sexo_NotEquals;
	public $Sexo_IsLike;
	public $Sexo_IsNotLike;
	public $Sexo_BeginsWith;
	public $Sexo_EndsWith;
	public $Sexo_GreaterThan;
	public $Sexo_GreaterThanOrEqual;
	public $Sexo_LessThan;
	public $Sexo_LessThanOrEqual;
	public $Sexo_In;
	public $Sexo_IsNotEmpty;
	public $Sexo_IsEmpty;
	public $Sexo_BitwiseOr;
	public $Sexo_BitwiseAnd;
	public $Cidade_Equals;
	public $Cidade_NotEquals;
	public $Cidade_IsLike;
	public $Cidade_IsNotLike;
	public $Cidade_BeginsWith;
	public $Cidade_EndsWith;
	public $Cidade_GreaterThan;
	public $Cidade_GreaterThanOrEqual;
	public $Cidade_LessThan;
	public $Cidade_LessThanOrEqual;
	public $Cidade_In;
	public $Cidade_IsNotEmpty;
	public $Cidade_IsEmpty;
	public $Cidade_BitwiseOr;
	public $Cidade_BitwiseAnd;
	public $Estado_Equals;
	public $Estado_NotEquals;
	public $Estado_IsLike;
	public $Estado_IsNotLike;
	public $Estado_BeginsWith;
	public $Estado_EndsWith;
	public $Estado_GreaterThan;
	public $Estado_GreaterThanOrEqual;
	public $Estado_LessThan;
	public $Estado_LessThanOrEqual;
	public $Estado_In;
	public $Estado_IsNotEmpty;
	public $Estado_IsEmpty;
	public $Estado_BitwiseOr;
	public $Estado_BitwiseAnd;
	public $Pais_Equals;
	public $Pais_NotEquals;
	public $Pais_IsLike;
	public $Pais_IsNotLike;
	public $Pais_BeginsWith;
	public $Pais_EndsWith;
	public $Pais_GreaterThan;
	public $Pais_GreaterThanOrEqual;
	public $Pais_LessThan;
	public $Pais_LessThanOrEqual;
	public $Pais_In;
	public $Pais_IsNotEmpty;
	public $Pais_IsEmpty;
	public $Pais_BitwiseOr;
	public $Pais_BitwiseAnd;
	public $Cep_Equals;
	public $Cep_NotEquals;
	public $Cep_IsLike;
	public $Cep_IsNotLike;
	public $Cep_BeginsWith;
	public $Cep_EndsWith;
	public $Cep_GreaterThan;
	public $Cep_GreaterThanOrEqual;
	public $Cep_LessThan;
	public $Cep_LessThanOrEqual;
	public $Cep_In;
	public $Cep_IsNotEmpty;
	public $Cep_IsEmpty;
	public $Cep_BitwiseOr;
	public $Cep_BitwiseAnd;
	public $Endereco_Equals;
	public $Endereco_NotEquals;
	public $Endereco_IsLike;
	public $Endereco_IsNotLike;
	public $Endereco_BeginsWith;
	public $Endereco_EndsWith;
	public $Endereco_GreaterThan;
	public $Endereco_GreaterThanOrEqual;
	public $Endereco_LessThan;
	public $Endereco_LessThanOrEqual;
	public $Endereco_In;
	public $Endereco_IsNotEmpty;
	public $Endereco_IsEmpty;
	public $Endereco_BitwiseOr;
	public $Endereco_BitwiseAnd;
	public $TipoDocumento_Equals;
	public $TipoDocumento_NotEquals;
	public $TipoDocumento_IsLike;
	public $TipoDocumento_IsNotLike;
	public $TipoDocumento_BeginsWith;
	public $TipoDocumento_EndsWith;
	public $TipoDocumento_GreaterThan;
	public $TipoDocumento_GreaterThanOrEqual;
	public $TipoDocumento_LessThan;
	public $TipoDocumento_LessThanOrEqual;
	public $TipoDocumento_In;
	public $TipoDocumento_IsNotEmpty;
	public $TipoDocumento_IsEmpty;
	public $TipoDocumento_BitwiseOr;
	public $TipoDocumento_BitwiseAnd;
	public $NumDocumento_Equals;
	public $NumDocumento_NotEquals;
	public $NumDocumento_IsLike;
	public $NumDocumento_IsNotLike;
	public $NumDocumento_BeginsWith;
	public $NumDocumento_EndsWith;
	public $NumDocumento_GreaterThan;
	public $NumDocumento_GreaterThanOrEqual;
	public $NumDocumento_LessThan;
	public $NumDocumento_LessThanOrEqual;
	public $NumDocumento_In;
	public $NumDocumento_IsNotEmpty;
	public $NumDocumento_IsEmpty;
	public $NumDocumento_BitwiseOr;
	public $NumDocumento_BitwiseAnd;
	public $Email_Equals;
	public $Email_NotEquals;
	public $Email_IsLike;
	public $Email_IsNotLike;
	public $Email_BeginsWith;
	public $Email_EndsWith;
	public $Email_GreaterThan;
	public $Email_GreaterThanOrEqual;
	public $Email_LessThan;
	public $Email_LessThanOrEqual;
	public $Email_In;
	public $Email_IsNotEmpty;
	public $Email_IsEmpty;
	public $Email_BitwiseOr;
	public $Email_BitwiseAnd;

}

?>
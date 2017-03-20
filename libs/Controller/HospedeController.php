<?php
/** @package    Gestão Hoteleira::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Hospede.php");

/**
 * HospedeController is the controller class for the Hospede object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package Gestão Hoteleira::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class HospedeController extends AppBaseController
{

	/**
	 * Override here for any controller-specific functionality
	 *
	 * @inheritdocs
	 */
	protected function Init()
	{
		parent::Init();

		// TODO: add controller-wide bootstrap code
		
		// TODO: if authentiation is required for this entire controller, for example:
		// $this->RequirePermission(ExampleUser::$PERMISSION_USER,'SecureExample.LoginForm');
	}

	/**
	 * Displays a list view of Hospede objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for Hospede records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new HospedeCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,Nome,DtNascimento,Telefone,Profissao,Sexo,Cidade,Estado,Pais,Cep,Endereco,TipoDocumento,NumDocumento,Email'
				, '%'.$filter.'%')
			);

			// TODO: this is generic query filtering based only on criteria properties
			foreach (array_keys($_REQUEST) as $prop)
			{
				$prop_normal = ucfirst($prop);
				$prop_equals = $prop_normal.'_Equals';

				if (property_exists($criteria, $prop_normal))
				{
					$criteria->$prop_normal = RequestUtil::Get($prop);
				}
				elseif (property_exists($criteria, $prop_equals))
				{
					// this is a convenience so that the _Equals suffix is not needed
					$criteria->$prop_equals = RequestUtil::Get($prop);
				}
			}

			$output = new stdClass();

			// if a sort order was specified then specify in the criteria
 			$output->orderBy = RequestUtil::Get('orderBy');
 			$output->orderDesc = RequestUtil::Get('orderDesc') != '';
 			if ($output->orderBy) $criteria->SetOrder($output->orderBy, $output->orderDesc);

			$page = RequestUtil::Get('page');

			if ($page != '')
			{
				// if page is specified, use this instead (at the expense of one extra count query)
				$pagesize = $this->GetDefaultPageSize();

				$hospedes = $this->Phreezer->Query('Hospede',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $hospedes->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $hospedes->TotalResults;
				$output->totalPages = $hospedes->TotalPages;
				$output->pageSize = $hospedes->PageSize;
				$output->currentPage = $hospedes->CurrentPage;
			}
			else
			{
				// return all results
				$hospedes = $this->Phreezer->Query('Hospede',$criteria);
				$output->rows = $hospedes->ToObjectArray(true, $this->SimpleObjectParams());
				$output->totalResults = count($output->rows);
				$output->totalPages = 1;
				$output->pageSize = $output->totalResults;
				$output->currentPage = 1;
			}


			$this->RenderJSON($output, $this->JSONPCallback());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method retrieves a single Hospede record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$hospede = $this->Phreezer->Get('Hospede',$pk);
			$this->RenderJSON($hospede, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Hospede record and render response as JSON
	 */
	public function Create()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$hospede = new Hospede($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $hospede->Id = $this->SafeGetVal($json, 'id');

			$hospede->Nome = $this->SafeGetVal($json, 'nome');
			$hospede->DtNascimento = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'dtNascimento')));
			$hospede->Telefone = $this->SafeGetVal($json, 'telefone');
			$hospede->Profissao = $this->SafeGetVal($json, 'profissao');
			$hospede->Sexo = $this->SafeGetVal($json, 'sexo');
			$hospede->Cidade = $this->SafeGetVal($json, 'cidade');
			$hospede->Estado = $this->SafeGetVal($json, 'estado');
			$hospede->Pais = $this->SafeGetVal($json, 'pais');
			$hospede->Cep = $this->SafeGetVal($json, 'cep');
			$hospede->Endereco = $this->SafeGetVal($json, 'endereco');
			$hospede->TipoDocumento = $this->SafeGetVal($json, 'tipoDocumento');
			$hospede->NumDocumento = $this->SafeGetVal($json, 'numDocumento');
			$hospede->Email = $this->SafeGetVal($json, 'email');

			$hospede->Validate();
			$errors = $hospede->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$hospede->Save();
				$this->RenderJSON($hospede, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Hospede record and render response as JSON
	 */
	public function Update()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$pk = $this->GetRouter()->GetUrlParam('id');
			$hospede = $this->Phreezer->Get('Hospede',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $hospede->Id = $this->SafeGetVal($json, 'id', $hospede->Id);

			$hospede->Nome = $this->SafeGetVal($json, 'nome', $hospede->Nome);
			$hospede->DtNascimento = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'dtNascimento', $hospede->DtNascimento)));
			$hospede->Telefone = $this->SafeGetVal($json, 'telefone', $hospede->Telefone);
			$hospede->Profissao = $this->SafeGetVal($json, 'profissao', $hospede->Profissao);
			$hospede->Sexo = $this->SafeGetVal($json, 'sexo', $hospede->Sexo);
			$hospede->Cidade = $this->SafeGetVal($json, 'cidade', $hospede->Cidade);
			$hospede->Estado = $this->SafeGetVal($json, 'estado', $hospede->Estado);
			$hospede->Pais = $this->SafeGetVal($json, 'pais', $hospede->Pais);
			$hospede->Cep = $this->SafeGetVal($json, 'cep', $hospede->Cep);
			$hospede->Endereco = $this->SafeGetVal($json, 'endereco', $hospede->Endereco);
			$hospede->TipoDocumento = $this->SafeGetVal($json, 'tipoDocumento', $hospede->TipoDocumento);
			$hospede->NumDocumento = $this->SafeGetVal($json, 'numDocumento', $hospede->NumDocumento);
			$hospede->Email = $this->SafeGetVal($json, 'email', $hospede->Email);

			$hospede->Validate();
			$errors = $hospede->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$hospede->Save();
				$this->RenderJSON($hospede, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Hospede record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$hospede = $this->Phreezer->Get('Hospede',$pk);

			$hospede->Delete();

			$output = new stdClass();

			$this->RenderJSON($output, $this->JSONPCallback());

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}
}

?>

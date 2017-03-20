<?php
/** @package    Gestão Hoteleira::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Tipo_de_Documento.php");

/**
 * Tipo_de_DocumentoController is the controller class for the Tipo_de_Documento object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package Gestão Hoteleira::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class Tipo_de_DocumentoController extends AppBaseController
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
	 * Displays a list view of Tipo_de_Documento objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for Tipo_de_Documento records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new Tipo_de_DocumentoCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,Sigla,Nome'
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

				$tipo_de_documentos = $this->Phreezer->Query('Tipo_de_Documento',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $tipo_de_documentos->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $tipo_de_documentos->TotalResults;
				$output->totalPages = $tipo_de_documentos->TotalPages;
				$output->pageSize = $tipo_de_documentos->PageSize;
				$output->currentPage = $tipo_de_documentos->CurrentPage;
			}
			else
			{
				// return all results
				$tipo_de_documentos = $this->Phreezer->Query('Tipo_de_Documento',$criteria);
				$output->rows = $tipo_de_documentos->ToObjectArray(true, $this->SimpleObjectParams());
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
	 * API Method retrieves a single Tipo_de_Documento record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$tipo_de_documento = $this->Phreezer->Get('Tipo_de_Documento',$pk);
			$this->RenderJSON($tipo_de_documento, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Tipo_de_Documento record and render response as JSON
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

			$tipo_de_documento = new Tipo_de_Documento($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $tipo_de_documento->Id = $this->SafeGetVal($json, 'id');

			$tipo_de_documento->Sigla = $this->SafeGetVal($json, 'sigla');
			$tipo_de_documento->Nome = $this->SafeGetVal($json, 'nome');

			$tipo_de_documento->Validate();
			$errors = $tipo_de_documento->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$tipo_de_documento->Save();
				$this->RenderJSON($tipo_de_documento, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Tipo_de_Documento record and render response as JSON
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
			$tipo_de_documento = $this->Phreezer->Get('Tipo_de_Documento',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $tipo_de_documento->Id = $this->SafeGetVal($json, 'id', $tipo_de_documento->Id);

			$tipo_de_documento->Sigla = $this->SafeGetVal($json, 'sigla', $tipo_de_documento->Sigla);
			$tipo_de_documento->Nome = $this->SafeGetVal($json, 'nome', $tipo_de_documento->Nome);

			$tipo_de_documento->Validate();
			$errors = $tipo_de_documento->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$tipo_de_documento->Save();
				$this->RenderJSON($tipo_de_documento, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Tipo_de_Documento record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$tipo_de_documento = $this->Phreezer->Get('Tipo_de_Documento',$pk);

			$tipo_de_documento->Delete();

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

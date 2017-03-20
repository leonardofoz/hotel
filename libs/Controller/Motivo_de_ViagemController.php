<?php
/** @package    Gestão Hoteleira::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Motivo_de_Viagem.php");

/**
 * Motivo_de_ViagemController is the controller class for the Motivo_de_Viagem object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package Gestão Hoteleira::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class Motivo_de_ViagemController extends AppBaseController
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
	 * Displays a list view of Motivo_de_Viagem objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for Motivo_de_Viagem records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new Motivo_de_ViagemCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,Descricao,Description'
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

				$motivos_de_viagem = $this->Phreezer->Query('Motivo_de_Viagem',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $motivos_de_viagem->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $motivos_de_viagem->TotalResults;
				$output->totalPages = $motivos_de_viagem->TotalPages;
				$output->pageSize = $motivos_de_viagem->PageSize;
				$output->currentPage = $motivos_de_viagem->CurrentPage;
			}
			else
			{
				// return all results
				$motivos_de_viagem = $this->Phreezer->Query('Motivo_de_Viagem',$criteria);
				$output->rows = $motivos_de_viagem->ToObjectArray(true, $this->SimpleObjectParams());
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
	 * API Method retrieves a single Motivo_de_Viagem record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$motivo_de_viagem = $this->Phreezer->Get('Motivo_de_Viagem',$pk);
			$this->RenderJSON($motivo_de_viagem, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Motivo_de_Viagem record and render response as JSON
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

			$motivo_de_viagem = new Motivo_de_Viagem($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $motivo_de_viagem->Id = $this->SafeGetVal($json, 'id');

			$motivo_de_viagem->Descricao = $this->SafeGetVal($json, 'descricao');
			$motivo_de_viagem->Description = $this->SafeGetVal($json, 'description');

			$motivo_de_viagem->Validate();
			$errors = $motivo_de_viagem->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$motivo_de_viagem->Save();
				$this->RenderJSON($motivo_de_viagem, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Motivo_de_Viagem record and render response as JSON
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
			$motivo_de_viagem = $this->Phreezer->Get('Motivo_de_Viagem',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $motivo_de_viagem->Id = $this->SafeGetVal($json, 'id', $motivo_de_viagem->Id);

			$motivo_de_viagem->Descricao = $this->SafeGetVal($json, 'descricao', $motivo_de_viagem->Descricao);
			$motivo_de_viagem->Description = $this->SafeGetVal($json, 'description', $motivo_de_viagem->Description);

			$motivo_de_viagem->Validate();
			$errors = $motivo_de_viagem->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$motivo_de_viagem->Save();
				$this->RenderJSON($motivo_de_viagem, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Motivo_de_Viagem record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$motivo_de_viagem = $this->Phreezer->Get('Motivo_de_Viagem',$pk);

			$motivo_de_viagem->Delete();

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

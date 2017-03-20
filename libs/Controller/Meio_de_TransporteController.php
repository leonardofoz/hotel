<?php
/** @package    Gestão Hoteleira::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Meio_de_Transporte.php");

/**
 * Meio_de_TransporteController is the controller class for the Meio_de_Transporte object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package Gestão Hoteleira::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class Meio_de_TransporteController extends AppBaseController
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
	 * Displays a list view of Meio_de_Transporte objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for Meio_de_Transporte records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new Meio_de_TransporteCriteria();
			
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

				$meios_de_transporte = $this->Phreezer->Query('Meio_de_Transporte',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $meios_de_transporte->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $meios_de_transporte->TotalResults;
				$output->totalPages = $meios_de_transporte->TotalPages;
				$output->pageSize = $meios_de_transporte->PageSize;
				$output->currentPage = $meios_de_transporte->CurrentPage;
			}
			else
			{
				// return all results
				$meios_de_transporte = $this->Phreezer->Query('Meio_de_Transporte',$criteria);
				$output->rows = $meios_de_transporte->ToObjectArray(true, $this->SimpleObjectParams());
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
	 * API Method retrieves a single Meio_de_Transporte record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$meio_de_transporte = $this->Phreezer->Get('Meio_de_Transporte',$pk);
			$this->RenderJSON($meio_de_transporte, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Meio_de_Transporte record and render response as JSON
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

			$meio_de_transporte = new Meio_de_Transporte($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $meio_de_transporte->Id = $this->SafeGetVal($json, 'id');

			$meio_de_transporte->Descricao = $this->SafeGetVal($json, 'descricao');
			$meio_de_transporte->Description = $this->SafeGetVal($json, 'description');

			$meio_de_transporte->Validate();
			$errors = $meio_de_transporte->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$meio_de_transporte->Save();
				$this->RenderJSON($meio_de_transporte, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Meio_de_Transporte record and render response as JSON
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
			$meio_de_transporte = $this->Phreezer->Get('Meio_de_Transporte',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $meio_de_transporte->Id = $this->SafeGetVal($json, 'id', $meio_de_transporte->Id);

			$meio_de_transporte->Descricao = $this->SafeGetVal($json, 'descricao', $meio_de_transporte->Descricao);
			$meio_de_transporte->Description = $this->SafeGetVal($json, 'description', $meio_de_transporte->Description);

			$meio_de_transporte->Validate();
			$errors = $meio_de_transporte->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$meio_de_transporte->Save();
				$this->RenderJSON($meio_de_transporte, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Meio_de_Transporte record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$meio_de_transporte = $this->Phreezer->Get('Meio_de_Transporte',$pk);

			$meio_de_transporte->Delete();

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

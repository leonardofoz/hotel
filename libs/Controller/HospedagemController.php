<?php
/** @package    Gestão Hoteleira::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Hospedagem.php");

/**
 * HospedagemController is the controller class for the Hospedagem object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package Gestão Hoteleira::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class HospedagemController extends AppBaseController
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
	 * Displays a list view of Hospedagem objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for Hospedagem records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new HospedagemCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,Hospede,TpHospede,Quarto,DtEntrada,DtSaida,MotivoViagem,MeioTransporte,UltimaProcedenciaPais,UltimaProcedenciaEstado,UltimaProcedenciaCidade,ProxDestinoPais,ProxDestinoEstado,ProxDestinoCidade'
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

				$hospedagens = $this->Phreezer->Query('HospedagemReporter',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $hospedagens->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $hospedagens->TotalResults;
				$output->totalPages = $hospedagens->TotalPages;
				$output->pageSize = $hospedagens->PageSize;
				$output->currentPage = $hospedagens->CurrentPage;
			}
			else
			{
				// return all results
				$hospedagens = $this->Phreezer->Query('HospedagemReporter',$criteria);
				$output->rows = $hospedagens->ToObjectArray(true, $this->SimpleObjectParams());
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
	 * API Method retrieves a single Hospedagem record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$hospedagem = $this->Phreezer->Get('Hospedagem',$pk);
			$this->RenderJSON($hospedagem, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Hospedagem record and render response as JSON
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

			$hospedagem = new Hospedagem($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $hospedagem->Id = $this->SafeGetVal($json, 'id');

			$hospedagem->Hospede = $this->SafeGetVal($json, 'hospede');
			$hospedagem->TpHospede = $this->SafeGetVal($json, 'tpHospede');
			$hospedagem->Quarto = $this->SafeGetVal($json, 'quarto');
			$hospedagem->DtEntrada = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'dtEntrada')));
			$hospedagem->DtSaida = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'dtSaida')));
			$hospedagem->MotivoViagem = $this->SafeGetVal($json, 'motivoViagem');
			$hospedagem->MeioTransporte = $this->SafeGetVal($json, 'meioTransporte');
			$hospedagem->UltimaProcedenciaPais = $this->SafeGetVal($json, 'ultimaProcedenciaPais');
			$hospedagem->UltimaProcedenciaEstado = $this->SafeGetVal($json, 'ultimaProcedenciaEstado');
			$hospedagem->UltimaProcedenciaCidade = $this->SafeGetVal($json, 'ultimaProcedenciaCidade');
			$hospedagem->ProxDestinoPais = $this->SafeGetVal($json, 'proxDestinoPais');
			$hospedagem->ProxDestinoEstado = $this->SafeGetVal($json, 'proxDestinoEstado');
			$hospedagem->ProxDestinoCidade = $this->SafeGetVal($json, 'proxDestinoCidade');

			$hospedagem->Validate();
			$errors = $hospedagem->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$hospedagem->Save();
				$this->RenderJSON($hospedagem, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Hospedagem record and render response as JSON
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
			$hospedagem = $this->Phreezer->Get('Hospedagem',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $hospedagem->Id = $this->SafeGetVal($json, 'id', $hospedagem->Id);

			$hospedagem->Hospede = $this->SafeGetVal($json, 'hospede', $hospedagem->Hospede);
			$hospedagem->TpHospede = $this->SafeGetVal($json, 'tpHospede', $hospedagem->TpHospede);
			$hospedagem->Quarto = $this->SafeGetVal($json, 'quarto', $hospedagem->Quarto);
			$hospedagem->DtEntrada = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'dtEntrada', $hospedagem->DtEntrada)));
			$hospedagem->DtSaida = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'dtSaida', $hospedagem->DtSaida)));
			$hospedagem->MotivoViagem = $this->SafeGetVal($json, 'motivoViagem', $hospedagem->MotivoViagem);
			$hospedagem->MeioTransporte = $this->SafeGetVal($json, 'meioTransporte', $hospedagem->MeioTransporte);
			$hospedagem->UltimaProcedenciaPais = $this->SafeGetVal($json, 'ultimaProcedenciaPais', $hospedagem->UltimaProcedenciaPais);
			$hospedagem->UltimaProcedenciaEstado = $this->SafeGetVal($json, 'ultimaProcedenciaEstado', $hospedagem->UltimaProcedenciaEstado);
			$hospedagem->UltimaProcedenciaCidade = $this->SafeGetVal($json, 'ultimaProcedenciaCidade', $hospedagem->UltimaProcedenciaCidade);
			$hospedagem->ProxDestinoPais = $this->SafeGetVal($json, 'proxDestinoPais', $hospedagem->ProxDestinoPais);
			$hospedagem->ProxDestinoEstado = $this->SafeGetVal($json, 'proxDestinoEstado', $hospedagem->ProxDestinoEstado);
			$hospedagem->ProxDestinoCidade = $this->SafeGetVal($json, 'proxDestinoCidade', $hospedagem->ProxDestinoCidade);

			$hospedagem->Validate();
			$errors = $hospedagem->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$hospedagem->Save();
				$this->RenderJSON($hospedagem, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Hospedagem record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$hospedagem = $this->Phreezer->Get('Hospedagem',$pk);

			$hospedagem->Delete();

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

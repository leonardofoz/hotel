/**
 * View logic for Hospedagens
 */

/**
 * application logic specific to the Hospedagem listing page
 */
var page = {

	hospedagens: new model.HospedagemCollection(),
	collectionView: null,
	hospedagem: null,
	modelView: null,
	isInitialized: false,
	isInitializing: false,

	fetchParams: { filter: '', orderBy: '', orderDesc: '', page: 1 },
	fetchInProgress: false,
	dialogIsOpen: false,

	/**
	 *
	 */
	init: function() {
		// ensure initialization only occurs once
		if (page.isInitialized || page.isInitializing) return;
		page.isInitializing = true;

		if (!$.isReady && console) console.warn('page was initialized before dom is ready.  views may not render properly.');

		// make the new button clickable
		$("#newHospedagemButton").click(function(e) {
			e.preventDefault();
			page.showDetailDialog();
		});

		// let the page know when the dialog is open
		$('#hospedagemDetailDialog').on('show',function() {
			page.dialogIsOpen = true;
		});

		// when the model dialog is closed, let page know and reset the model view
		$('#hospedagemDetailDialog').on('hidden',function() {
			$('#modelAlert').html('');
			page.dialogIsOpen = false;
		});

		// save the model when the save button is clicked
		$("#saveHospedagemButton").click(function(e) {
			e.preventDefault();
			page.updateModel();
		});

		// initialize the collection view
		this.collectionView = new view.CollectionView({
			el: $("#hospedagemCollectionContainer"),
			templateEl: $("#hospedagemCollectionTemplate"),
			collection: page.hospedagens
		});

		// initialize the search filter
		$('#filter').change(function(obj) {
			page.fetchParams.filter = $('#filter').val();
			page.fetchParams.page = 1;
			page.fetchHospedagens(page.fetchParams);
		});
		
		// make the rows clickable ('rendered' is a custom event, not a standard backbone event)
		this.collectionView.on('rendered',function(){

			// attach click handler to the table rows for editing
			$('table.collection tbody tr').click(function(e) {
				e.preventDefault();
				var m = page.hospedagens.get(this.id);
				page.showDetailDialog(m);
			});

			// make the headers clickable for sorting
 			$('table.collection thead tr th').click(function(e) {
 				e.preventDefault();
				var prop = this.id.replace('header_','');

				// toggle the ascending/descending before we change the sort prop
				page.fetchParams.orderDesc = (prop == page.fetchParams.orderBy && !page.fetchParams.orderDesc) ? '1' : '';
				page.fetchParams.orderBy = prop;
				page.fetchParams.page = 1;
 				page.fetchHospedagens(page.fetchParams);
 			});

			// attach click handlers to the pagination controls
			$('.pageButton').click(function(e) {
				e.preventDefault();
				page.fetchParams.page = this.id.substr(5);
				page.fetchHospedagens(page.fetchParams);
			});
			
			page.isInitialized = true;
			page.isInitializing = false;
		});

		// backbone docs recommend bootstrapping data on initial page load, but we live by our own rules!
		this.fetchHospedagens({ page: 1 });

		// initialize the model view
		this.modelView = new view.ModelView({
			el: $("#hospedagemModelContainer")
		});

		// tell the model view where it's template is located
		this.modelView.templateEl = $("#hospedagemModelTemplate");

		if (model.longPollDuration > 0)	{
			setInterval(function () {

				if (!page.dialogIsOpen)	{
					page.fetchHospedagens(page.fetchParams,true);
				}

			}, model.longPollDuration);
		}
	},

	/**
	 * Fetch the collection data from the server
	 * @param object params passed through to collection.fetch
	 * @param bool true to hide the loading animation
	 */
	fetchHospedagens: function(params, hideLoader) {
		// persist the params so that paging/sorting/filtering will play together nicely
		page.fetchParams = params;

		if (page.fetchInProgress) {
			if (console) console.log('supressing fetch because it is already in progress');
		}

		page.fetchInProgress = true;

		if (!hideLoader) app.showProgress('loader');

		page.hospedagens.fetch({

			data: params,

			success: function() {

				if (page.hospedagens.collectionHasChanged) {
					// TODO: add any logic necessary if the collection has changed
					// the sync event will trigger the view to re-render
				}

				app.hideProgress('loader');
				page.fetchInProgress = false;
			},

			error: function(m, r) {
				app.appendAlert(app.getErrorMessage(r), 'alert-error',0,'collectionAlert');
				app.hideProgress('loader');
				page.fetchInProgress = false;
			}

		});
	},

	/**
	 * show the dialog for editing a model
	 * @param model
	 */
	showDetailDialog: function(m) {

		// show the modal dialog
		$('#hospedagemDetailDialog').modal({ show: true });

		// if a model was specified then that means a user is editing an existing record
		// if not, then the user is creating a new record
		page.hospedagem = m ? m : new model.HospedagemModel();

		page.modelView.model = page.hospedagem;

		if (page.hospedagem.id == null || page.hospedagem.id == '') {
			// this is a new record, there is no need to contact the server
			page.renderModelView(false);
		} else {
			app.showProgress('modelLoader');

			// fetch the model from the server so we are not updating stale data
			page.hospedagem.fetch({

				success: function() {
					// data returned from the server.  render the model view
					page.renderModelView(true);
				},

				error: function(m, r) {
					app.appendAlert(app.getErrorMessage(r), 'alert-error',0,'modelAlert');
					app.hideProgress('modelLoader');
				}

			});
		}

	},

	/**
	 * Render the model template in the popup
	 * @param bool show the delete button
	 */
	renderModelView: function(showDeleteButton)	{
		page.modelView.render();

		app.hideProgress('modelLoader');

		// initialize any special controls
		try {
			$('.date-picker')
				.datepicker()
				.on('changeDate', function(ev){
					$('.date-picker').datepicker('hide');
				});
		} catch (error) {
			// this happens if the datepicker input.value isn't a valid date
			if (console) console.log('datepicker error: '+error.message);
		}
		
		$('.timepicker-default').timepicker({ defaultTime: 'value' });

		// populate the dropdown options for hospede
		// TODO: load only the selected value, then fetch all options when the drop-down is clicked
		var hospedeValues = new model.HospedeCollection();
		hospedeValues.fetch({
			success: function(c){
				var dd = $('#hospede');
				dd.append('<option value=""></option>');
				c.forEach(function(item,index) {
					dd.append(app.getOptionHtml(
						item.get('id'),
						item.get('nome'), // TODO: change fieldname if the dropdown doesn't show the desired column
						page.hospedagem.get('hospede') == item.get('id')
					));
				});
				
				if (!app.browserSucks()) {
					dd.combobox();
					$('div.combobox-container + span.help-inline').hide(); // TODO: hack because combobox is making the inline help div have a height
				}

			},
			error: function(collection,response,scope) {
				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
			}
		});

		// populate the dropdown options for quarto
		// TODO: load only the selected value, then fetch all options when the drop-down is clicked
		var quartoValues = new model.QuartoCollection();
		quartoValues.fetch({
			success: function(c){
				var dd = $('#quarto');
				dd.append('<option value=""></option>');
				c.forEach(function(item,index) {
					dd.append(app.getOptionHtml(
						item.get('id'),
						item.get('id'), // TODO: change fieldname if the dropdown doesn't show the desired column
						page.hospedagem.get('quarto') == item.get('id')
					));
				});
				
				if (!app.browserSucks()) {
					dd.combobox();
					$('div.combobox-container + span.help-inline').hide(); // TODO: hack because combobox is making the inline help div have a height
				}

			},
			error: function(collection,response,scope) {
				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
			}
		});

		// populate the dropdown options for motivoViagem
		// TODO: load only the selected value, then fetch all options when the drop-down is clicked
		var motivoViagemValues = new model.Motivo_de_ViagemCollection();
		motivoViagemValues.fetch({
			success: function(c){
				var dd = $('#motivoViagem');
				dd.append('<option value=""></option>');
				c.forEach(function(item,index) {
					dd.append(app.getOptionHtml(
						item.get('id'),
						item.get('descricao'), // TODO: change fieldname if the dropdown doesn't show the desired column
						page.hospedagem.get('motivoViagem') == item.get('id')
					));
				});
				
				if (!app.browserSucks()) {
					dd.combobox();
					$('div.combobox-container + span.help-inline').hide(); // TODO: hack because combobox is making the inline help div have a height
				}

			},
			error: function(collection,response,scope) {
				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
			}
		});

		// populate the dropdown options for meioTransporte
		// TODO: load only the selected value, then fetch all options when the drop-down is clicked
		var meioTransporteValues = new model.Meio_de_TransporteCollection();
		meioTransporteValues.fetch({
			success: function(c){
				var dd = $('#meioTransporte');
				dd.append('<option value=""></option>');
				c.forEach(function(item,index) {
					dd.append(app.getOptionHtml(
						item.get('id'),
						item.get('descricao' ), // TODO: change fieldname if the dropdown doesn't show the desired column
						page.hospedagem.get('meioTransporte') == item.get('id')
					));
				});
				
				if (!app.browserSucks()) {
					dd.combobox();
					$('div.combobox-container + span.help-inline').hide(); // TODO: hack because combobox is making the inline help div have a height
				}

			},
			error: function(collection,response,scope) {
				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
			}
		});

		// populate the dropdown options for ultimaProcedenciaPais
		// TODO: load only the selected value, then fetch all options when the drop-down is clicked
		var ultimaProcedenciaPaisValues = new model.PaisCollection();
		ultimaProcedenciaPaisValues.fetch({
			success: function(c){
				var dd = $('#ultimaProcedenciaPais');
				dd.append('<option value=""></option>');
				c.forEach(function(item,index) {
					dd.append(app.getOptionHtml(
						item.get('id'),
						item.get('nome'), // TODO: change fieldname if the dropdown doesn't show the desired column
						page.hospedagem.get('ultimaProcedenciaPais') == item.get('id')
					));
				});
				
				if (!app.browserSucks()) {
					dd.combobox();
					$('div.combobox-container + span.help-inline').hide(); // TODO: hack because combobox is making the inline help div have a height
				}

			},
			error: function(collection,response,scope) {
				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
			}
		});

		// populate the dropdown options for ultimaProcedenciaEstado
		// TODO: load only the selected value, then fetch all options when the drop-down is clicked
		var ultimaProcedenciaEstadoValues = new model.EstadoCollection();
		ultimaProcedenciaEstadoValues.fetch({
			success: function(c){
				var dd = $('#ultimaProcedenciaEstado');
				dd.append('<option value=""></option>');
				c.forEach(function(item,index) {
					dd.append(app.getOptionHtml(
						item.get('id'),
						item.get('nome'), // TODO: change fieldname if the dropdown doesn't show the desired column
						page.hospedagem.get('ultimaProcedenciaEstado') == item.get('id')
					));
				});
				
				if (!app.browserSucks()) {
					dd.combobox();
					$('div.combobox-container + span.help-inline').hide(); // TODO: hack because combobox is making the inline help div have a height
				}

			},
			error: function(collection,response,scope) {
				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
			}
		});

		// populate the dropdown options for ultimaProcedenciaCidade
		// TODO: load only the selected value, then fetch all options when the drop-down is clicked
		var ultimaProcedenciaCidadeValues = new model.CidadeCollection();
		ultimaProcedenciaCidadeValues.fetch({
			success: function(c){
				var dd = $('#ultimaProcedenciaCidade');
				dd.append('<option value=""></option>');
				c.forEach(function(item,index) {
					dd.append(app.getOptionHtml(
						item.get('id'),
						item.get('cidade_Estado'), // TODO: change fieldname if the dropdown doesn't show the desired column
						page.hospedagem.get('ultimaProcedenciaCidade') == item.get('id')
					));
				});
				
				if (!app.browserSucks()) {
					dd.combobox();
					$('div.combobox-container + span.help-inline').hide(); // TODO: hack because combobox is making the inline help div have a height
				}

			},
			error: function(collection,response,scope) {
				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
			}
		});

		// populate the dropdown options for proxDestinoPais
		// TODO: load only the selected value, then fetch all options when the drop-down is clicked
		var proxDestinoPaisValues = new model.PaisCollection();
		proxDestinoPaisValues.fetch({
			success: function(c){
				var dd = $('#proxDestinoPais');
				dd.append('<option value=""></option>');
				c.forEach(function(item,index) {
					dd.append(app.getOptionHtml(
						item.get('id'),
						item.get('nome'), // TODO: change fieldname if the dropdown doesn't show the desired column
						page.hospedagem.get('proxDestinoPais') == item.get('id')
					));
				});
				
				if (!app.browserSucks()) {
					dd.combobox();
					$('div.combobox-container + span.help-inline').hide(); // TODO: hack because combobox is making the inline help div have a height
				}

			},
			error: function(collection,response,scope) {
				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
			}
		});

		// populate the dropdown options for proxDestinoEstado
		// TODO: load only the selected value, then fetch all options when the drop-down is clicked
		var proxDestinoEstadoValues = new model.EstadoCollection();
		proxDestinoEstadoValues.fetch({
			success: function(c){
				var dd = $('#proxDestinoEstado');
				dd.append('<option value=""></option>');
				c.forEach(function(item,index) {
					dd.append(app.getOptionHtml(
						item.get('id'),
						item.get('nome'), // TODO: change fieldname if the dropdown doesn't show the desired column
						page.hospedagem.get('proxDestinoEstado') == item.get('id')
					));
				});
				
				if (!app.browserSucks()) {
					dd.combobox();
					$('div.combobox-container + span.help-inline').hide(); // TODO: hack because combobox is making the inline help div have a height
				}

			},
			error: function(collection,response,scope) {
				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
			}
		});

		// populate the dropdown options for proxDestinoCidade
		// TODO: load only the selected value, then fetch all options when the drop-down is clicked
		var proxDestinoCidadeValues = new model.CidadeCollection();
		proxDestinoCidadeValues.fetch({
			success: function(c){
				var dd = $('#proxDestinoCidade');
				dd.append('<option value=""></option>');
				c.forEach(function(item,index) {
					dd.append(app.getOptionHtml(
						item.get('id'),
						item.get('nome'), // TODO: change fieldname if the dropdown doesn't show the desired column
						page.hospedagem.get('proxDestinoCidade') == item.get('id')
					));
				});
				
				if (!app.browserSucks()) {
					dd.combobox();
					$('div.combobox-container + span.help-inline').hide(); // TODO: hack because combobox is making the inline help div have a height
				}

			},
			error: function(collection,response,scope) {
				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
			}
		});


		if (showDeleteButton) {
			// attach click handlers to the delete buttons

			$('#deleteHospedagemButton').click(function(e) {
				e.preventDefault();
				$('#confirmDeleteHospedagemContainer').show('fast');
			});

			$('#cancelDeleteHospedagemButton').click(function(e) {
				e.preventDefault();
				$('#confirmDeleteHospedagemContainer').hide('fast');
			});

			$('#confirmDeleteHospedagemButton').click(function(e) {
				e.preventDefault();
				page.deleteModel();
			});

		} else {
			// no point in initializing the click handlers if we don't show the button
			$('#deleteHospedagemButtonContainer').hide();
		}
	},

	/**
	 * update the model that is currently displayed in the dialog
	 */
	updateModel: function() {
		// reset any previous errors
		$('#modelAlert').html('');
		$('.control-group').removeClass('error');
		$('.help-inline').html('');

		// if this is new then on success we need to add it to the collection
		var isNew = page.hospedagem.isNew();

		app.showProgress('modelLoader');

		page.hospedagem.save({

			'hospede': $('select#hospede').val(),
			'tpHospede': $('input#tpHospede').val(),
			'quarto': $('select#quarto').val(),
			'dtEntrada': $('input#dtEntrada').val()+' '+$('input#dtEntrada-time').val(),
			'dtSaida': $('input#dtSaida').val()+' '+$('input#dtSaida-time').val(),
			'motivoViagem': $('select#motivoViagem').val(),
			'meioTransporte': $('select#meioTransporte').val(),
			'ultimaProcedenciaPais': $('select#ultimaProcedenciaPais').val(),
			'ultimaProcedenciaEstado': $('select#ultimaProcedenciaEstado').val(),
			'ultimaProcedenciaCidade': $('select#ultimaProcedenciaCidade').val(),
			'proxDestinoPais': $('select#proxDestinoPais').val(),
			'proxDestinoEstado': $('select#proxDestinoEstado').val(),
			'proxDestinoCidade': $('select#proxDestinoCidade').val()
		}, {
			wait: true,
			success: function(){
				$('#hospedagemDetailDialog').modal('hide');
				setTimeout("app.appendAlert('Hospedagem was sucessfully " + (isNew ? "inserted" : "updated") + "','alert-success',3000,'collectionAlert')",500);
				app.hideProgress('modelLoader');

				// if the collection was initally new then we need to add it to the collection now
				if (isNew) { page.hospedagens.add(page.hospedagem) }

				if (model.reloadCollectionOnModelUpdate) {
					// re-fetch and render the collection after the model has been updated
					page.fetchHospedagens(page.fetchParams,true);
				}
		},
			error: function(model,response,scope){

				app.hideProgress('modelLoader');

				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');

				try {
					var json = $.parseJSON(response.responseText);

					if (json.errors) {
						$.each(json.errors, function(key, value) {
							$('#'+key+'InputContainer').addClass('error');
							$('#'+key+'InputContainer span.help-inline').html(value);
							$('#'+key+'InputContainer span.help-inline').show();
						});
					}
				} catch (e2) {
					if (console) console.log('error parsing server response: '+e2.message);
				}
			}
		});
	},

	/**
	 * delete the model that is currently displayed in the dialog
	 */
	deleteModel: function()	{
		// reset any previous errors
		$('#modelAlert').html('');

		app.showProgress('modelLoader');

		page.hospedagem.destroy({
			wait: true,
			success: function(){
				$('#hospedagemDetailDialog').modal('hide');
				setTimeout("app.appendAlert('The Hospedagem record was deleted','alert-success',3000,'collectionAlert')",500);
				app.hideProgress('modelLoader');

				if (model.reloadCollectionOnModelUpdate) {
					// re-fetch and render the collection after the model has been updated
					page.fetchHospedagens(page.fetchParams,true);
				}
			},
			error: function(model,response,scope) {
				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
				app.hideProgress('modelLoader');
			}
		});
	}
};


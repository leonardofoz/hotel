/**
 * View logic for Hospedes
 */

/**
 * application logic specific to the Hospede listing page
 */
var page = {

	hospedes: new model.HospedeCollection(),
	collectionView: null,
	hospede: null,
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
		$("#newHospedeButton").click(function(e) {
			e.preventDefault();
			page.showDetailDialog();
		});

		// let the page know when the dialog is open
		$('#hospedeDetailDialog').on('show',function() {
			page.dialogIsOpen = true;
		});

		// when the model dialog is closed, let page know and reset the model view
		$('#hospedeDetailDialog').on('hidden',function() {
			$('#modelAlert').html('');
			page.dialogIsOpen = false;
		});

		// save the model when the save button is clicked
		$("#saveHospedeButton").click(function(e) {
			e.preventDefault();
			page.updateModel();
		});

		// initialize the collection view
		this.collectionView = new view.CollectionView({
			el: $("#hospedeCollectionContainer"),
			templateEl: $("#hospedeCollectionTemplate"),
			collection: page.hospedes
		});

		// initialize the search filter
		$('#filter').change(function(obj) {
			page.fetchParams.filter = $('#filter').val();
			page.fetchParams.page = 1;
			page.fetchHospedes(page.fetchParams);
		});
		
		// make the rows clickable ('rendered' is a custom event, not a standard backbone event)
		this.collectionView.on('rendered',function(){

			// attach click handler to the table rows for editing
			$('table.collection tbody tr').click(function(e) {
				e.preventDefault();
				var m = page.hospedes.get(this.id);
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
 				page.fetchHospedes(page.fetchParams);
 			});

			// attach click handlers to the pagination controls
			$('.pageButton').click(function(e) {
				e.preventDefault();
				page.fetchParams.page = this.id.substr(5);
				page.fetchHospedes(page.fetchParams);
			});
			
			page.isInitialized = true;
			page.isInitializing = false;
		});

		// backbone docs recommend bootstrapping data on initial page load, but we live by our own rules!
		this.fetchHospedes({ page: 1 });

		// initialize the model view
		this.modelView = new view.ModelView({
			el: $("#hospedeModelContainer")
		});

		// tell the model view where it's template is located
		this.modelView.templateEl = $("#hospedeModelTemplate");

		if (model.longPollDuration > 0)	{
			setInterval(function () {

				if (!page.dialogIsOpen)	{
					page.fetchHospedes(page.fetchParams,true);
				}

			}, model.longPollDuration);
		}
	},

	/**
	 * Fetch the collection data from the server
	 * @param object params passed through to collection.fetch
	 * @param bool true to hide the loading animation
	 */
	fetchHospedes: function(params, hideLoader) {
		// persist the params so that paging/sorting/filtering will play together nicely
		page.fetchParams = params;

		if (page.fetchInProgress) {
			if (console) console.log('supressing fetch because it is already in progress');
		}

		page.fetchInProgress = true;

		if (!hideLoader) app.showProgress('loader');

		page.hospedes.fetch({

			data: params,

			success: function() {

				if (page.hospedes.collectionHasChanged) {
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
		$('#hospedeDetailDialog').modal({ show: true });

		// if a model was specified then that means a user is editing an existing record
		// if not, then the user is creating a new record
		page.hospede = m ? m : new model.HospedeModel();

		page.modelView.model = page.hospede;

		if (page.hospede.id == null || page.hospede.id == '') {
			// this is a new record, there is no need to contact the server
			page.renderModelView(false);
		} else {
			app.showProgress('modelLoader');

			// fetch the model from the server so we are not updating stale data
			page.hospede.fetch({

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

		// populate the dropdown options for cidade
		// TODO: load only the selected value, then fetch all options when the drop-down is clicked
		var cidadeValues = new model.CidadeCollection();
		cidadeValues.fetch({
			success: function(c){
				var dd = $('#cidade');
				dd.append('<option value=""></option>');
				c.forEach(function(item,index) {
					dd.append(app.getOptionHtml(
						item.get('id'),
						item.get('nome'), // TODO: change fieldname if the dropdown doesn't show the desired column
						page.hospede.get('cidade') == item.get('id')
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

		// populate the dropdown options for estado
		// TODO: load only the selected value, then fetch all options when the drop-down is clicked
		var estadoValues = new model.EstadoCollection();
		estadoValues.fetch({
			success: function(c){
				var dd = $('#estado');
				dd.append('<option value=""></option>');
				c.forEach(function(item,index) {
					dd.append(app.getOptionHtml(
						item.get('id'),
						item.get('nome'), // TODO: change fieldname if the dropdown doesn't show the desired column
						page.hospede.get('estado') == item.get('id')
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

		// populate the dropdown options for pais
		// TODO: load only the selected value, then fetch all options when the drop-down is clicked
		var paisValues = new model.PaisCollection();
		paisValues.fetch({
			success: function(c){
				var dd = $('#pais');
				dd.append('<option value=""></option>');
				c.forEach(function(item,index) {
					dd.append(app.getOptionHtml(
						item.get('id'),
						item.get('nome'), // TODO: change fieldname if the dropdown doesn't show the desired column
						page.hospede.get('pais') == item.get('id')
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

		// populate the dropdown options for tipoDocumento
		// TODO: load only the selected value, then fetch all options when the drop-down is clicked
		var tipoDocumentoValues = new model.Tipo_de_DocumentoCollection();
		tipoDocumentoValues.fetch({
			success: function(c){
				var dd = $('#tipoDocumento');
				dd.append('<option value=""></option>');
				c.forEach(function(item,index) {
					dd.append(app.getOptionHtml(
						item.get('id'),
						item.get('sigla'), // TODO: change fieldname if the dropdown doesn't show the desired column
						page.hospede.get('tipoDocumento') == item.get('id')
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

			$('#deleteHospedeButton').click(function(e) {
				e.preventDefault();
				$('#confirmDeleteHospedeContainer').show('fast');
			});

			$('#cancelDeleteHospedeButton').click(function(e) {
				e.preventDefault();
				$('#confirmDeleteHospedeContainer').hide('fast');
			});

			$('#confirmDeleteHospedeButton').click(function(e) {
				e.preventDefault();
				page.deleteModel();
			});

		} else {
			// no point in initializing the click handlers if we don't show the button
			$('#deleteHospedeButtonContainer').hide();
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
		var isNew = page.hospede.isNew();

		app.showProgress('modelLoader');

		page.hospede.save({

			'nome': $('input#nome').val(),
			'dtNascimento': $('input#dtNascimento').val(),
			'telefone': $('input#telefone').val(),
			'profissao': $('input#profissao').val(),
			'sexo': $('input#sexo').val(),
			'cidade': $('select#cidade').val(),
			'estado': $('select#estado').val(),
			'pais': $('select#pais').val(),
			'cep': $('input#cep').val(),
			'endereco': $('input#endereco').val(),
			'tipoDocumento': $('select#tipoDocumento').val(),
			'numDocumento': $('input#numDocumento').val(),
			'email': $('input#email').val()
		}, {
			wait: true,
			success: function(){
				$('#hospedeDetailDialog').modal('hide');
				setTimeout("app.appendAlert('Hospede was sucessfully " + (isNew ? "inserted" : "updated") + "','alert-success',3000,'collectionAlert')",500);
				app.hideProgress('modelLoader');

				// if the collection was initally new then we need to add it to the collection now
				if (isNew) { page.hospedes.add(page.hospede) }

				if (model.reloadCollectionOnModelUpdate) {
					// re-fetch and render the collection after the model has been updated
					page.fetchHospedes(page.fetchParams,true);
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

		page.hospede.destroy({
			wait: true,
			success: function(){
				$('#hospedeDetailDialog').modal('hide');
				setTimeout("app.appendAlert('The Hospede record was deleted','alert-success',3000,'collectionAlert')",500);
				app.hideProgress('modelLoader');

				if (model.reloadCollectionOnModelUpdate) {
					// re-fetch and render the collection after the model has been updated
					page.fetchHospedes(page.fetchParams,true);
				}
			},
			error: function(model,response,scope) {
				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
				app.hideProgress('modelLoader');
			}
		});
	}
};


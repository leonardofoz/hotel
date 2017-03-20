/**
 * backbone model definitions for Gestão Hoteleira
 */

/**
 * Use emulated HTTP if the server doesn't support PUT/DELETE or application/json requests
 */
Backbone.emulateHTTP = false;
Backbone.emulateJSON = false;

var model = {};

/**
 * long polling duration in miliseconds.  (5000 = recommended, 0 = disabled)
 * warning: setting this to a low number will increase server load
 */
model.longPollDuration = 5000;

/**
 * whether to refresh the collection immediately after a model is updated
 */
model.reloadCollectionOnModelUpdate = true;


/**
 * a default sort method for sorting collection items.  this will sort the collection
 * based on the orderBy and orderDesc property that was used on the last fetch call
 * to the server. 
 */
model.AbstractCollection = Backbone.Collection.extend({
	totalResults: 0,
	totalPages: 0,
	currentPage: 0,
	pageSize: 0,
	orderBy: '',
	orderDesc: false,
	lastResponseText: null,
	lastRequestParams: null,
	collectionHasChanged: true,
	
	/**
	 * fetch the collection from the server using the same options and 
	 * parameters as the previous fetch
	 */
	refetch: function() {
		this.fetch({ data: this.lastRequestParams })
	},
	
	/* uncomment to debug fetch event triggers
	fetch: function(options) {
            this.constructor.__super__.fetch.apply(this, arguments);
	},
	// */
	
	/**
	 * client-side sorting baesd on the orderBy and orderDesc parameters that
	 * were used to fetch the data from the server.  Backbone ignores the
	 * order of records coming from the server so we have to sort them ourselves
	 */
	comparator: function(a,b) {
		
		var result = 0;
		var options = this.lastRequestParams;
		
		if (options && options.orderBy) {
			
			// lcase the first letter of the property name
			var propName = options.orderBy.charAt(0).toLowerCase() + options.orderBy.slice(1);
			var aVal = a.get(propName);
			var bVal = b.get(propName);
			
			if (isNaN(aVal) || isNaN(bVal)) {
				// treat comparison as case-insensitive strings
				aVal = aVal ? aVal.toLowerCase() : '';
				bVal = bVal ? bVal.toLowerCase() : '';
			} else {
				// treat comparision as a number
				aVal = Number(aVal);
				bVal = Number(bVal);
			}
			
			if (aVal < bVal) {
				result = options.orderDesc ? 1 : -1;
			} else if (aVal > bVal) {
				result = options.orderDesc ? -1 : 1;
			}
		}
		
		return result;

	},
	/**
	 * override parse to track changes and handle pagination
	 * if the server call has returned page data
	 */
	parse: function(response, options) {

		// the response is already decoded into object form, but it's easier to
		// compary the stringified version.  some earlier versions of backbone did
		// not include the raw response so there is some legacy support here
		var responseText = options && options.xhr ? options.xhr.responseText : JSON.stringify(response);
		this.collectionHasChanged = (this.lastResponseText != responseText);
		this.lastRequestParams = options ? options.data : undefined;
		
		// if the collection has changed then we need to force a re-sort because backbone will
		// only resort the data if a property in the model has changed
		if (this.lastResponseText && this.collectionHasChanged) this.sort({ silent:true });
		
		this.lastResponseText = responseText;
		
		var rows;

		if (response.currentPage) {
			rows = response.rows;
			this.totalResults = response.totalResults;
			this.totalPages = response.totalPages;
			this.currentPage = response.currentPage;
			this.pageSize = response.pageSize;
			this.orderBy = response.orderBy;
			this.orderDesc = response.orderDesc;
		} else {
			rows = response;
			this.totalResults = rows.length;
			this.totalPages = 1;
			this.currentPage = 1;
			this.pageSize = this.totalResults;
			this.orderBy = response.orderBy;
			this.orderDesc = response.orderDesc;
		}

		return rows;
	}
});

/**
 * Cidade Backbone Model
 */
model.CidadeModel = Backbone.Model.extend({
	urlRoot: 'api/cidade',
	idAttribute: 'id',
	id: '',
	nome: '',
    cidade_Estado: '',
	estado: '',
	defaults: {
		'id': null,
		'nome': '',
		'estado': ''
	}
});

/**
 * Cidade Backbone Collection
 */
model.CidadeCollection = model.AbstractCollection.extend({
	url: 'api/cidades',
	model: model.CidadeModel
});

/**
 * Estado Backbone Model
 */
model.EstadoModel = Backbone.Model.extend({
	urlRoot: 'api/estado',
	idAttribute: 'id',
	id: '',
	nome: '',
	uf: '',
	pais: '',
	defaults: {
		'id': null,
		'nome': '',
		'uf': '',
		'pais': ''
	}
});

/**
 * Estado Backbone Collection
 */
model.EstadoCollection = model.AbstractCollection.extend({
	url: 'api/estados',
	model: model.EstadoModel
});

/**
 * Hospedagem Backbone Model
 */
model.HospedagemModel = Backbone.Model.extend({
	urlRoot: 'api/hospedagem',
	idAttribute: 'id',
	id: '',
	hospede: '',
    nome_hospede: '',
	tpHospede: '',
	quarto: '',
	dtEntrada: '',
	dtSaida: '',
	motivoViagem: '',
	meioTransporte: '',
	ultimaProcedenciaPais: '',
	ultimaProcedenciaEstado: '',
	ultimaProcedenciaCidade: '',
	proxDestinoPais: '',
	proxDestinoEstado: '',
	proxDestinoCidade: '',
	defaults: {
		'id': null,
		'hospede': '',
		'tpHospede': '',
		'quarto': '',
		'dtEntrada': new Date(),
		'dtSaida': new Date(),
		'motivoViagem': '',
		'meioTransporte': '',
		'ultimaProcedenciaPais': '',
		'ultimaProcedenciaEstado': '',
		'ultimaProcedenciaCidade': '',
		'proxDestinoPais': '',
		'proxDestinoEstado': '',
		'proxDestinoCidade': ''
	}
});

/**
 * Hospedagem Backbone Collection
 */
model.HospedagemCollection = model.AbstractCollection.extend({
	url: 'api/hospedagens',
	model: model.HospedagemModel
});

/**
 * Hospede Backbone Model
 */
model.HospedeModel = Backbone.Model.extend({
	urlRoot: 'api/hospede',
	idAttribute: 'id',
	id: '',
	nome: '',
	dtNascimento: '',
	telefone: '',
	profissao: '',
	sexo: '',
	cidade: '',
	estado: '',
	pais: '',
	cep: '',
	endereco: '',
	tipoDocumento: '',
	numDocumento: '',
	email: '',
	defaults: {
		'id': null,
		'nome': '',
		'dtNascimento': new Date(),
		'telefone': '',
		'profissao': '',
		'sexo': '',
		'cidade': '',
		'estado': '',
		'pais': '',
		'cep': '',
		'endereco': '',
		'tipoDocumento': '',
		'numDocumento': '',
		'email': ''
	}
});

/**
 * Hospede Backbone Collection
 */
model.HospedeCollection = model.AbstractCollection.extend({
	url: 'api/hospedes',
	model: model.HospedeModel
});

/**
 * Meio_de_Transporte Backbone Model
 */
model.Meio_de_TransporteModel = Backbone.Model.extend({
	urlRoot: 'api/meio_de_transporte',
	idAttribute: 'id',
	id: '',
	descricao: '',
	description: '',
	defaults: {
		'id': null,
		'descricao': '',
		'description': ''
	}
});

/**
 * Meio_de_Transporte Backbone Collection
 */
model.Meio_de_TransporteCollection = model.AbstractCollection.extend({
	url: 'api/meios_de_transporte',
	model: model.Meio_de_TransporteModel
});

/**
 * Motivo_de_Viagem Backbone Model
 */
model.Motivo_de_ViagemModel = Backbone.Model.extend({
	urlRoot: 'api/motivo_de_viagem',
	idAttribute: 'id',
	id: '',
	descricao: '',
	description: '',
	defaults: {
		'id': null,
		'descricao': '',
		'description': ''
	}
});

/**
 * Motivo_de_Viagem Backbone Collection
 */
model.Motivo_de_ViagemCollection = model.AbstractCollection.extend({
	url: 'api/motivos_de_viagem',
	model: model.Motivo_de_ViagemModel
});

/**
 * Pais Backbone Model
 */
model.PaisModel = Backbone.Model.extend({
	urlRoot: 'api/pais',
	idAttribute: 'id',
	id: '',
	nome: '',
	name: '',
	defaults: {
		'id': null,
		'nome': '',
		'name': ''
	}
});

/**
 * Pais Backbone Collection
 */
model.PaisCollection = model.AbstractCollection.extend({
	url: 'api/paises',
	model: model.PaisModel
});

/**
 * Quarto Backbone Model
 */
model.QuartoModel = Backbone.Model.extend({
	urlRoot: 'api/quarto',
	idAttribute: 'id',
	id: '',
	numQuarto: '',
	maxHospede: '',
	defaults: {
		'id': null,
		'numQuarto': '',
		'maxHospede': ''
	}
});

/**
 * Quarto Backbone Collection
 */
model.QuartoCollection = model.AbstractCollection.extend({
	url: 'api/quartos',
	model: model.QuartoModel
});

/**
 * Tipo_de_Documento Backbone Model
 */
model.Tipo_de_DocumentoModel = Backbone.Model.extend({
	urlRoot: 'api/tipo_de_documento',
	idAttribute: 'id',
	id: '',
	sigla: '',
	nome: '',
	defaults: {
		'id': null,
		'sigla': '',
		'nome': ''
	}
});

/**
 * Tipo_de_Documento Backbone Collection
 */
model.Tipo_de_DocumentoCollection = model.AbstractCollection.extend({
	url: 'api/tipo_de_documentos',
	model: model.Tipo_de_DocumentoModel
});


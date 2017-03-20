<?php
	$this->assign('title','Gestão Hoteleira | Hospedagens');
	$this->assign('nav','hospedagens');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/hospedagens.js").wait(function(){
		$(document).ready(function(){
			page.init();
		});
		
		// hack for IE9 which may respond inconsistently with document.ready
		setTimeout(function(){
			if (!page.isInitialized) page.init();
		},1000);
	});
</script>

<div class="container">

<h1>
	<i class="icon-th-list"></i> Hospedagens
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="hospedagemCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Hospede">Hospede<% if (page.orderBy == 'Hospede') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_TpHospede">Tp Hospede<% if (page.orderBy == 'TpHospede') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Quarto">Quarto<% if (page.orderBy == 'Quarto') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_DtEntrada">Dt Entrada<% if (page.orderBy == 'DtEntrada') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                <th id="header_DtSaida">Dt Saida<% if (page.orderBy == 'DtSaida') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<th id="header_MotivoViagem">Motivo Viagem<% if (page.orderBy == 'MotivoViagem') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_MeioTransporte">Meio Transporte<% if (page.orderBy == 'MeioTransporte') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_UltimaProcedenciaPais">Ultima Procedencia Pais<% if (page.orderBy == 'UltimaProcedenciaPais') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_UltimaProcedenciaEstado">Ultima Procedencia Estado<% if (page.orderBy == 'UltimaProcedenciaEstado') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_UltimaProcedenciaCidade">Ultima Procedencia Cidade<% if (page.orderBy == 'UltimaProcedenciaCidade') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_ProxDestinoPais">Prox Destino Pais<% if (page.orderBy == 'ProxDestinoPais') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_ProxDestinoEstado">Prox Destino Estado<% if (page.orderBy == 'ProxDestinoEstado') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_ProxDestinoCidade">Prox Destino Cidade<% if (page.orderBy == 'ProxDestinoCidade') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
-->
			</tr>
		</thead>
		<tbody>
        
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('id')) %>">
				<td><%= _.escape(item.get('id') || '') %></td>
				<td><%= _.escape(item.get('nome_Hospede') || '') %></td>
				<td><%= _.escape(item.get('tpHospede') || '') %></td>
				<td><%= _.escape(item.get('quarto') || '') %></td>
				<td><%if (item.get('dtEntrada')) { %><%= _date(app.parseDate(item.get('dtEntrada'))).format('DD MMM YYYY hh:mm A') %><% } else { %>NULL<% } %></td>
                <td><%if (item.get('dtSaida')) { %><%= _date(app.parseDate(item.get('dtSaida'))).format('DD MMM YYYY hh:mm A') %><% } else { %>NULL<% } %></td>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<td><%= _.escape(item.get('motivoViagem') || '') %></td>
				<td><%= _.escape(item.get('meioTransporte') || '') %></td>
				<td><%= _.escape(item.get('ultimaProcedenciaPais') || '') %></td>
				<td><%= _.escape(item.get('ultimaProcedenciaEstado') || '') %></td>
				<td><%= _.escape(item.get('ultimaProcedenciaCidade') || '') %></td>
				<td><%= _.escape(item.get('proxDestinoPais') || '') %></td>
				<td><%= _.escape(item.get('proxDestinoEstado') || '') %></td>
				<td><%= _.escape(item.get('proxDestinoCidade') || '') %></td>
-->
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="hospedagemModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="hospedeInputContainer" class="control-group">
					<label class="control-label" for="hospede">Hospede</label>
					<div class="controls inline-inputs">
						<select id="hospede" name="hospede"></select>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="tpHospedeInputContainer" class="control-group">
					<label class="control-label" for="tpHospede">Tipo</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="tpHospede" value="<%= _.escape(item.get('tpHospede') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="quartoInputContainer" class="control-group">
					<label class="control-label" for="quarto">Quarto</label>
					<div class="controls inline-inputs">
						<select id="quarto" name="quarto"></select>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="dtEntradaInputContainer" class="control-group">
					<label class="control-label" for="dtEntrada">Data de Entrada</label>
					<div class="controls inline-inputs">
						<div class="input-append date date-picker" data-date-format="dd/mm/yyyy">
							<input id="dtEntrada" type="text" value="<%= _date(app.parseDate(item.get('dtEntrada'))).format('DD/MM/YYYY') %>" />
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
						<div class="input-append bootstrap-timepicker-component">
							<input id="dtEntrada-time" type="text" class="timepicker-default input-small" value="<%= _date(app.parseDate(item.get('dtEntrada'))).format('h:mm A') %>" />
							<span class="add-on"><i class="icon-time"></i></span>
						</div>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="dtSaidaInputContainer" class="control-group">
					<label class="control-label" for="dtSaida">Data de Saída</label>
					<div class="controls inline-inputs">
						<div class="input-append date date-picker" data-date-format="dd/mm/yyyy">
							<input id="dtSaida" type="text" value="<%= _date(app.parseDate(item.get('dtSaida'))).format('DD/MM/YYYY') %>" />
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
						<div class="input-append bootstrap-timepicker-component">
							<input id="dtSaida-time" type="text" class="timepicker-default input-small" value="<%= _date(app.parseDate(item.get('dtSaida'))).format('h:mm A') %>" />
							<span class="add-on"><i class="icon-time"></i></span>
						</div>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="motivoViagemInputContainer" class="control-group">
					<label class="control-label" for="motivoViagem">Motivo da Viagem</label>
					<div class="controls inline-inputs">
						<select id="motivoViagem" name="motivoViagem"></select>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="meioTransporteInputContainer" class="control-group">
					<label class="control-label" for="meioTransporte">Meio de Transporte</label>
					<div class="controls inline-inputs">
						<select id="meioTransporte" name="meioTransporte"></select>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="ultimaProcedenciaPaisInputContainer" class="control-group">
					<label class="control-label" for="ultimaProcedenciaPais">Procedência País</label>
					<div class="controls inline-inputs">
						<select id="ultimaProcedenciaPais" name="ultimaProcedenciaPais"></select>
						<span class="help-inline"></span>
					</div>
				</div>
                <div id="ultimaProcedenciaEstadoInputContainer" class="control-group">
					<label class="control-label" for="ultimaProcedenciaEstado">Procedência Estado</label>
					<div class="controls inline-inputs">
						<select id="ultimaProcedenciaEstado" name="ultimaProcedenciaEstado"></select>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="ultimaProcedenciaCidadeInputContainer" class="control-group">
					<label class="control-label" for="ultimaProcedenciaCidade">Procedência Cidade</label>
					<div class="controls inline-inputs">
						<select id="ultimaProcedenciaCidade" name="ultimaProcedenciaCidade"></select>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="proxDestinoPaisInputContainer" class="control-group">
					<label class="control-label" for="proxDestinoPais">Destino Pais</label>
					<div class="controls inline-inputs">
						<select id="proxDestinoPais" name="proxDestinoPais"></select>
						<span class="help-inline"></span>
					</div>
				</div>
                <div id="proxDestinoEstadoInputContainer" class="control-group">
					<label class="control-label" for="proxDestinoEstado">Destino Estado</label>
					<div class="controls inline-inputs">
						<select id="proxDestinoEstado" name="proxDestinoEstado"></select>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="proxDestinoCidadeInputContainer" class="control-group">
					<label class="control-label" for="proxDestinoCidade">Destino Cidade</label>
					<div class="controls inline-inputs">
						<select id="proxDestinoCidade" name="proxDestinoCidade"></select>
						<span class="help-inline"></span>
					</div>
				</div>
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteHospedagemButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteHospedagemButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Hospedagem</button>
						<span id="confirmDeleteHospedagemContainer" class="hide">
							<button id="cancelDeleteHospedagemButton" class="btn btn-mini">Cancelar</button>
							<button id="confirmDeleteHospedagemButton" class="btn btn-mini btn-danger">Confirmar</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="hospedagemDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit Hospedagem
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="hospedagemModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancelar</button>
			<button id="saveHospedagemButton" class="btn btn-primary">Salvar mudanças</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="hospedagemCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newHospedagemButton" class="btn btn-primary">Adicionar Hospedagem</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>

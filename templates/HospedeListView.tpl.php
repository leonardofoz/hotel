<?php
	$this->assign('title','Gestão Hoteleira | Hospedes');
	$this->assign('nav','hospedes');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/hospedes.js").wait(function(){
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
	<i class="icon-th-list"></i> Hospedes
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="hospedeCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Nome">Nome<% if (page.orderBy == 'Nome') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_DtNascimento">Dt Nascimento<% if (page.orderBy == 'DtNascimento') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Telefone">Telefone<% if (page.orderBy == 'Telefone') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Profissao">Profissao<% if (page.orderBy == 'Profissao') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<th id="header_Sexo">Sexo<% if (page.orderBy == 'Sexo') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Cidade">Cidade<% if (page.orderBy == 'Cidade') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Estado">Estado<% if (page.orderBy == 'Estado') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Pais">Pais<% if (page.orderBy == 'Pais') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Cep">Cep<% if (page.orderBy == 'Cep') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Endereco">Endereco<% if (page.orderBy == 'Endereco') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_TipoDocumento">Tipo Documento<% if (page.orderBy == 'TipoDocumento') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_NumDocumento">Num Documento<% if (page.orderBy == 'NumDocumento') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Email">Email<% if (page.orderBy == 'Email') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
-->
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('id')) %>">
				<td><%= _.escape(item.get('id') || '') %></td>
				<td><%= _.escape(item.get('nome') || '') %></td>
				<td><%if (item.get('dtNascimento')) { %><%= _date(app.parseDate(item.get('dtNascimento'))).format('DD/MM/YYYY') %><% } else { %>NULL<% } %></td>
				<td><%= _.escape(item.get('telefone') || '') %></td>
				<td><%= _.escape(item.get('profissao') || '') %></td>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<td><%= _.escape(item.get('sexo') || '') %></td>
				<td><%= _.escape(item.get('cidade') || '') %></td>
				<td><%= _.escape(item.get('estado') || '') %></td>
				<td><%= _.escape(item.get('pais') || '') %></td>
				<td><%= _.escape(item.get('cep') || '') %></td>
				<td><%= _.escape(item.get('endereco') || '') %></td>
				<td><%= _.escape(item.get('tipoDocumento') || '') %></td>
				<td><%= _.escape(item.get('numDocumento') || '') %></td>
				<td><%= _.escape(item.get('email') || '') %></td>
-->
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="hospedeModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="nomeInputContainer" class="control-group">
					<label class="control-label" for="nome">Nome</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="nome" placeholder="Nome" value="<%= _.escape(item.get('nome') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="dtNascimentoInputContainer" class="control-group">
					<label class="control-label" for="dtNascimento">Dt Nascimento</label>
					<div class="controls inline-inputs">
						<div class="input-append date date-picker" data-date-format="yyyy-mm-dd">
							<input id="dtNascimento" type="text" value="<%= _date(app.parseDate(item.get('dtNascimento'))).format('YYYY-MM-DD') %>" />
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="telefoneInputContainer" class="control-group">
					<label class="control-label" for="telefone">Telefone</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="telefone" placeholder="Telefone" value="<%= _.escape(item.get('telefone') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="profissaoInputContainer" class="control-group">
					<label class="control-label" for="profissao">Profissao</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="profissao" placeholder="Profissao" value="<%= _.escape(item.get('profissao') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="sexoInputContainer" class="control-group">
					<label class="control-label" for="sexo">Sexo</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="sexo" placeholder="Sexo" value="<%= _.escape(item.get('sexo') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="cidadeInputContainer" class="control-group">
					<label class="control-label" for="cidade">Cidade</label>
					<div class="controls inline-inputs">
						<select id="cidade" name="cidade"></select>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="estadoInputContainer" class="control-group">
					<label class="control-label" for="estado">Estado</label>
					<div class="controls inline-inputs">
						<select id="estado" name="estado"></select>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="paisInputContainer" class="control-group">
					<label class="control-label" for="pais">Pais</label>
					<div class="controls inline-inputs">
						<select id="pais" name="pais"></select>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="cepInputContainer" class="control-group">
					<label class="control-label" for="cep">Cep</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="cep" placeholder="Cep" value="<%= _.escape(item.get('cep') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="enderecoInputContainer" class="control-group">
					<label class="control-label" for="endereco">Endereco</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="endereco" placeholder="Endereco" value="<%= _.escape(item.get('endereco') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="tipoDocumentoInputContainer" class="control-group">
					<label class="control-label" for="tipoDocumento">Tipo Documento</label>
					<div class="controls inline-inputs">
						<select id="tipoDocumento" name="tipoDocumento"></select>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="numDocumentoInputContainer" class="control-group">
					<label class="control-label" for="numDocumento">Num Documento</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="numDocumento" placeholder="Num Documento" value="<%= _.escape(item.get('numDocumento') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="emailInputContainer" class="control-group">
					<label class="control-label" for="email">Email</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="email" placeholder="Email" value="<%= _.escape(item.get('email') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteHospedeButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteHospedeButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Hospede</button>
						<span id="confirmDeleteHospedeContainer" class="hide">
							<button id="cancelDeleteHospedeButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteHospedeButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="hospedeDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit Hospede
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="hospedeModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveHospedeButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="hospedeCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newHospedeButton" class="btn btn-primary">Add Hospede</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>

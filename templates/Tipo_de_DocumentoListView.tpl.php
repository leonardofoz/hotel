<?php
	$this->assign('title','Gestão Hoteleira | Tipo_de_Documentos');
	$this->assign('nav','tipo_de_documentos');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/tipo_de_documentos.js").wait(function(){
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
	<i class="icon-th-list"></i> Tipo_de_Documentos
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="tipo_de_DocumentoCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Sigla">Sigla<% if (page.orderBy == 'Sigla') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Nome">Nome<% if (page.orderBy == 'Nome') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('id')) %>">
				<td><%= _.escape(item.get('id') || '') %></td>
				<td><%= _.escape(item.get('sigla') || '') %></td>
				<td><%= _.escape(item.get('nome') || '') %></td>
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="tipo_de_DocumentoModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="siglaInputContainer" class="control-group">
					<label class="control-label" for="sigla">Sigla</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="sigla" placeholder="Sigla" value="<%= _.escape(item.get('sigla') || '') %>">
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
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteTipo_de_DocumentoButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteTipo_de_DocumentoButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Tipo_de_Documento</button>
						<span id="confirmDeleteTipo_de_DocumentoContainer" class="hide">
							<button id="cancelDeleteTipo_de_DocumentoButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteTipo_de_DocumentoButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="tipo_de_DocumentoDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit Tipo_de_Documento
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="tipo_de_DocumentoModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveTipo_de_DocumentoButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="tipo_de_DocumentoCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newTipo_de_DocumentoButton" class="btn btn-primary">Add Tipo_de_Documento</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>

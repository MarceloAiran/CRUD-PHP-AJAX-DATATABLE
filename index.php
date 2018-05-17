<!DOCTYPE html>
	<head>
		<title>Marcelo Airan - GitHub</title>
		<meta charset="utf-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>		
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<style>
			body
			{
				margin:0;
				padding:0;
				background-color:#f1f1f1;
			}
			.box
			{
				width:1270px;
				padding:20px;
				background-color:#fff;
				border:1px solid #ccc;
				border-radius:5px;
				margin-top:25px;
			}
		</style>
	</head>
	<body>
		<div class="container box">
			<h1 align="center">PHP PDO MySQL Ajax CRUD com Data Tables e Bootstrap Modals</h1>
			<br />
			<div class="table-responsive">
				<br />
				<div align="right">
					<button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-info btn-lg">Add</button>
				</div>
				<br /><br />
				<table id="user_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="10%">Foto</th>
							<th width="35%">Nome</th>
							<th width="35%">Sobre Nome</th>
							<th width="10%">Editar</th>
							<th width="10%">Delete</th>
						</tr>
					</thead>
				</table>
				
			</div>
		</div>
	</body>
</html>

<div id="userModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="user_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Adicionar Usuario</h4>
				</div>
				<div class="modal-body">
					<label>Digite Seu Nome</label>
					<input type="text" name="nome" id="nome" class="form-control" />
					<br />
					<label>Digite Seu Sobre Nome</label>
					<input type="text" name="sobre_nome" id="sobre_nome" class="form-control" />
					<br />
					<label>Escolha Sua Foto</label>
					<input type="file" name="imagem_usuario" id="imagem_usuario" />
					<span id="user_uploaded_image"></span>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="usuario_id" id="usuario_id" />
					<input type="hidden" name="operacao" id="operacao" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
	
	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').text("Adicionar Usuário");
		$('#action').val("Add");
		$('#operacao').val("Add");
		$('#user_uploaded_image').html('');
	});
	
	var dataTable = $('#user_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"buscar.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[0, 3, 4],
				"orderable":false,
			},
		],
		"oLanguage": {
                    "sProcessing":   "Processando...",
                    "sLengthMenu":   "Mostrar _MENU_ registros",
                    "sZeroRecords":  "Não foram encontrados resultados",
                    "sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty":    "Mostrando de 0 até 0 de 0 registros",
                    "sInfoFiltered": "",
                    "sInfoPostFix":  "",
                    "sSearch":       "Buscar:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "Primeiro",
                        "sPrevious": "Anterior",
                        "sNext":     "Seguinte",
                        "sLast":     "Último"
                    }
                },

	});



	$(document).on('submit', '#user_form', function(event){
		event.preventDefault();
		var nome = $('#nome').val();
		var sobre_nome = $('#sobre_nome').val();
		var etx = $('#imagem_usuario').val().split('.').pop().toLowerCase();
		if(etx != '')
		{
			if(jQuery.inArray(etx, ['gif','png','jpg','jpeg']) == -1)
			{
				alert("Formato da imagem inválido");
				$('#imagem_usuario').val('');
				return false;
			}
		}	
		if(nome != '' && sobre_nome != '')
		{
			$.ajax({
				url:"inserir_alterar.php",
				method:'POST',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
					alert(data);
					$('#user_form')[0].reset();
					$('#userModal').modal('hide');
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			alert("Nome e Sobre Nome, Obrigatórios");
		}
	});
	
	$(document).on('click', '.update', function(){
		var usuario_id = $(this).attr("id");
		$.ajax({
			url:"busca_unica.php",
			method:"POST",
			data:{usuario_id:usuario_id},
			dataType:"json",
			success:function(data)
			{
				$('#userModal').modal('show');
				$('#nome').val(data.nome);
				$('#sobre_nome').val(data.sobre_nome);
				$('.modal-title').text("Edit User");
				$('#usuario_id').val(usuario_id);
				$('#user_uploaded_image').html(data.imagem_usuario);
				$('#action').val("Edit");
				$('#operacao').val("Edit");
			}
		})
	});
	
	$(document).on('click', '.delete', function(){
		var usuario_id = $(this).attr("id");
		if(confirm("Tem certeza que deseja excluir esse Usuario ?"))
		{
			$.ajax({
				url:"delete.php",
				method:"POST",
				data:{usuario_id:usuario_id},
				success:function(data)
				{
					alert(data);
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			return false;	
		}
	});
	
	
});
</script>
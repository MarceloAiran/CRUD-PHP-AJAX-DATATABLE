<?php
include('db.php');
include('funcoes.php');
if(isset($_POST["usuario_id"]))
{
	$saida = array();
	
	$statement = $connection->prepare(
		"SELECT * FROM usuarios 
		WHERE id = '".$_POST["usuario_id"]."' 
		LIMIT 1"
	);
	
	$statement->execute();
	$resultado = $statement->fetchAll();
	
	foreach($resultado as $linha)
	{
		$saida["nome"] = $linha["nome"];
		$saida["sobre_nome"] = $linha["sobre_nome"];
		if($linha["imagem"] != '')
		{
			$saida['imagem_usuario'] = '<img src="upload/'.$linha["imagem"].'" class="img-thumbnail" width="50" height="35" /><input type="hidden" name="hidden_usuario_imagem" value="'.$linha["imagem"].'" />';
		}
		else
		{
			$saida['imagem_usuario'] = '<input type="hidden" name="hidden_usuario_imagem" value="" />';
		}
	}
	echo json_encode($saida);
}
?>
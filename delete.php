<?php

include('db.php');
include("funcoes.php");

if(isset($_POST["usuario_id"]))
{
	$imagem = get_imagem_nome($_POST["usuario_id"]);
	
	if($imagem != '')
	{
		unlink("upload/" . $imagem);
	}
	
	$statement = $connection->prepare(
		"DELETE FROM usuarios WHERE id = :id"
	);
	$resultado = $statement->execute(
		array(
			':id'	=>	$_POST["usuario_id"]
		)
	);
	
	if(!empty($resultado))
	{
		echo 'Usuario Deletado';
	}
}



?>
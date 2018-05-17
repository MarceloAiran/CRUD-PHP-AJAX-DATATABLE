<?php
include('db.php');
include('funcoes.php');
if(isset($_POST["operacao"]))
{
	if($_POST["operacao"] == "Add")
	{
		$imagem = '';
		if($_FILES["imagem_usuario"]["name"] != '')
		{
			$imagem = upload_imagem();
		}
		
		$statement = $connection->prepare("
			INSERT INTO usuarios (nome, sobre_nome, imagem) 
			VALUES (:nome, :sobre_nome, :imagem)
		");
		
		$resultado = $statement->execute(
			array(
				':nome'	=>	$_POST["nome"],
				':sobre_nome'	=>	$_POST["sobre_nome"],
				':imagem'		=>	$imagem
			)
		);
		if(!empty($resultado))
		{
			echo 'Usuario inserido com sucesso !';
		}
	}
	if($_POST["operacao"] == "Edit")
	{
		
		$imagem = '';

		if($_FILES["imagem_usuario"]["name"] != '')
		{
			$imagem = upload_imagem();
		}
		else
		{
			$imagem = $_POST["hidden_usuario_imagem"];
		}
		$statement = $connection->prepare(
			"UPDATE usuarios 
			SET nome = :nome, sobre_nome = :sobre_nome, imagem = :imagem  
			WHERE id = :id
			"
		);
		$resultado = $statement->execute(
			array(
				':nome'	=>	$_POST["nome"],
				':sobre_nome'	=>	$_POST["sobre_nome"],
				':imagem'		=>	$imagem,
				':id'			=>	$_POST["usuario_id"]
			)
		);
		if(!empty($resultado))
		{
			echo 'Usuario alterado com sucesso !';
		}
	}
}

?>
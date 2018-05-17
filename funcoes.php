<?php

function upload_imagem()
{
	if(isset($_FILES["imagem_usuario"]))
	{
		$extensao = explode('.', $_FILES['imagem_usuario']['name']);
		$novo_nome = rand() . '.' . $extensao[1];
		$destino = './upload/' . $novo_nome;
		move_uploaded_file($_FILES['imagem_usuario']['tmp_name'], $destino);
		return $novo_nome;
	}
}

function get_imagem_nome($usuario_id)
{
	include('db.php');
	$statement = $connection->prepare("SELECT imagem FROM usuarios WHERE id = '$usuario_id'");
	$statement->execute();
	$resultado = $statement->fetchAll();
	foreach($resultado as $linha)
	{
		return $linha["imagem"];
	}
}

function get_total_registros()
{
	include('db.php');
	$statement = $connection->prepare("SELECT * FROM usuarios");
	$statement->execute();
	$resultado = $statement->fetchAll();
	return $statement->rowCount();
}

?>
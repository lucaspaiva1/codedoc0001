<?php
	include 'mySQL.php';
	require 'mySQL.php';
?>

<?php
	
	$the_request = &$_POST;

	$postdata = file_get_contents("php://input");
	
	if (isset($postdata)){
		$request  = json_decode($postdata);
		$nome     = $request->nome;
		$email	  = $request->email;
		$login 	  = $request->login;
		$senha 	  = $request->senha;
		$acesso	  = $request->acesso;
		$admissao = $request->dataAdmissao;
		$telefone = $request->telefone;
		$ativo 	  = 0;

		$sql = "SELECT * FROM usuario WHERE login = '$login'";
		$result = $con->query($sql);
		
		$numrow = $result->num_rows;
			if($numrow !== 1 && $nome != ""){
				$sql = "SELECT * FROM usuario WHERE email = '$email'";
				$result = $con->query($sql);
				$numrow = $result->num_rows;
				if ($numrow !== 1){
					$sql = "INSERT INTO usuario (nome, email, login, senha, acesso, dataAdmissao, telefone, ativo) VALUES ('$nome', '$email', '$login', '$senha', '$acesso', '$admissao', '$telefone', '$ativo')";
					$con->query($sql);
					echo json_encode(true);
				} else {
					echo json_encode("email");
				}
			}else{
				echo json_encode("login");
			}
	}
?>
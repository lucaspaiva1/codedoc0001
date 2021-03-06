<?php
	include 'mySQL.php';
	require 'mySQL.php';

?>

<?php

	$the_request = &$_GET;

	if (isset($_GET['email'])){

		$email = $_GET['email'];

		$sql = "SELECT * FROM usuario WHERE email = '$email'";
		$result = $con->query($sql);

		$numrow = $result->num_rows;
			if($numrow !== 1){
				echo json_encode(false);
			}else{
				$dados    = $result->fetch_assoc();
				$nome     = $dados['nome'];
				$login    = $dados['login'];
				$senha    = $dados['senha'];
				$assunto  = "DS OUTLET - RECUPERAR SENHA";

				$mensagem = "<!DOCTYPE html>
				<html>

				<head>
				    <meta charset='utf-8'>
				    <title>Email de Recuperação</title>
				    <style media='screen'>
				        .header {
				            border-top-left-radius: 5px;
				            border-top-right-radius: 5px;
				            background-color: #03A9F4;
				            padding: 10px;
				            text-align: center;
				        }

				        .body {
				            border-top-width: thin;
				            border-top-style: solid;
				            border-bottom-width: thin;
				            border-bottom-style: solid;
				            border-color: #e6e6e6;
				            padding: 20px;
				            font-family: Arial;
				        }

				        .link {
				            color: black;
				            text-decoration: none;
				        }

				        .dados {
				            color: white;
				            border-radius: 5px;
				            background-color: #0D47A1;
				            padding-top: 20px;
				            padding-bottom: 20px;
				            padding-left: 5px;
				            width: 50%;
				        }
				    </style>
				</head>

				<body style='width: 500px'>
				    <header class='header'>
				        <img src='logoH.png' width='250px'>
				    </header>
				    <div class='body'>
				        <h3>Olá $nome,</h3>
				        <p>Foi solicitado recentemente a recuperação dos dados de acesso ao gerenciador <b> <a class='link' href='http://www.codebro.pe.hu'>DsOutlet</a></b>.</p>
				        <br> Seguem os dados:
				        <br><br>
				        <div class='dados'>
				            <b style='margin-right: 5px;'>Usuário:</b>$login
				            <br>
				            <b style='margin-right: 16px;'>Senha:</b>$senha
				        </div>
				        <br><br>
				        <b style='color: #4b4b4b'>Não solicitou esta Recuperação?</b>

				        <p style='font-size: 14px'>Se você não solicitou a recuperação dos dados ignore esta mensagem.</p>
				    </div>
				    <p style='font-size: 10px; color:#616161; font-family: Arial; margin-left: 5px'>Essa mensagem foi enviada para $email a seu pedido. <br> DsOutlet - Av. Evência Brito, 450 - Ribeira do Pombal - BA (75) 93623-0001
				    </p>
				</body>

				</html>";

				$header = "MIME-Version: 1.0\n";
				$header .= "Content-type: text/html; charset=UTF-8 charset=iso-8859-1\n";
				$header .= "FROM: no-reply@dsoutlet.com\n";
				mail($email, $assunto, $mensagem, $header);
				echo json_encode(true);
			}
	} else{
		echo json_encode(false);
	}
?>

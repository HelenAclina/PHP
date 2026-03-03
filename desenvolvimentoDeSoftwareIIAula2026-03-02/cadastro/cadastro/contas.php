<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Contas - PHP</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <form class="cadastro" name="frm_cadastro" method="post">
         
        <div class="form">
            <h1>Cadastro Contas</h1>
             

            <label for="nome">Usuario: </label>
            <input type="text" name="txt_usuario" size="30" id="nome">

            <label for="email">Email: </label>
            <input type="text" name="txt_email" size="60" id="email">

            <label for="senha">Senha: </label>
            <input type="password" name="txt_senha" size="10" id="senha">
            <label for="senha">Confirmar Senha: </label>
            <input type="password" name="txt_csenha" size="10" id="senha">
       
            <br>
            <input type="submit" value="Cadastrar" onclick="document.frm_cadastro.action='criar.php'" class="enviar">
			<input type="submit" value="Login" onclick="document.form1.action='login.php'" class="enviar">


               
        </div>

      </form>

</body>
</html>
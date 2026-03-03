<?php 

    include 'conexao.php';
    $usuario = $_POST ["txt_usuario"];
    $email = $_POST ["txt_email"];
    $senha = $_POST ["txt_senha"];
    $csenha = $_POST ["txt_csenha"];
      
    if ($senha != $csenha) {
         echo "<center>";
		 echo "<hr>";
		 echo "SENHAS NAO CONFEREM!!!"; 
         echo "<hr>";
		 echo "<br>";
		 echo "<a href=\"contas.php\">VOLTAR </a>";
         return;
    }

    $sql =mysql_query ("SELECT * FROM tb_contas
                        WHERE usuario='$usuario'
                        OR email='$email'");

    if (mysql_num_rows($sql) > 0) {
         echo "<center>";
		 echo "<hr>";
		 echo "CONTA JA CADASTRADA!!!!"; 
         echo "<hr>";
		 echo "<br>";
		 echo "<a href=\"contas.php\">VOLTAR </a>";

    } else {
        $sql=mysql_query ("INSERT INTO tb_contas
                        (usuario,email,senha) 
                        VALUES ('$usuario', '$email', '$senha')");
         echo "<center>";
		 echo "<hr>";
		 echo "CONTA CADASTRADA COM SUCESSO!"; 
         echo "<hr>";
		 echo "<br>";
		 echo "<a href=\"contas.php\">VOLTAR </a>";
    }

?>
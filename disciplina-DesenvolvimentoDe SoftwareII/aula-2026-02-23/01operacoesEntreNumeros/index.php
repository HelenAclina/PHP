<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Exercício 1 - Operações Básicas</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>


    <h1>Operações Básicas</h1>

    <form method="POST" action="">
        <label>Digite o primeiro número:</label>
        <input type="number" name="numero1" required>

        <label>Digite o segundo número:</label>
        <input type="number" name="numero2" required>

        <input type="submit" value="Calcular">

    </form>


    <!--  LÓGICA PHP  -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // AGORA USA OS MESMOS NOMES DO FORMULÁRIO!
        $num1 = $_POST['numero1'];  // 'numero1' igual ao name do input
        $num2 = $_POST['numero2'];  // 'numero2' igual ao name do input
    
        // Cálculos
        $soma = $num1 + $num2;
        $subtracao = $num1 - $num2;
        $multiplicacao = $num1 * $num2;

        if ($num2 != 0) {
            $divisao = $num1 / $num2;
        } else {
            $divisao = "Não é possível dividir por zero";
        }

        // Resultados
        echo "<hr>";
        echo "<h3>Resultados:</h3>";
        echo "<p>Soma: $num1 + $num2 = $soma</p>";
        echo "<p>Subtração: $num1 - $num2 = $subtracao</p>";
        echo "<p>Multiplicação: $num1 x $num2 = $multiplicacao</p>";
        echo "<p>Divisão: $num1 ÷ $num2 = $divisao</p>";
    }
    ?>

    <br><a href="../main_index.php"><br><br>
        <a href="../index.php"
            style="display: block; text-align: center; color: #3498db; font-weight: bold; text-decoration: none; font-size: 1.1rem; margin: 20px 0;">
            ← Voltar ao Menu Principal
        </a></a>

</body>

</html>
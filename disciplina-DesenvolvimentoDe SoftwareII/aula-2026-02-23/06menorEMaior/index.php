<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Exercício 6 - Maior e Menor Número</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1> Maior e Menor Número</h1>

        <form method="POST" action="">
            <div class="campo">
                <label for="num1"> Primeiro número:</label>
                <input type="number" name="num1" id="num1" step="any" required>
            </div>

            <div class="campo">
                <label for="num2"> Segundo número:</label>
                <input type="number" name="num2" id="num2" step="any" required>
            </div>

            <div class="campo">
                <label for="num3"> Terceiro número:</label>
                <input type="number" name="num3" id="num3" step="any" required>
            </div>

            <input type="submit" value="Comparar Números">
        </form>

        <?php
        // Verifica se o formulário foi enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Pega os três números digitados
            $num1 = $_POST['num1'];
            $num2 = $_POST['num2'];
            $num3 = $_POST['num3'];

            // Encontra o maior e o menor número
            $maior = $num1;
            $menor = $num1;

            // Verifica o maior
            if ($num2 > $maior)
                $maior = $num2;
            if ($num3 > $maior)
                $maior = $num3;

            // Verifica o menor
            if ($num2 < $menor)
                $menor = $num2;
            if ($num3 < $menor)
                $menor = $num3;

            // Formata os números (sem casas decimais se for inteiro)
            $num1_format = (floor($num1) == $num1) ? $num1 : number_format($num1, 2, ',', '.');
            $num2_format = (floor($num2) == $num2) ? $num2 : number_format($num2, 2, ',', '.');
            $num3_format = (floor($num3) == $num3) ? $num3 : number_format($num3, 2, ',', '.');

            // Exibe os resultados
            echo "<div class='resultado'>";
            echo "<h3> Resultados</h3>";

            echo "<div class='numeros-grid'>";
            echo "<div class='numero-box'>$num1_format</div>";
            echo "<div class='numero-box'>$num2_format</div>";
            echo "<div class='numero-box'>$num3_format</div>";
            echo "</div>";

            echo "<div class='comparacao'>";
            echo "<div class='maior-card'>";
            echo "<span class='label'> MAIOR</span>";
            echo "<span class='valor'>$maior</span>";
            echo "</div>";

            echo "<div class='menor-card'>";
            echo "<span class='label'> MENOR</span>";
            echo "<span class='valor'>$menor</span>";
            echo "</div>";
            echo "</div>";

            // Mostra a ordem crescente
            $numeros = array($num1, $num2, $num3);
            sort($numeros);
            echo "<div class='ordem'>";
            echo "<p> Ordem crescente:</p>";
            echo "<p class='crescente'>";
            echo "<span>" . $numeros[0] . "</span>  <span>≤</span>  ";
            echo "<span>" . $numeros[1] . "</span>  <span>≤</span>  ";
            echo "<span>" . $numeros[2] . "</span>";
            echo "</p>";
            echo "</div>";

            echo "</div>";
        }
        ?>

        <div class="voltar">
            <a href="../main_index.php"> <br><br>
                <a href="../index.php"
                    style="display: block; text-align: center; color: #3498db; font-weight: bold; text-decoration: none; font-size: 1.1rem; margin: 20px 0;">
                    ← Voltar ao Menu Principal
                </a></a>
        </div>
    </div>
</body>

</html>
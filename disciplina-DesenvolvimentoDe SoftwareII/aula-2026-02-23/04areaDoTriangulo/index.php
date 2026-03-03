<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Exercício 4 - Área do Triângulo</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Área do Triângulo</h1>

        <form method="POST" action="">
            <div class="campo">
                <label for="base">Digite o valor da base:</label>
                <input type="number" name="base" id="base" step="0.01" required>
            </div>

            <div class="campo">
                <label for="altura">Digite o valor da altura:</label>
                <input type="number" name="altura" id="altura" step="0.01" required>
            </div>

            <input type="submit" value="Calcular Área">
        </form>

        <?php
        // Verifica se o formulário foi enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Pega os valores digitados
            $base = $_POST['base'];
            $altura = $_POST['altura'];

            // Calcula a área do triângulo: (base × altura) / 2
            $area = ($base * $altura) / 2;

            // Formata os números para mostrar com 2 casas decimais
            $base_formatada = number_format($base, 2, ',', '.');
            $altura_formatada = number_format($altura, 2, ',', '.');
            $area_formatada = number_format($area, 2, ',', '.');

            // Exibe os resultados
            echo "<div class='resultado'>";
            echo "<h3>Resultados:</h3>";
            echo "<p>Base: <strong>$base_formatada</strong></p>";
            echo "<p>Altura: <strong>$altura_formatada</strong></p>";
            echo "<p>Área do triângulo: <strong>$area_formatada</strong></p>";


        }
        ?>

        <div class="voltar">
            <a href="../index.php"
                style="display: block; text-align: center; color: #3498db; font-weight: bold; text-decoration: none; font-size: 1.1rem; margin: 20px 0;">
                ← Voltar ao Menu Principal
            </a></a>
        </div>
    </div>
</body>

</html>
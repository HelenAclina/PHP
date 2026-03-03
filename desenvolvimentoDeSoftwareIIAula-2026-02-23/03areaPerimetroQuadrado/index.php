<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Exercício 3 - Área e Perímetro do Quadrado</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Área e Perímetro do Quadrado</h1>

        <form method="POST" action="">
            <div class="campo">
                <label for="lado">Digite o valor do lado:</label>
                <input type="number" name="lado" id="lado" step="0.01" required>
            </div>

            <input type="submit" value="Calcular">
        </form>

        <?php
        // Verifica se o formulário foi enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Pega o valor do lado digitado
            $lado = $_POST['lado'];

            // Cálculos
            $area = $lado * $lado;        // Área = lado²
            $perimetro = 4 * $lado;        // Perímetro = 4 × lado
        
            // Formata os números para mostrar com 2 casas decimais
            $area_formatada = number_format($area, 2, ',', '.');
            $perimetro_formatado = number_format($perimetro, 2, ',', '.');

            // Exibe os resultados
            echo "<div class='resultado'>";
            echo "<h3>Resultados:</h3>";
            echo "<p>Lado do quadrado: <strong>" . number_format($lado, 2, ',', '.') . "</strong></p>";
            echo "<p>Área: <strong>$area_formatada</strong></p>";
            echo "<p>Perímetro: <strong>$perimetro_formatado</strong></p>";

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
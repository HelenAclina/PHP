<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Exercício 2 - Antecessor e Sucessor</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1> Antecessor e Sucessor</h1>

        <form method="POST" action="">
            <div class="campo">
                <label for="numero">Digite um número inteiro:</label>
                <input type="number" name="numero" id="numero" step="1" required>
            </div>

            <input type="submit" value="Calcular">
        </form>

        <?php
        // Verifica se o formulário foi enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Pega o valor digitado no campo "numero"
            $numero = $_POST['numero'];

            // Calcula antecessor (número - 1) e sucessor (número + 1)
            $antecessor = $numero - 1;
            $sucessor = $numero + 1;

            // Exibe os resultados
            echo "<div class='resultado'>";
            echo "<h3>Resultados:</h3>";
            echo "<p>Número digitado: <strong>$numero</strong></p>";
            echo "<p>Antecessor: <strong>$antecessor</strong></p>";
            echo "<p>Sucessor: <strong>$sucessor</strong></p>";

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
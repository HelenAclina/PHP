<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercício 7 - Média do Aluno</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            padding: 40px 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 480px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 1.8rem;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #495057;
        }

        input[type="number"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 1.1rem;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1.1rem;
            cursor: pointer;
        }

        button:hover {
            background: #218838;
        }

        .resultado {
            margin-top: 30px;
            padding: 20px;
            background: #f1f3f5;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            text-align: center;
        }

        .resultado h2 {
            margin-bottom: 15px;
            color: #343a40;
        }

        .aprovado {
            color: #28a745;
            font-weight: bold;
            font-size: 1.4rem;
        }

        .recuperacao {
            color: #fd7e14;
            font-weight: bold;
            font-size: 1.3rem;
        }

        .reprovado {
            color: #dc3545;
            font-weight: bold;
            font-size: 1.3rem;
        }

        .erro {
            color: #dc3545;
            padding: 15px;
            background: #f8d7da;
            border-radius: 6px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Média do Aluno</h1>

        <form method="post" action="">
            <label>Nota 1 (0 a 10):</label>
            <input type="number" name="nota1" step="0.1" min="0" max="10" required placeholder="Ex: 7.5">

            <label>Nota 2 (0 a 10):</label>
            <input type="number" name="nota2" step="0.1" min="0" max="10" required placeholder="Ex: 8.0">

            <label>Nota 3 (0 a 10):</label>
            <input type="number" name="nota3" step="0.1" min="0" max="10" required placeholder="Ex: 6.5">

            <button type="submit">Calcular Média</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $n1 = filter_input(INPUT_POST, 'nota1', FILTER_VALIDATE_FLOAT);
            $n2 = filter_input(INPUT_POST, 'nota2', FILTER_VALIDATE_FLOAT);
            $n3 = filter_input(INPUT_POST, 'nota3', FILTER_VALIDATE_FLOAT);

            if (
                $n1 === false || $n2 === false || $n3 === false ||
                $n1 < 0 || $n1 > 10 || $n2 < 0 || $n2 > 10 || $n3 < 0 || $n3 > 10
            ) {
                echo '<div class="resultado erro">Insira notas válidas entre 0 e 10.</div>';
            } else {
                $media = ($n1 + $n2 + $n3) / 3;
                $media_format = number_format($media, 1, ',', '.');

                echo '<div class="resultado">';
                echo '<h2>Resultados</h2>';
                echo '<p>Notas: ' . number_format($n1, 1, ',', '.') . ' | '
                    . number_format($n2, 1, ',', '.') . ' | '
                    . number_format($n3, 1, ',', '.') . '</p>';
                echo '<p>Média: <strong>' . $media_format . '</strong></p>';

                if ($media >= 6) {
                    echo '<p class="aprovado">APROVADO! 🎉</p>';
                } elseif ($media >= 4) {
                    echo '<p class="recuperacao">RECUPERAÇÃO 📝</p>';
                } else {
                    echo '<p class="reprovado">REPROVADO! ❌</p>';
                }
                echo '</div>';
            }
        }
        ?>


        <div class="voltar">
            <a href="../main_index.php"><br><br>
                <a href="../index.php"
                    style="display: block; text-align: center; color: #3498db; font-weight: bold; text-decoration: none; font-size: 1.1rem; margin: 20px 0;">
                    ← Voltar ao Menu Principal
                </a></a>
            </>
            </di>
</body>

</html>
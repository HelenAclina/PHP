<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Exercício 8 - Folha de Pagamento</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Folha de Pagamento</h1>

    <div class="info">
        <p>Salário Mínimo: R$ 1.621,00</p>
    </div>

    <form method="POST">
        <label>Nome do Funcionário:</label>
        <input type="text" name="nome" required>

        <label>Quantidade de Salários Mínimos:</label>
        <input type="number" step="0.1" min="0" name="qtd_salarios" required>

        <input type="submit" value="Calcular Folha">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'];
        $qtd_salarios = $_POST['qtd_salarios'];
        $salario_minimo = 1621.00;

        $salario_bruto = $salario_minimo * $qtd_salarios;

        // Calcular INSS
        if ($salario_bruto <= 1621.00) {
            $aliquota = 7.5;
            $inss = $salario_bruto * 0.075;
        } elseif ($salario_bruto <= 2902.84) {
            $aliquota = 9;
            $inss = $salario_bruto * 0.09;
        } elseif ($salario_bruto <= 4354.27) {
            $aliquota = 12;
            $inss = $salario_bruto * 0.12;
        } else {
            $aliquota = 14;
            $inss = $salario_bruto * 0.14;
        }

        $salario_liquido = $salario_bruto - $inss;


        echo "<p>Funcionário: $nome</p>";
        echo "<p>Salário Bruto: R$ " . number_format($salario_bruto, 2, ',', '.') . "</p>";
        echo "<p>INSS ($aliquota%): R$ " . number_format($inss, 2, ',', '.') . "</p>";
        echo "<p><strong>Salário Líquido: R$ " . number_format($salario_liquido, 2, ',', '.') . "</strong></p>";
    }
    ?>

    <br><a href="../main_index.php"><br><br>
        <a href="../index.php"
            style="display: block; text-align: center; color: #3498db; font-weight: bold; text-decoration: none; font-size: 1.1rem; margin: 20px 0;">
            ← Voltar ao Menu Principal
        </a></a>
</body>

</html>
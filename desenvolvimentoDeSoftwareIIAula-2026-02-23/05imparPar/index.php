<?php
$tipo = '';
$classe = '';
$numero = null;
$erro = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $numero = filter_input(INPUT_POST, 'numero', FILTER_VALIDATE_INT);

    if ($numero === false || $numero === null) {
        $erro = 'Digite um número válido.';
    } else {
        $tipo = ($numero % 2 === 0) ? 'PAR' : 'ÍMPAR';
        $classe = ($numero % 2 === 0) ? 'par' : 'impar';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercício 5 - Par ou Ímpar</title>
    <link rel="stylesheet" href="exercicio5.css">
</head>
<body>
    <div class="container">
        <h1>Par ou Ímpar?</h1>

        <form method="post" action="">
            <label>Digite um número inteiro:</label>
            <input type="number" name="numero" step="1" required placeholder="Ex: 42">
            <button type="submit">Verificar</button>
        </form>

        <?php if ($erro): ?>
            <div class="resultado">
                <p class="impar"><?= $erro ?></p>
            </div>
        <?php elseif ($tipo): ?>
            <div class="resultado">
                <h2>Resultado</h2>
                <p>O número <strong><?= $numero ?></strong> é <span class="<?= $classe ?>"><?= $tipo ?></span>!</p>
            </div>
        <?php endif; ?>

        <div class="voltar">
            <a href="../index.php">← Voltar ao Menu Principal</a>
        </div>
    </div>
</body>
</html>
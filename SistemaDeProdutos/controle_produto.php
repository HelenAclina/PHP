<?php
require_once 'db.php';

$msg  = '';
$tipo = '';

/* ===================== CADASTRAR ===================== */
if (isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {
    $descricao    = trim($conn->real_escape_string($_POST['descricao']));
    $categoria_id = (int) $_POST['categoria_id'];
    $valor_compra = (float) str_replace(',', '.', $_POST['valor_compra']);
    $valor_venda  = (float) str_replace(',', '.', $_POST['valor_venda']);
    $qtd_estoque  = (int) $_POST['qtd_estoque'];

    if (!$descricao || $categoria_id <= 0 || $valor_compra <= 0 || $valor_venda <= 0 || $qtd_estoque < 0) {
        $msg  = 'Preencha todos os campos corretamente.';
        $tipo = 'error';
    } elseif ($valor_venda < $valor_compra) {
        $msg  = 'Valor de venda não pode ser menor que o de compra.';
        $tipo = 'error';
    } else {
        $sql = "INSERT INTO produtos (descricao, categoria_id, valor_compra, valor_venda, qtd_estoque)
                VALUES ('$descricao', $categoria_id, $valor_compra, $valor_venda, $qtd_estoque)";
        if ($conn->query($sql)) {
            $msg  = 'Produto cadastrado com sucesso!';
            $tipo = 'success';
        } else {
            $msg  = 'Erro ao cadastrar: ' . $conn->error;
            $tipo = 'error';
        }
    }
}

/* ===================== VENDER ===================== */
if (isset($_POST['acao']) && $_POST['acao'] === 'vender') {
    $produto_id = (int) $_POST['produto_id'];
    $qtd        = (int) $_POST['qtd'];

    $res = $conn->query("SELECT descricao, qtd_estoque FROM produtos WHERE id = $produto_id");
    $p   = $res->fetch_assoc();

    if (!$p) {
        $msg = 'Produto não encontrado.'; $tipo = 'error';
    } elseif ($qtd <= 0) {
        $msg = 'Quantidade inválida.'; $tipo = 'error';
    } elseif ($qtd > $p['qtd_estoque']) {
        $msg = 'Estoque insuficiente. Disponível: ' . $p['qtd_estoque']; $tipo = 'error';
    } else {
        $novo = $p['qtd_estoque'] - $qtd;
        $conn->query("UPDATE produtos SET qtd_estoque = $novo WHERE id = $produto_id");
        $msg  = "Venda realizada! {$qtd}x {$p['descricao']} vendido(s).";
        $tipo = 'success';
    }
}

/* ===================== EXCLUIR ===================== */
if (isset($_GET['excluir'])) {
    $id = (int) $_GET['excluir'];
    $conn->query("DELETE FROM produtos WHERE id = $id");
    $msg  = 'Produto excluído.';
    $tipo = 'success';
}

/* ===================== BUSCAR ===================== */
$filtro = isset($_GET['filtro']) ? trim($conn->real_escape_string($_GET['filtro'])) : '';

$where = '';
if ($filtro !== '') {
    $where = "WHERE p.descricao LIKE '%$filtro%' OR c.nome LIKE '%$filtro%'";
}

$sql_prod = "SELECT p.id, p.descricao, c.nome AS categoria,
                    p.valor_compra, p.valor_venda, p.qtd_estoque,
                    (p.valor_venda - p.valor_compra) AS lucro_unit
             FROM produtos p
             INNER JOIN categorias c ON c.id = p.categoria_id
             $where
             ORDER BY p.descricao";

$produtos = $conn->query($sql_prod)->fetch_all(MYSQLI_ASSOC);

$categorias = $conn->query("SELECT id, nome FROM categorias ORDER BY nome")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Produto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <?php if ($msg): ?>
        <div class="alert alert-<?= $tipo ?>"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <!-- ========== CADASTRO ========== -->
    <div class="card">
        <div class="section-title">
            📦 Cadastro de Produto
        </div>

        <form method="POST" id="form-cadastro">
            <input type="hidden" name="acao" value="cadastrar">

            <div class="form-row">
                <div class="form-group">
                    <label>Descrição</label>
                    <input type="text" name="descricao" placeholder="Ex: Notebook Samsung">
                </div>
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="categoria_id">
                        <option value="">Selecione...</option>
                        <?php foreach ($categorias as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Valor Compra (R$)</label>
                    <input type="text" id="valor_compra" name="valor_compra" placeholder="R$ 0,00">
                </div>
                <div class="form-group">
                    <label>Valor Venda (R$)</label>
                    <input type="text" id="valor_venda" name="valor_venda" placeholder="R$ 0,00">
                </div>
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label>Qtd. Estoque</label>
                    <input type="number" name="qtd_estoque" placeholder="0" min="0" value="0">
                </div>
                <div></div>
            </div>

            <div class="btn-row">
                <button type="submit" class="btn btn-blue">💾 CADASTRAR PRODUTO</button>
                <a href="#inventario" class="btn btn-green">🛒 VENDER PRODUTO</a>
            </div>
        </form>
    </div>

    <!-- ========== INVENTÁRIO ========== -->
    <div class="card" id="inventario">
        <div class="inv-header">
            <div class="section-title">📋 Inventário</div>
            <form method="GET" style="display:flex;gap:0;">
                <div class="search-wrap">
                    <input type="text" name="filtro"
                           value="<?= htmlspecialchars($filtro) ?>"
                           placeholder="pesquisar por descrição ou categoria">
                    <button type="submit">🔍</button>
                </div>
            </form>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Venda</th>
                        <th>Lucro Unit.</th>
                        <th>Estoque</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($produtos)): ?>
                    <tr>
                        <td colspan="6" style="text-align:center;padding:28px;color:#888;">
                            Nenhum produto encontrado.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($produtos as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['descricao']) ?></td>
                        <td><?= htmlspecialchars($p['categoria']) ?></td>
                        <td>R$ <?= number_format($p['valor_venda'], 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($p['lucro_unit'], 2, ',', '.') ?></td>
                        <td><?= $p['qtd_estoque'] ?></td>
                        <td>
                            <button class="btn btn-green" style="padding:5px 12px;font-size:12px;"
                                onclick="abrirVenda(<?= $p['id'] ?>, '<?= htmlspecialchars($p['descricao'], ENT_QUOTES) ?>', <?= $p['qtd_estoque'] ?>)">
                                🛒 Vender
                            </button>
                            &nbsp;
                            <a href="?excluir=<?= $p['id'] ?><?= $filtro ? '&filtro='.urlencode($filtro) : '' ?>"
                               onclick="return confirm('Excluir <?= htmlspecialchars($p['descricao'], ENT_QUOTES) ?>?')"
                               class="btn-red">✖</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div><!-- /container -->

<!-- ========== MODAL VENDA ========== -->
<div class="overlay" id="overlay">
    <div class="modal">
        <h3>🛒 Realizar Venda</h3>
        <p class="sub" id="v_estoque"></p>
        <p style="font-weight:bold;margin-bottom:18px;" id="v_nome"></p>

        <form method="POST">
            <input type="hidden" name="acao" value="vender">
            <input type="hidden" name="produto_id" id="v_produto_id">

            <div class="form-group" style="margin-bottom:20px;">
                <label>Quantidade</label>
                <input type="number" name="qtd" id="v_qtd" min="1" value="1">
            </div>

            <div class="modal-btns">
                <button type="button" class="btn-outline" onclick="fecharModal()">Cancelar</button>
                <button type="submit" class="btn btn-green">✔ Confirmar</button>
            </div>
        </form>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>

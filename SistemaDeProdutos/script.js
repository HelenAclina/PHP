// Máscara de moeda
function maskMoney(input) {
    input.addEventListener('input', function () {
        var v = this.value.replace(/\D/g, '');
        if (!v) { this.value = ''; return; }
        v = (parseInt(v, 10) / 100).toFixed(2);
        this.value = 'R$ ' + v.replace('.', ',').replace(/(\d)(?=(\d{3})+,)/g, '$1.');
    });
}

maskMoney(document.getElementById('valor_compra'));
maskMoney(document.getElementById('valor_venda'));

// Remove máscara antes de enviar
document.getElementById('form-cadastro').addEventListener('submit', function () {
    ['valor_compra', 'valor_venda'].forEach(function (id) {
        var el = document.getElementById(id);
        el.value = el.value.replace(/[R$\s.]/g, '').replace(',', '.');
    });
});

// Modal de venda
function abrirVenda(id, nome, estoque) {
    document.getElementById('v_produto_id').value = id;
    document.getElementById('v_nome').textContent  = nome;
    document.getElementById('v_estoque').textContent = 'Estoque disponível: ' + estoque;
    document.getElementById('v_qtd').value = 1;
    document.getElementById('v_qtd').max   = estoque;
    document.getElementById('overlay').classList.add('show');
}

function fecharModal() {
    document.getElementById('overlay').classList.remove('show');
}

document.getElementById('overlay').addEventListener('click', function (e) {
    if (e.target === this) fecharModal();
});

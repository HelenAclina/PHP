/* ============================================================
   db — Store de dados em memória
   Ao integrar com PHP: substitua cada método por fetch() à sua API.
============================================================ */
const db = {
  clientes:     [],
  pets:         [],
  servicos:     [],
  agendamentos: [],
  _seq: { c: 1, p: 1, s: 1, a: 1 },
  nextId(k) { return this._seq[k]++; },
};

/* ============================================================
   ui — Helpers reutilizáveis de interface
============================================================ */
const ui = {

  // Modal
  open(id)  { document.getElementById(id).classList.add('open'); },
  close(id) { document.getElementById(id).classList.remove('open'); },

  // Formulário
  clear(...ids) {
    ids.forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
  },
  fill(map) {
    Object.entries(map).forEach(([id, val]) => {
      const el = document.getElementById(id);
      if (el) el.value = val ?? '';
    });
  },
  populateSelect(selectId, items, labelFn) {
    document.getElementById(selectId).innerHTML =
      items.map(i => `<option value="${i.id}">${labelFn(i)}</option>`).join('');
  },

  // Tabela
  emptyRow: (cols, msg) =>
    `<tr><td class="td-empty" colspan="${cols}">${msg}</td></tr>`,

  actionBtns: (editFn, delFn, id) => `
    <div class="actions-cell">
      <button class="icon-btn edit" onclick="${editFn}(${id})" title="Editar">✏️</button>
      <button class="icon-btn del"  onclick="${delFn}(${id})"  title="Excluir">🗑️</button>
    </div>`,

  // Contadores do home
  updateCounters() {
    document.getElementById('cnt-clientes').textContent     = db.clientes.length;
    document.getElementById('cnt-pets').textContent         = db.pets.length;
    document.getElementById('cnt-servicos').textContent     = db.servicos.length;
    document.getElementById('cnt-agendamentos').textContent = db.agendamentos.length;
  },

  // Banner de aviso
  toggleWarning(bannerId, btnId, show) {
    document.getElementById(bannerId).classList.toggle('visible', show);
    document.getElementById(btnId).className = show ? 'btn btn-disabled' : 'btn btn-primary';
  },
};

/* ============================================================
   Clientes — CRUD
============================================================ */
const Clientes = {

  novo() {
    document.getElementById('modal-cliente-title').textContent = 'Novo Cliente';
    ui.clear('cliente-edit-id','cliente-nome','cliente-tel','cliente-email');
    ui.open('modal-cliente');
  },

  salvar() {
    const nome  = document.getElementById('cliente-nome').value.trim();
    const tel   = document.getElementById('cliente-tel').value.trim();
    const email = document.getElementById('cliente-email').value.trim();
    if (!nome) { alert('Informe o nome do cliente.'); return; }

    const editId = document.getElementById('cliente-edit-id').value;
    if (editId) {
      const c = db.clientes.find(x => x.id == editId);
      if (c) Object.assign(c, { nome, tel, email });
    } else {
      db.clientes.push({ id: db.nextId('c'), nome, tel, email });
    }
    ui.close('modal-cliente');
    this.render();
    ui.updateCounters();
  },

  editar(id) {
    const c = db.clientes.find(x => x.id === id);
    if (!c) return;
    document.getElementById('modal-cliente-title').textContent = 'Editar Cliente';
    ui.fill({ 'cliente-edit-id': c.id, 'cliente-nome': c.nome, 'cliente-tel': c.tel, 'cliente-email': c.email });
    ui.open('modal-cliente');
  },

  excluir(id) {
    if (!confirm('Excluir este cliente?')) return;
    db.clientes = db.clientes.filter(x => x.id !== id);
    this.render();
    ui.updateCounters();
  },

  render() {
    const tbody = document.getElementById('tbody-clientes');
    if (!db.clientes.length) {
      tbody.innerHTML = ui.emptyRow(4, 'Nenhum cliente cadastrado. Clique em "Novo Cliente" para começar.');
      return;
    }
    tbody.innerHTML = db.clientes.map(c => `
      <tr>
        <td>${c.nome}</td>
        <td>${c.tel   || '—'}</td>
        <td>${c.email || '—'}</td>
        <td>${ui.actionBtns('Clientes.editar','Clientes.excluir', c.id)}</td>
      </tr>`).join('');
  },
};

/* ============================================================
   Pets — CRUD
============================================================ */
const Pets = {

  novo() {
    if (!db.clientes.length) { alert('Cadastre pelo menos um cliente antes de adicionar pets.'); return; }
    document.getElementById('modal-pet-title').textContent = 'Novo Pet';
    ui.clear('pet-edit-id','pet-nome','pet-raca','pet-idade');
    ui.populateSelect('pet-dono', db.clientes, c => c.nome);
    ui.open('modal-pet');
  },

  salvar() {
    const nome   = document.getElementById('pet-nome').value.trim();
    const raca   = document.getElementById('pet-raca').value.trim();
    const idade  = document.getElementById('pet-idade').value.trim();
    const donoId = parseInt(document.getElementById('pet-dono').value);
    if (!nome) { alert('Informe o nome do pet.'); return; }

    const editId = document.getElementById('pet-edit-id').value;
    if (editId) {
      const p = db.pets.find(x => x.id == editId);
      if (p) Object.assign(p, { nome, raca, idade, donoId });
    } else {
      db.pets.push({ id: db.nextId('p'), nome, raca, idade, donoId });
    }
    ui.close('modal-pet');
    this.render();
    ui.updateCounters();
  },

  editar(id) {
    const p = db.pets.find(x => x.id === id);
    if (!p) return;
    document.getElementById('modal-pet-title').textContent = 'Editar Pet';
    ui.populateSelect('pet-dono', db.clientes, c => c.nome);
    ui.fill({ 'pet-edit-id': p.id, 'pet-nome': p.nome, 'pet-raca': p.raca, 'pet-idade': p.idade, 'pet-dono': p.donoId });
    ui.open('modal-pet');
  },

  excluir(id) {
    if (!confirm('Excluir este pet?')) return;
    db.pets = db.pets.filter(x => x.id !== id);
    this.render();
    ui.updateCounters();
  },

  render() {
    const tbody = document.getElementById('tbody-pets');
    ui.toggleWarning('warn-pets', 'btn-novo-pet', !db.clientes.length);
    if (!db.pets.length) {
      tbody.innerHTML = ui.emptyRow(5, 'Nenhum pet cadastrado. Clique em "Novo Pet" para começar.');
      return;
    }
    tbody.innerHTML = db.pets.map(p => {
      const dono = db.clientes.find(c => c.id === p.donoId);
      return `<tr>
        <td>${p.nome}</td>
        <td>${p.raca  || '—'}</td>
        <td>${p.idade ? p.idade + ' ano(s)' : '—'}</td>
        <td>${dono ? dono.nome : '—'}</td>
        <td>${ui.actionBtns('Pets.editar','Pets.excluir', p.id)}</td>
      </tr>`;
    }).join('');
  },
};

/* ============================================================
   Servicos — CRUD
============================================================ */
const Servicos = {

  novo() {
    document.getElementById('modal-servico-title').textContent = 'Novo Serviço';
    ui.clear('servico-edit-id','servico-nome','servico-preco');
    ui.open('modal-servico');
  },

  salvar() {
    const nome  = document.getElementById('servico-nome').value.trim();
    const preco = parseFloat(document.getElementById('servico-preco').value);
    if (!nome)        { alert('Informe o nome do serviço.'); return; }
    if (isNaN(preco)) { alert('Informe um preço válido.');   return; }

    const editId = document.getElementById('servico-edit-id').value;
    if (editId) {
      const s = db.servicos.find(x => x.id == editId);
      if (s) Object.assign(s, { nome, preco });
    } else {
      db.servicos.push({ id: db.nextId('s'), nome, preco });
    }
    ui.close('modal-servico');
    this.render();
    ui.updateCounters();
  },

  editar(id) {
    const s = db.servicos.find(x => x.id === id);
    if (!s) return;
    document.getElementById('modal-servico-title').textContent = 'Editar Serviço';
    ui.fill({ 'servico-edit-id': s.id, 'servico-nome': s.nome, 'servico-preco': s.preco });
    ui.open('modal-servico');
  },

  excluir(id) {
    if (!confirm('Excluir este serviço?')) return;
    db.servicos = db.servicos.filter(x => x.id !== id);
    this.render();
    ui.updateCounters();
  },

  render() {
    const tbody = document.getElementById('tbody-servicos');
    if (!db.servicos.length) {
      tbody.innerHTML = ui.emptyRow(3, 'Nenhum serviço cadastrado. Clique em "Novo Serviço" para começar.');
      return;
    }
    tbody.innerHTML = db.servicos.map(s => `
      <tr>
        <td>${s.nome}</td>
        <td class="td-price">R$ ${s.preco.toFixed(2).replace('.', ',')}</td>
        <td>${ui.actionBtns('Servicos.editar','Servicos.excluir', s.id)}</td>
      </tr>`).join('');
  },
};

/* ============================================================
   Agendamentos — CRUD
============================================================ */
const Agendamentos = {

  novo() {
    if (!db.pets.length || !db.servicos.length) {
      alert('Cadastre pelo menos um pet e um serviço antes de criar agendamentos.');
      return;
    }
    document.getElementById('modal-agend-title').textContent = 'Novo Agendamento';
    ui.clear('agend-edit-id','agend-data','agend-hora');
    ui.populateSelect('agend-pet',     db.pets,     p => p.nome);
    ui.populateSelect('agend-servico', db.servicos, s => s.nome);
    ui.open('modal-agendamento');
  },

  salvar() {
    const data   = document.getElementById('agend-data').value;
    const hora   = document.getElementById('agend-hora').value;
    const petId  = parseInt(document.getElementById('agend-pet').value);
    const servId = parseInt(document.getElementById('agend-servico').value);
    if (!data || !hora) { alert('Informe a data e a hora.'); return; }

    const editId = document.getElementById('agend-edit-id').value;
    if (editId) {
      const a = db.agendamentos.find(x => x.id == editId);
      if (a) Object.assign(a, { data, hora, petId, servId });
    } else {
      db.agendamentos.push({ id: db.nextId('a'), data, hora, petId, servId });
    }
    ui.close('modal-agendamento');
    this.render();
    ui.updateCounters();
  },

  editar(id) {
    const a = db.agendamentos.find(x => x.id === id);
    if (!a) return;
    document.getElementById('modal-agend-title').textContent = 'Editar Agendamento';
    ui.populateSelect('agend-pet',     db.pets,     p => p.nome);
    ui.populateSelect('agend-servico', db.servicos, s => s.nome);
    ui.fill({ 'agend-edit-id': a.id, 'agend-data': a.data, 'agend-hora': a.hora, 'agend-pet': a.petId, 'agend-servico': a.servId });
    ui.open('modal-agendamento');
  },

  excluir(id) {
    if (!confirm('Excluir este agendamento?')) return;
    db.agendamentos = db.agendamentos.filter(x => x.id !== id);
    this.render();
    ui.updateCounters();
  },

  render() {
    const tbody  = document.getElementById('tbody-agendamentos');
    const canAdd = db.pets.length > 0 && db.servicos.length > 0;
    ui.toggleWarning('warn-agend', 'btn-novo-agend', !canAdd);

    if (!db.agendamentos.length) {
      tbody.innerHTML = ui.emptyRow(6, 'Nenhum agendamento cadastrado. Clique em "Novo Agendamento" para começar.');
      return;
    }
    tbody.innerHTML = db.agendamentos.map(a => {
      const pet  = db.pets.find(p => p.id === a.petId);
      const serv = db.servicos.find(s => s.id === a.servId);
      const dono = pet ? db.clientes.find(c => c.id === pet.donoId) : null;
      const dataFmt = a.data ? a.data.split('-').reverse().join('/') : '—';
      return `<tr>
        <td>${dataFmt}</td>
        <td>${a.hora || '—'}</td>
        <td>${pet  ? pet.nome  : '—'}</td>
        <td>${dono ? dono.nome : '—'}</td>
        <td>${serv ? serv.nome : '—'}</td>
        <td>${ui.actionBtns('Agendamentos.editar','Agendamentos.excluir', a.id)}</td>
      </tr>`;
    }).join('');
  },
};

/* ============================================================
   App — Navegação, botões, inicialização
============================================================ */
const PAGE_RENDERERS = {
  home:         () => ui.updateCounters(),
  clientes:     () => Clientes.render(),
  pets:         () => Pets.render(),
  servicos:     () => Servicos.render(),
  agendamentos: () => Agendamentos.render(),
};

function navigate(pageKey) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.getElementById('page-' + pageKey).classList.add('active');
  document.querySelectorAll('.nav-links a').forEach(a => {
    a.classList.toggle('active', a.dataset.page === pageKey);
  });
  PAGE_RENDERERS[pageKey]?.();
}

document.addEventListener('DOMContentLoaded', () => {

  // Navegação
  document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', e => { e.preventDefault(); navigate(link.dataset.page); });
  });

  // Botões "Novo"
  document.getElementById('btn-novo-cliente').addEventListener('click', () => Clientes.novo());
  document.getElementById('btn-novo-pet').addEventListener('click',     () => Pets.novo());
  document.getElementById('btn-novo-servico').addEventListener('click', () => Servicos.novo());
  document.getElementById('btn-novo-agend').addEventListener('click',   () => Agendamentos.novo());

  // Botões "Salvar" dos modais
  document.getElementById('btn-salvar-cliente').addEventListener('click', () => Clientes.salvar());
  document.getElementById('btn-salvar-pet').addEventListener('click',     () => Pets.salvar());
  document.getElementById('btn-salvar-servico').addEventListener('click', () => Servicos.salvar());
  document.getElementById('btn-salvar-agend').addEventListener('click',   () => Agendamentos.salvar());

  // Fechar modais — botões data-close e clique no overlay
  document.querySelectorAll('[data-close]').forEach(btn => {
    btn.addEventListener('click', () => ui.close(btn.dataset.close));
  });
  document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', e => { if (e.target === overlay) ui.close(overlay.id); });
  });

  ui.updateCounters();
});

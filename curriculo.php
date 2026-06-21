<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerador de Currículo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f0f2f5; font-family: Arial, sans-serif; }

    /* ── FORMULÁRIO ── */
    .card-form {
      max-width: 700px;
      margin: 30px auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 12px rgba(0,0,0,.1);
      padding: 30px;
    }
    .card-form h2 {
      color: #1a56db;
      font-size: 1.5rem;
      margin-bottom: 20px;
      border-bottom: 2px solid #1a56db;
      padding-bottom: 8px;
    }
    .btn-gerar {
      background: #1a56db;
      color: #fff;
      border: none;
      padding: 12px 40px;
      border-radius: 6px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      margin-top: 10px;
    }
    .btn-gerar:hover { background: #1447b5; }

    /* ── CURRÍCULO GERADO ── */
    .curriculo {
      max-width: 700px;
      margin: 30px auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 12px rgba(0,0,0,.1);
      overflow: hidden;
    }
    .cv-topo {
      background: #1a56db;
      color: #fff;
      padding: 24px 30px;
    }
    .cv-topo h1 { font-size: 1.8rem; margin: 0; }
    .cv-topo p  { margin: 4px 0 0; opacity: .85; font-size: .95rem; }
    .cv-contatos {
      margin-top: 10px;
      font-size: .85rem;
      opacity: .9;
    }
    .cv-contatos span { margin-right: 16px; }
    .cv-corpo { padding: 24px 30px; }
    .cv-secao { margin-bottom: 22px; }
    .cv-secao h3 {
      font-size: 1rem;
      font-weight: bold;
      color: #1a56db;
      border-bottom: 1.5px solid #dbeafe;
      padding-bottom: 4px;
      margin-bottom: 10px;
      text-transform: uppercase;
      letter-spacing: .05em;
    }
    .cv-item { margin-bottom: 12px; }
    .cv-item-topo {
      display: flex;
      justify-content: space-between;
      align-items: baseline;
      flex-wrap: wrap;
    }
    .cv-item-titulo { font-weight: bold; color: #111; font-size: .95rem; }
    .cv-item-periodo {
      font-size: .8rem;
      color: #666;
      background: #f0f4ff;
      padding: 2px 8px;
      border-radius: 4px;
    }
    .cv-item-sub  { color: #1a56db; font-size: .85rem; }
    .cv-item-desc { color: #444; font-size: .88rem; margin-top: 4px; line-height: 1.5; }
    .tag {
      display: inline-block;
      background: #dbeafe;
      color: #1e40af;
      border-radius: 4px;
      padding: 2px 10px;
      font-size: .8rem;
      margin: 3px 3px 3px 0;
    }
    .cv-rodape {
      text-align: center;
      padding: 12px;
      background: #f8fafc;
      border-top: 1px solid #e5e7eb;
      font-size: .8rem;
      color: #999;
    }
    .btn-voltar {
      display: inline-block;
      margin: 20px auto;
      background: #fff;
      color: #1a56db;
      border: 2px solid #1a56db;
      padding: 10px 30px;
      border-radius: 6px;
      font-weight: bold;
      text-decoration: none;
      cursor: pointer;
    }
    .btn-imprimir {
      display: inline-block;
      margin: 20px 10px;
      background: #1a56db;
      color: #fff;
      border: none;
      padding: 10px 30px;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }
    .acoes { text-align: center; }

    /* ── ITEM DINÂMICO ── */
    .item-dinamico {
      background: #f8fafc;
      border: 1px solid #dde;
      border-left: 3px solid #1a56db;
      border-radius: 6px;
      padding: 14px;
      margin-bottom: 12px;
    }
    .btn-remover {
      float: right;
      background: #fee2e2;
      color: #dc2626;
      border: none;
      border-radius: 4px;
      padding: 2px 8px;
      font-size: .8rem;
      cursor: pointer;
    }
    .btn-adicionar {
      background: #fff;
      color: #1a56db;
      border: 1.5px dashed #1a56db;
      border-radius: 6px;
      padding: 7px 18px;
      font-size: .88rem;
      cursor: pointer;
      margin-top: 4px;
    }
    .btn-adicionar:hover { background: #eff6ff; }

    @media print {
      .acoes, .no-print { display: none !important; }
      body { background: #fff; }
      .curriculo { box-shadow: none; margin: 0; border-radius: 0; }
    }
  </style>
</head>
<body>

<?php
// ── Se veio o formulário via POST, gera o currículo
if ($_SERVER['REQUEST_METHOD'] === 'POST'):

  function s($v) { return htmlspecialchars(trim($v ?? ''), ENT_QUOTES, 'UTF-8'); }
  function mes($ym) {
    if (!$ym) return 'Atual';
    [$a, $m] = explode('-', $ym);
    $ms = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
    return $ms[(int)$m-1].'/'.$a;
  }

  $nome     = s($_POST['nome']);
  $cargo    = s($_POST['cargo']);
  $email    = s($_POST['email']);
  $tel      = s($_POST['telefone']);
  $cidade   = s($_POST['cidade']);
  $idade    = s($_POST['idade']);
  $resumo   = s($_POST['resumo']);
  $hab      = s($_POST['habilidades']);
  $idiomas  = s($_POST['idiomas']);

  $exp_cargo  = array_map('s', $_POST['exp_cargo']      ?? []);
  $exp_emp    = array_map('s', $_POST['exp_empresa']     ?? []);
  $exp_ini    = $_POST['exp_inicio'] ?? [];
  $exp_fim    = $_POST['exp_fim']    ?? [];
  $exp_desc   = array_map('s', $_POST['exp_desc']       ?? []);

  $for_curso  = array_map('s', $_POST['for_curso']      ?? []);
  $for_inst   = array_map('s', $_POST['for_inst']       ?? []);
  $for_ini    = $_POST['for_inicio'] ?? [];
  $for_fim    = $_POST['for_fim']    ?? [];

  $ref_nome   = array_map('s', $_POST['ref_nome']       ?? []);
  $ref_tel    = array_map('s', $_POST['ref_tel']        ?? []);

  $hab_arr = array_filter(array_map('trim', explode(',', $hab)));
?>

<!-- BOTÕES DE AÇÃO -->
<div class="acoes no-print">
  <a href="curriculo.php" class="btn-voltar">← Voltar e Editar</a>
  <button onclick="window.print()" class="btn-imprimir">🖨 Imprimir / Baixar PDF</button>
</div>

<!-- CURRÍCULO -->
<div class="curriculo">

  <!-- TOPO AZUL -->
  <div class="cv-topo">
    <h1><?= $nome ?></h1>
    <p><?= $cargo ?></p>
    <div class="cv-contatos">
      <?php if($email):  ?><span>✉ <?= $email ?></span><?php endif; ?>
      <?php if($tel):    ?><span>📞 <?= $tel ?></span><?php endif; ?>
      <?php if($cidade): ?><span>📍 <?= $cidade ?></span><?php endif; ?>
      <?php if($idade):  ?><span>👤 <?= $idade ?></span><?php endif; ?>
    </div>
  </div>

  <div class="cv-corpo">

    <!-- RESUMO -->
    <?php if($resumo): ?>
    <div class="cv-secao">
      <h3>Resumo Profissional</h3>
      <p class="cv-item-desc"><?= $resumo ?></p>
    </div>
    <?php endif; ?>

    <!-- EXPERIÊNCIAS -->
    <?php if(!empty(array_filter($exp_cargo))): ?>
    <div class="cv-secao">
      <h3>Experiência Profissional</h3>
      <?php foreach($exp_cargo as $i => $c): if(!$c) continue; ?>
      <div class="cv-item">
        <div class="cv-item-topo">
          <span class="cv-item-titulo"><?= $c ?><?= $exp_emp[$i] ? ' · '.$exp_emp[$i] : '' ?></span>
          <span class="cv-item-periodo"><?= mes($exp_ini[$i]??'') ?> – <?= mes($exp_fim[$i]??'') ?></span>
        </div>
        <?php if($exp_desc[$i]): ?><p class="cv-item-desc"><?= nl2br($exp_desc[$i]) ?></p><?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- FORMAÇÃO -->
    <?php if(!empty(array_filter($for_curso))): ?>
    <div class="cv-secao">
      <h3>Formação Acadêmica</h3>
      <?php foreach($for_curso as $i => $fc): if(!$fc) continue; ?>
      <div class="cv-item">
        <div class="cv-item-topo">
          <span class="cv-item-titulo"><?= $fc ?></span>
          <span class="cv-item-periodo"><?= mes($for_ini[$i]??'') ?> – <?= mes($for_fim[$i]??'') ?></span>
        </div>
        <?php if($for_inst[$i]): ?><p class="cv-item-sub"><?= $for_inst[$i] ?></p><?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- HABILIDADES -->
    <?php if(!empty($hab_arr)): ?>
    <div class="cv-secao">
      <h3>Habilidades</h3>
      <?php foreach($hab_arr as $h): ?>
        <span class="tag"><?= $h ?></span>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- IDIOMAS -->
    <?php if($idiomas): ?>
    <div class="cv-secao">
      <h3>Idiomas</h3>
      <p class="cv-item-desc"><?= $idiomas ?></p>
    </div>
    <?php endif; ?>

    <!-- REFERÊNCIAS -->
    <?php if(!empty(array_filter($ref_nome))): ?>
    <div class="cv-secao">
      <h3>Referências</h3>
      <?php foreach($ref_nome as $i => $rn): if(!$rn) continue; ?>
      <div class="cv-item">
        <span class="cv-item-titulo"><?= $rn ?></span>
        <?php if($ref_tel[$i]): ?> — <span class="cv-item-desc" style="display:inline"><?= $ref_tel[$i] ?></span><?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

  </div><!-- /.cv-corpo -->

  <div class="cv-rodape">Currículo gerado em <?= date('d/m/Y') ?></div>
</div>

<?php else: // ── EXIBE O FORMULÁRIO ?>

<div class="card-form">
  <h2>📄 Gerador de Currículo</h2>

  <form method="POST" action="curriculo.php">

    <!-- DADOS PESSOAIS -->
    <h5 class="mt-2 mb-3 text-primary">Dados Pessoais</h5>
    <div class="row g-2 mb-2">
      <div class="col-md-7">
        <label class="form-label">Nome Completo *</label>
        <input type="text" name="nome" class="form-control" placeholder="Seu nome" required>
      </div>
      <div class="col-md-5">
        <label class="form-label">Cargo / Função *</label>
        <input type="text" name="cargo" class="form-control" placeholder="Ex: Desenvolvedor PHP" required>
      </div>
    </div>
    <div class="row g-2 mb-2">
      <div class="col-md-4">
        <label class="form-label">Data de Nascimento</label>
        <input type="date" id="nasc" name="nascimento" class="form-control">
      </div>
      <div class="col-md-2">
        <label class="form-label">Idade</label>
        <input type="text" id="idade" name="idade" class="form-control" readonly placeholder="Auto">
      </div>
      <div class="col-md-6">
        <label class="form-label">E-mail *</label>
        <input type="email" name="email" class="form-control" placeholder="seu@email.com" required>
      </div>
    </div>
    <div class="row g-2 mb-3">
      <div class="col-md-5">
        <label class="form-label">Telefone</label>
        <input type="text" name="telefone" class="form-control" placeholder="(44) 99999-9999">
      </div>
      <div class="col-md-7">
        <label class="form-label">Cidade / Estado</label>
        <input type="text" name="cidade" class="form-control" placeholder="Ex: Maringá – PR">
      </div>
    </div>

    <!-- RESUMO -->
    <h5 class="mb-2 text-primary">Resumo Profissional</h5>
    <div class="mb-3">
      <textarea name="resumo" class="form-control" rows="3"
        placeholder="Descreva brevemente sua trajetória e objetivos profissionais..."></textarea>
    </div>

    <!-- EXPERIÊNCIAS -->
    <h5 class="mb-2 text-primary">Experiências Profissionais</h5>
    <div id="exp-container"></div>
    <button type="button" class="btn-adicionar mb-3" onclick="addExp()">+ Adicionar Experiência</button>

    <!-- FORMAÇÃO -->
    <h5 class="mb-2 text-primary">Formação Acadêmica</h5>
    <div id="for-container"></div>
    <button type="button" class="btn-adicionar mb-3" onclick="addFor()">+ Adicionar Formação</button>

    <!-- HABILIDADES -->
    <h5 class="mb-2 text-primary">Habilidades</h5>
    <div class="mb-3">
      <input type="text" name="habilidades" class="form-control"
        placeholder="Ex: PHP, HTML, CSS, JavaScript, MySQL (separe por vírgula)">
    </div>

    <!-- IDIOMAS -->
    <h5 class="mb-2 text-primary">Idiomas</h5>
    <div class="mb-3">
      <input type="text" name="idiomas" class="form-control"
        placeholder="Ex: Português (Nativo), Inglês (Básico)">
    </div>

    <!-- REFERÊNCIAS -->
    <h5 class="mb-2 text-primary">Referências</h5>
    <div id="ref-container"></div>
    <button type="button" class="btn-adicionar mb-3" onclick="addRef()">+ Adicionar Referência</button>

    <button type="submit" class="btn-gerar">Gerar Currículo</button>
  </form>
</div>

<?php endif; ?>

<script>
// ── CÁLCULO DE IDADE
document.getElementById('nasc')?.addEventListener('change', function(){
  const n = new Date(this.value);
  if(isNaN(n)) return;
  const h = new Date();
  let i = h.getFullYear() - n.getFullYear();
  if(h.getMonth() < n.getMonth() || (h.getMonth()===n.getMonth() && h.getDate()<n.getDate())) i--;
  document.getElementById('idade').value = i + ' anos';
});

// ── REMOVER ITEM
function remover(btn){ btn.closest('.item-dinamico').remove(); }

// ── ADICIONAR EXPERIÊNCIA
function addExp(){
  const d = document.getElementById('exp-container');
  const div = document.createElement('div');
  div.className = 'item-dinamico';
  div.innerHTML = `
    <button type="button" class="btn-remover" onclick="remover(this)">✕ Remover</button>
    <div class="row g-2">
      <div class="col-md-6">
        <label class="form-label">Cargo *</label>
        <input type="text" name="exp_cargo[]" class="form-control" placeholder="Ex: Auxiliar de Escritório">
      </div>
      <div class="col-md-6">
        <label class="form-label">Empresa</label>
        <input type="text" name="exp_empresa[]" class="form-control" placeholder="Nome da empresa">
      </div>
      <div class="col-md-4">
        <label class="form-label">Início</label>
        <input type="month" name="exp_inicio[]" class="form-control">
      </div>
      <div class="col-md-4">
        <label class="form-label">Saída</label>
        <input type="month" name="exp_fim[]" class="form-control">
      </div>
      <div class="col-12">
        <label class="form-label">Descrição</label>
        <textarea name="exp_desc[]" class="form-control" rows="2"
          placeholder="Principais atividades realizadas..."></textarea>
      </div>
    </div>`;
  d.appendChild(div);
}

// ── ADICIONAR FORMAÇÃO
function addFor(){
  const d = document.getElementById('for-container');
  const div = document.createElement('div');
  div.className = 'item-dinamico';
  div.innerHTML = `
    <button type="button" class="btn-remover" onclick="remover(this)">✕ Remover</button>
    <div class="row g-2">
      <div class="col-md-6">
        <label class="form-label">Curso *</label>
        <input type="text" name="for_curso[]" class="form-control" placeholder="Ex: Análise e Desenvolvimento de Sistemas">
      </div>
      <div class="col-md-6">
        <label class="form-label">Instituição</label>
        <input type="text" name="for_inst[]" class="form-control" placeholder="Ex: UNIPAR">
      </div>
      <div class="col-md-4">
        <label class="form-label">Início</label>
        <input type="month" name="for_inicio[]" class="form-control">
      </div>
      <div class="col-md-4">
        <label class="form-label">Conclusão</label>
        <input type="month" name="for_fim[]" class="form-control">
      </div>
    </div>`;
  d.appendChild(div);
}

// ── ADICIONAR REFERÊNCIA
function addRef(){
  const d = document.getElementById('ref-container');
  const div = document.createElement('div');
  div.className = 'item-dinamico';
  div.innerHTML = `
    <button type="button" class="btn-remover" onclick="remover(this)">✕ Remover</button>
    <div class="row g-2">
      <div class="col-md-6">
        <label class="form-label">Nome</label>
        <input type="text" name="ref_nome[]" class="form-control" placeholder="Nome da referência">
      </div>
      <div class="col-md-6">
        <label class="form-label">Telefone</label>
        <input type="text" name="ref_tel[]" class="form-control" placeholder="(44) 99999-9999">
      </div>
    </div>`;
  d.appendChild(div);
}

// ── Adiciona 1 de cada automaticamente
<?php if($_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
addExp();
addFor();
addRef();
<?php endif; ?>
</script>

</body>
</html>

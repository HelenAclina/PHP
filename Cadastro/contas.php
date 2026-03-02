<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contas</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main>
    <h1>Dados da Conta</h1>
    <form>
      <label for="usuario">Usuário</label>
      <input type="text" id="usuario" name="usuario">

      <label for="email">E-Mail</label>
      <input type="email" id="email" name="email">

      <label for="senha">Senha</label>
      <input type="password" id="senha" name="senha">

      <label for="conf_senha">Confirmar Senha</label>
      <input type="password" id="conf_senha" name="conf_senha">

      <div class="botoes">
        <button type="submit">Criar Conta</button>
        <button type="button">Login</button>
      </div>
    </form>
  </main>
</body>
</html>
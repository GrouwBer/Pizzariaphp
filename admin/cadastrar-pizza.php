<?php

$conn = mysqli_connect('localhost', 'root', '', 'trabalho');
if (mysqli_connect_errno()) {
  die('Não foi possível se conectar com o banco de dados: ' . mysqli_connect_error());
}

$msg = array();

try {
  if ($_POST) {

    $nome = filter_var($_POST['nome']) ?: throw new Exception('Por favor, preencha o campo Nome!');
    $descricao = filter_var($_POST['descricao']) ?: throw new Exception('Por favor, insira descricao');
    $precob = filter_var($_POST['precob']) ?: throw new Exception('valor invalido!');
    $precom = filter_var($_POST['precom']) ?: throw new Exception('valor invalido!');
    $precog = filter_var($_POST['precog']) ?: throw new Exception('valor invalido!');
    $foto = filter_var($_POST['foto']) ?: throw new Exception('foto invalida!');

    $nome = mysqli_real_escape_string($conn, $nome);
    $descricao = mysqli_real_escape_string($conn, $descricao);
    $sql = "INSERT INTO pizza (nome, descricao, precob, precom, precog, foto) VALUES('$nome', '$descricao', '$precob', '$precom', '$precog' , '$foto')";


    $resultado = mysqli_query($conn, $sql);

    
    if ($resultado === false || mysqli_errno($conn)) {
      throw new Exception('Erro ao realizar operação no banco de dados: ' . mysqli_error($conn));
    }

    $msg = array(
      'classe' => 'msg-sucesso',
      'mensagem' => 'Pizza cadastrada com sucesso!'
    );
  }
} catch (Exception $ex) {
  $msg = array(
    'classe' => 'msg-erro',
    'mensagem' => $ex->getMessage()
  );
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastrar Pizza | Administração | Pizza DEV</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
  <link rel="stylesheet" href="../assets/css/admin.css" />
  <script src="../assets/js/admin.js" defer></script>
</head>

<body>
  <header class="topo flex container-padding">
    <img src="../assets/images/pizza-dev.png" alt="Pizza DEV" />
    <nav class="menu">
      <a href="index.php" class="active">Pizzas</a>
      <a href="mensagens.php">Mensagens</a>
      <a href="usuarios.php">Usuários</a>
      <a href="login.php">Sair</a>
    </nav>
  </header>
  <div class="pagina container">
    <div class="cabecalho flex bordered">
      <h1>Cadastrar Pizza</h1>
      <a href="index.php" class="botao"> Voltar </a>
    </div>

    <?php if ($msg): ?>
    <div class="alert <?= $msg['classe'] ?>">
      <?= $msg['mensagem']; ?>
    </div>
    <?php endif; ?>

    <form method="POST">
      <input type="text" value="<?= $_POST['nome'] ?? '' ?>" name="nome" id="nome" class="input-field"
        placeholder="* Nome da Pizza" />
      <textarea name="descricao" id="descricao" cols="1" rows="6" class="input-field"
        placeholder="* Descrição dos Ingredientes" value="<?= $_POST['descricao'] ?? '' ?>"></textarea>
      <div class="group-field flex">
        <input type="number" name="precob" id="precob" class="input-field" step=".01"
          placeholder="* Preço Brotinho" value="<?= $_POST['precob'] ?? '' ?>" />
        <input type="number" name="precom" id="precom" class="input-field" step=".01"
          placeholder="* Preço Média" value="<?= $_POST['precom'] ?? '' ?>" />
        <input type="number" name="precog" id="precog" class="input-field" step=".01"
          placeholder="* Preço Grande" value="<?= $_POST['precog'] ?? '' ?>" />
      </div>
      <input type="text" name="foto" id="foto" class="input-field" placeholder="Foto (ex: pizza-calabresa.jpg)" value="<?= $_POST['foto'] ?? '' ?>" />
      <button type="submit" class="botao">Cadastrar</button>
    </form>
  </div>
</body>

</html>
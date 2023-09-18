<?php

$conn = mysqli_connect('localhost', 'root', '', 'trabalho');
if (mysqli_connect_errno()) {
    die('Não foi possível se conectar com o banco de dados: ' . mysqli_connect_error());
}

$msg = array();

try {
    if ($_POST) {
        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT, [
            'options' => array(
                'min_range' => 1
            )
        ]) ?: throw new Exception('ID informado é inválido!');
        $nome = filter_var($_POST['nome']) ?: throw new Exception('Por favor, preencha o campo Nome!');
        $usuario = filter_var($_POST['usuario']) ?: throw new Exception('Usuario inválido!');
        $senha = filter_var($_POST['senha']) ?: throw new Exception('Senha inválida!');

        $nome = mysqli_real_escape_string($conn, $nome);
        $usuario = mysqli_real_escape_string($conn, $usuario);
        $senha = mysqli_real_escape_string($conn, $senha);

        $sql = "UPDATE clientes SET nome = '$nome', usuario = '$usuario', senha = $senha WHERE cliente_id = $id";
        $resultado = mysqli_query($conn, $sql);

        if ($resultado === false || mysqli_errno($conn)) {
            throw new Exception('Erro ao realizar operação no banco de dados: ' . mysqli_error($conn));
        }

        $msg = array(
            'classe' => 'msg-sucesso',
            'mensagem' => 'Cliente atualizado com sucesso!'
        );
    }

    if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT, [
            'options' => array(
                'min_range' => 1
            )
        ]);

        if ($id === false) {
            throw new Exception('ID fornecido é inválido!');
        }

        $sql = "SELECT * FROM clientes WHERE cliente_id = $id";
        $resultado = mysqli_query($conn, $sql);

        if (!$resultado || mysqli_errno($conn)) {
            throw new Exception('Erro ao buscar informações na base de dados: ' . mysqli_error($conn));
        }

        $cliente = mysqli_fetch_assoc($resultado);
        if (!$cliente) {
            throw new Exception('Dados do cliente não foram encontrados!');
        }
    } else {
        header('Location: usuarios.php');
        exit;
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário | Administração | Pizza DEV</title>
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
            <a href="index.php">Pizzas</a>
            <a href="mensagens.php">Mensagens</a>
            <a href="usuarios.php" class="active">Usuários</a>
            <a href="login.php">Sair</a>
        </nav>
    </header>
    <div class="pagina container">
        <div class="cabecalho flex bordered">
            <h1>Editar Usuário</h1>
            <a href="usuarios.php" class="botao">
                Voltar
            </a>
        </div>
        <?php if ($msg): ?>
        <div class="alert <?= $msg['classe'] ?>">
            <?= $msg['mensagem']; ?>
        </div>
        <?php endif; ?>

        <form action="" method="post">
            <input type="text" name="id" class="input-field" readonly value="<?= $cliente['cliente_id'] ?? '' ?>">
            <input type="text" name="nome" id="nome" class="input-field" placeholder="* Nome completo"
                value="<?= $_POST['nome'] ?? '' ?>" />
            <input type="text" name="usuario" id="usuario" class="input-field" placeholder="* Usuário"
                value="<?= $_POST['usuario'] ?? '' ?>" />
            <input type="password" name="senha" id="senha" class="input-field" placeholder="* Senha"
                value="<?= $_POST['senha'] ?? '' ?>" />
            <input type="password" name="confirmacaoSenha" id="confirmacaoSenha" class="input-field"
                placeholder="* Confirmar senha" />
            <button type="submit" class="botao">
                Salvar
            </button>
        </form>
    </div>
</body>

</html>
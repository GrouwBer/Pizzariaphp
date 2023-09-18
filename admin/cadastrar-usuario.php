
<?php

$conn = mysqli_connect('localhost', 'root', '', 'trabalho');
if (mysqli_connect_errno()) {
    die('Não foi possível se conectar com o banco de dados: ' . mysqli_connect_error());
}

$msg = array();

try {
    if ($_POST) {

        $nome = filter_var($_POST['nome']) ?: throw new Exception('Por favor, preencha o campo Nome!');
        $usuario = filter_var($_POST['usuario']) ?: throw new Exception('Por favor, preencha o campo usuario!');
        $senha = filter_var($_POST['senha']) ?: throw new Exception('Senha invalida!');

        $nome = mysqli_real_escape_string($conn, $nome);
        $usuario = mysqli_real_escape_string($conn, $usuario);
        $senha = mysqli_real_escape_string($conn, $senha);

       $encrypted = base64_encode($senha);
        $sql = "INSERT INTO clientes (nome, usuario, senha) VALUES('$nome', '$usuario', '$encrypted')";


        $resultado = mysqli_query($conn, $sql);

        if ($resultado === false || mysqli_errno($conn)) {
            throw new Exception('Erro ao realizar operação no banco de dados: ' . mysqli_error($conn));
        }

        $msg = array(
            'classe' => 'msg-sucesso',
            'mensagem' => 'Cliente cadastrado com sucesso!'
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário | Administração | Pizza DEV</title>
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
            <h1>Cadastrar Usuário</h1>
            <form>
 <input type="button" value="voltar!" class = "botao" onclick="history.back()">
</form>
        </div>

        <?php if ($msg) : ?>
            <div class="alert <?= $msg['classe'] ?>">
                <?= $msg['mensagem']; ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <!-- O atributo for é usado em labels. Refere-se ao id do elemento ao qual este label está associado. -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" class="input-field" value="<?= $_POST['nome'] ?? '' ?>">


            <label for="usuario">usuario:</label>
            <input type="text" name="usuario" id="usuario" class="input-field" value="<?= $_POST['usuario'] ?? '' ?>">


            <label for="senha">senha:</label> <br>
            <input type="text" name="senha" id="senha" class="input-field" value="<?= $_POST['senha'] ?? '' ?>">


            <button type="submit" class="botao">
                Cadastrar
            </button>

        </form>
    </div>
</body>

</html>
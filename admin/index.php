<?php

$conn = mysqli_connect('localhost', 'root', '', 'trabalho');
if (mysqli_connect_errno()) {
    die('Não foi possível se conectar com o banco de dados: ' . mysqli_connect_error());
}


$msg = array();

$sql_busca = "SELECT * FROM pizza";

try {
    // Verifica se tem dados via GET e existi o dado excluir
    if ($_GET && isset($_GET['excluir'])) {

        // Se usar apenas o $id = $_GET['excluir']; ocasiona falha de SQL Injection
        $id = filter_var($_GET['excluir'], FILTER_VALIDATE_INT);

        if ($id === false) {
            throw new Exception("ID inválido para exclusão");
        }

        // Exemplo de SQL Injection - $sql = "DELETE FROM clientes WHERE cliente_id = 2 OR 1 = 1";
        // Exemplo de SQL Injection - $sql = "DELETE FROM clientes WHERE cliente_id = 2; DROP TABLE clientes; se for um usuário com permissão de root";
        $sql = "DELETE FROM pizza WHERE pizza_id = $id";
        $resultado = mysqli_query($conn, $sql);

        if ($resultado === false || mysqli_errno($conn)) {
            throw new Exception('Erro ao realizar a exclusão no banco de dados: ' . mysqli_error($conn));
        }

        // operação de exclusão na base
        $msg = array(
            'classe' => 'msg-sucesso',
            'mensagem' => 'Pizza excluída com sucesso!'
        );
    }

    // Verifica se tem alguma informação dentro do GET e se está setado na url o parâmetro busca
    if ($_GET && isset($_GET['busca'])) {
        $termo = filter_var($_GET['busca'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if (!empty($termo)) {
            $sql_busca = "SELECT * FROM pizza WHERE nome LIKE '%$termo%'";
        }
    }

} catch (Exception $ex) {
    $msg = array(
        'classe' => 'msg-erro',
        'mensagem' => $ex->getMessage()
    );
} finally {
    // A função mysqli_query() executa a query no banco a partir da conexão fornecida.
    $resultado = mysqli_query($conn, $sql_busca);
    // Se retornou algum dado na consulta
    if ($resultado) {
        // mysqli_fetch_all() pega todos os resultados e cria um array (matriz)
        // Cada resultado é um array associativo
        // MYSQLI_NUM é o padrão numérico
        $lista_pizza = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
}


?>




<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nossas Pizzas | Administração | Pizza DEV</title>
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
        <div class="cabecalho flex">
            <a href="cadastrar-pizza.php" class="botao">
                Nova Pizza
            </a>
        </div>
        <?php if ($msg): ?>
        <div class="alert <?= $msg['classe'] ?>">
            <?= $msg['mensagem']; ?>
        </div>
        <?php endif; ?>
        <div class="tabela-responsiva">
            <table>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>nome</th>
                            <th>descrição</th>
                            <th>preco brotinho</th>
                            <th>preco media</th>
                            <th>preco grande</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista_pizza as $pizza): ?>
                        <tr>
                        <td>
                                <?= $pizza['pizza_id'] ?>
                            </td>
                            <td>
                                <?= $pizza['nome'] ?>
                            </td>
                            <td>
                                <?= $pizza['descricao'] ?>
                            </td>
                            <td>
                                <?= $pizza['precob'] ?>
                            </td>
                            <td>
                                <?= $pizza['precom'] ?>
                            </td>
                            <td>
                                <?= $pizza['precog'] ?>
                            </td>
                           
                            <td>
                                <a href="editar-pizza.php?id=<?= $pizza['pizza_id'] ?>" class="btn-editar">Editar
                                    <i class="fa-solid fa-pen-to-square"></i></a>

                            </td>
                            <td>
                                <a href="index.php?excluir=<?= $pizza['pizza_id'] ?>" class="btn-excluir">Excluir
                                    <i class="fa-regular fa-trash-can"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </table>
        </div>
    </div>
</body>

</html>
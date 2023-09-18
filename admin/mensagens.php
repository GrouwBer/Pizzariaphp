<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensagens | Administração | Pizza DEV</title>
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
            <a href="mensagens.php" class="active">Mensagens</a>
            <a href="usuarios.php">Usuários</a>
            <a href="login.php">Sair</a>
        </nav>
    </header>
    <div class="pagina container">
        <div class="cabecalho flex">
            <br />
        </div>
        <div class="tabela-responsiva">
            <table>
                <?php

                $conn = mysqli_connect('localhost', 'root', '', 'trabalho');
                if (mysqli_connect_errno()) {
                    die('Não foi possível se conectar com o banco de dados: ' . mysqli_connect_error());
                }


                $msg = array();

                $sql_busca = "SELECT * FROM mensagem";

                try {
                
                    if ($_GET && isset($_GET['excluir'])) {

                        $id = filter_var($_GET['excluir'], FILTER_VALIDATE_INT);

                        if ($id === false) {
                            throw new Exception("ID inválido para exclusão");
                        }

                        $sql = "DELETE FROM mensagem WHERE mensagem_id = $id";
                        $resultado = mysqli_query($conn, $sql);

                        if ($resultado === false || mysqli_errno($conn)) {
                            throw new Exception('Erro ao realizar a exclusão no banco de dados: ' . mysqli_error($conn));
                        }

                        $msg = array(
                            'classe' => 'msg-sucesso',
                            'mensagem' => 'Mensagem excluída com sucesso!'
                        );
                    }

                    if ($_GET && isset($_GET['busca'])) {
                        $termo = filter_var($_GET['busca'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
                        if (!empty($termo)) {
                            $sql_busca = "SELECT * FROM mensagem WHERE assunto LIKE '%$termo%'";
                        }
                    }

                } catch (Exception $ex) {
                    $msg = array(
                        'classe' => 'msg-erro',
                        'mensagem' => $ex->getMessage()
                    );
                } finally {
                   
                    $resultado = mysqli_query($conn, $sql_busca);

                    if ($resultado) {
                        $lista_mensagens = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
                    }
                }
                
                ?>

                <?php if ($msg): ?>
                <div class="alert <?= $msg['classe'] ?>">
                    <?= $msg['mensagem']; ?>
                </div>
                <?php endif; ?>

                <form method="GET">
                    <div class="row">
                        <input type="search" name="busca" class="input-field" value="<?= $termo ?? '' ?>"
                            placeholder="Buscar mensagem por assunto" />


                        <button class="botao">
                            Buscar
                        </button>

                    </div>
                </form>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Nome</th>
                            <th>Assunto</th>
                            <th>Email</th>
                            <th>mensagem</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista_mensagens as $mensagens): ?>
                        <tr>
                            <td>
                                <?= $mensagens['mensagem_id'] ?>
                            </td>
                            <td>
                                <?= $mensagens['nome'] ?>
                            </td>
                            <td>
                                <?= $mensagens['email'] ?>
                            </td>
                            <td>
                                <?= $mensagens['assunto'] ?>
                            </td>
                            <td>
                                <?= $mensagens['mensagem'] ?>
                            </td>
                            <td>
                                <a href="mensagens.php?excluir=<?= $mensagens['mensagem_id'] ?>"
                                    class="btn-excluir">Excluir
                                    <i class="fa-regular fa-trash-can"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
        </div>
    </div>
</body>

</html>
<?php

$conn = mysqli_connect('localhost', 'root', '', 'trabalho');
if (mysqli_connect_errno()) {
    die('Não foi possível se conectar com o banco de dados: ' . mysqli_connect_error());
}


$msg = array();

$sql_busca = "SELECT * FROM pizza";

try {


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
        $lista_pizza = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
}



?>
<?php

$conn = mysqli_connect('localhost', 'root', '', 'trabalho');
if (mysqli_connect_errno()) {
    die('Não foi possível se conectar com o banco de dados: ' . mysqli_connect_error());
}

$msg = array();

try {
    if ($_POST) {

        $nome = filter_var($_POST['nome']) ?: throw new Exception('Por favor, preencha o campo Nome!');
        $email = filter_var($_POST['email']) ?: throw new Exception('insira um email valido!');
        $assunto = filter_var($_POST['assunto']) ?: throw new Exception('insira o assunto!');
        $mensagem = filter_var($_POST['mensagem']) ?: throw new Exception('digite sua mensagem!');

        $nome = mysqli_real_escape_string($conn, $nome);
        $email = mysqli_real_escape_string($conn, $email);
        $assunto = mysqli_real_escape_string($conn, $assunto);
        $mensagem = mysqli_real_escape_string($conn, $mensagem);
        $sql = "INSERT INTO mensagem (nome, email, assunto, mensagem) VALUES('$nome', '$email', '$assunto' , '$mensagem')";

        //print $sql;

        $resultado = mysqli_query($conn, $sql);

        // mysqli_errno() retorna o número do erro da operação (SELECT, INSERT, UPDATE e DELETE) executada dentro do banco de dados
        if ($resultado === false || mysqli_errno($conn)) {
            throw new Exception('Erro ao realizar operação no banco de dados: ' . mysqli_error($conn));
        }

        // operação de inserção na base
        $msg = array(
            'classe' => 'msg-sucesso',
            'mensagem' => 'Mensagem enviada com sucesso!'
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
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pizza DEV</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Poppins:wght@400;500;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/icons.css" />
</head>

<body>
    <!-- Cabecalho   -->
    <header id="header">
        <nav class="container">
            <a class="logo" href="#">Pizza<span> DEV</span></a>
            <div class="menu">
                <ul class="grid">
                    <li><a class="title" href="#home">Início</a></li>
                    <li><a class="title" href="#about">Sobre</a></li>
                    <li><a class="title" href="#services">Serviços</a></li>
                    <li><a class="title" href="#contact">Contato</a></li>
                </ul>
            </div>
            <div class="toggle icon-menu"></div>
            <div class="toggle icon-close"></div>
        </nav>
    </header>
   
    <!-- Todas as páginas -->
    <main>
        <!-- Primeira página -->


        <?php if ($msg) : ?>
            <div class="alert <?= $msg['classe'] ?>">
                <?= $msg['mensagem']; ?>
            </div>
        <?php endif; ?>



        <section class="section" id="home">
            <div class="container grid">
                <div class="image">
                    <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8cGl6emF8ZW58MHx8MHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                        alt="Imagem de uma pizza saborosa" />
                </div>
                <div class="text">
                    <h1>Venha conhecer a melhor pizza da cidade</h1>
                    <p class="subtitle">Temos pizza de vários sabores !</p>
                    <a class="button" href="#cardapio">Conheça nosso cardápio</a>
                </div>
            </div>
        </section>

        <div class="divider"></div>


        <!-- Cardápio -->
        <section class="section" id="cardapio">
            <div class="container">
                <h2 class="title">Cardápio</h2>
                <p class="subtitle">Confira abaixo as nossas opções de pizzas:</p>
                <div class="lista-pizzas">
                    <?php foreach ($lista_pizza as $pizza): ?>

                    <div class="pizza">
                        <img src="<?= $pizza['foto'] ?>" alt="<?= $pizza['nome'] ?>" />
                        <div>
                            <h3 class="title">
                                <?= $pizza['nome'] ?>
                            </h3>
                            <p>
                                <?= $pizza['descricao'] ?>
                            </p>

                            <div class="preco">
                                <strong class="title-preco">Preço:</strong><br>
                                Brotinho (4 pedaços): <strong>R$ <?= $pizza['precob'] ?></strong><br>
                                Média (6 pedaços): <strong>R$ <?= $pizza['precom'] ?></strong><br>
                                Grande (8 pedaços): <strong>R$ <?= $pizza['precog'] ?></strong>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            </div>
        </section>

        <div class="divider"></div>

        <!-- Segunda página -->
        <section class="section" id="about">
            <div class="container grid">
                <div class="image">
                    <img src="https://images.unsplash.com/photo-1622883618971-97068745dc6c?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=731&q=80"
                        alt="Mulher três caixas de pizza para delivery" />
                </div>
                <div class="text">
                    <h2 class="title">Sobre Nós</h2>
                    <p class="subtitle">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui
                        repudiandae facere inventore esse vero aut dolorum, delectus,
                        quisquam quibusdam enim voluptatum mollitia sunt placeat rerum,
                        sint ad minima culpa iusto!
                    </p>
                    <br />
                    <p class="subtitle">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet
                        blanditiis cumque sunt praesentium doloremque minima aut totam
                        iste labore iusto quam, sint quaerat omnis laborum vero
                        dignissimos dicta, cum doloribus!
                    </p>
                    <br />
                    <p class="subtitle">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cumque
                        aliquam, nesciunt distinctio nobis magni perferendis molestiae
                        delectus labore ipsam doloremque voluptate eveniet quis similique
                        voluptatum animi nostrum inventore vel facere.
                    </p>
                </div>
            </div>
        </section>

        <div class="divider"></div>

        <!-- Terceira página -->
        <section class="section" id="services">
            <div class="container grid">
                <header>
                    <h2 class="title">Serviços</h2>
                    <p class="justify-text subtitle">
                        Com mais de 10 anos no mercado, o Pizza DEV já conquistou clientes
                        de inúmeros cidades oferecendo a melhor pizza da região.
                    </p>
                </header>
                <div class="cards grid">

                    <div class="card">
                        <i class="icon-pizza-box"></i>
                        <h3 class="title">Embalagem Resistente</h3>
                        <p class="subtitle">
                            Conheça nossas embalagens resistentes e que mantém sua pizza
                            sempre quentinha.
                        </p>
                    </div>

                    <div class="card">
                        <i class="icon-pizza-delivery"></i>
                        <h3 class="title">Entrega Premium</h3>
                        <p class="subtitle">
                            A nossa equipe é repleta de profissionais treinados que irão
                            proporcionar a melhor experiência na entrega da sua pizza.
                        </p>
                    </div>

                    <div class="card">
                        <i class="icon-pizza-flavors"></i>
                        <h3 class="title">Sabores</h3>
                        <p class="subtitle">
                            O Pizza DEV tem um cardápio repleto de sabores. Você pode montar
                            a pizza com até quatro sabores diferentes.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <div class="divider"></div>

        <!-- Quarta página -->
        <section class="section" id="contact">
            <div class="container grid">
                <div class="text">
                    <h2 class="title">Entre em contato com a gente !</h2>
                    <p class="subtitle">
                        Entre em contato com a Pizzaria, queremos tirar suas dúvidas,
                        ouvir suas críticas e sugestões.
                    </p>
                    <ul class="grid">
                        <li><i class="icon-phone"></i>(35) 3697-4950</li>
                        <li><i class="icon-map-pin"></i>Av. Dirce Pereira Rosa, 300</li>
                        <li><i class="icon-mail"></i>paulo.avila@ifsuldeminas.edu.br</li>
                    </ul>

                    <div class="align_button">
                        <a class="button"
                            href="https://api.whatsapp.com/send?phone=5511012345678&text=Oi ! Quero mais informações sobre as pizzas"
                            target="_blank">
                            <i class="icon-whatsapp"></i> Entrar em Contato
                        </a>
                    </div>
                </div>

                <div class="link">
                    <form method="post" action="">
                        <input type="text" name="nome" class="input-field" placeholder="* Nome completo:" value="<?= $_POST['nome'] ?? '' ?>" required />
                        <input type="email" name="email" class="input-field" placeholder="* E-mail:" value="<?= $_POST['email'] ?? '' ?>" required />
                        <input type="text" name="assunto" class="input-field" placeholder="* Assunto:" value="<?= $_POST['assunto'] ?? '' ?>" required />
                        <textarea name="mensagem" class="input-field" cols="1" rows="10"
                            placeholder="* Digite sua mensagem..." required value="<?= $_POST['mensagem'] ?? '' ?>"></textarea>
                        <button type="submit" class="button">
                            Enviar
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <div class="divider"></div>

    <!-- Rodapé -->
    <footer class="section">
        <div class="container grid">
            <div class="brand">
                <a class="logo logo-alt" href="#home">Pizza<span> DEV</span></a>
                <p>©2021 Pizza DEV.</p>
                <p>Todos os direitos reservados.</p>
            </div>
            <div class="social">
                <a href="https://instagram.com" target="_blank"><i class="icon-instagram"></i></a>
                <a href="https://facebook.com" target="_blank"><i class="icon-facebook"></i></a>
                <a href="https://youtube.com" target="_blank"><i class="icon-youtube"></i></a>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>

</html>
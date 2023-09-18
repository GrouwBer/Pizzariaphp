<?php


$con = mysqli_connect('localhost', 'root', '', 'trabalho');
if (mysqli_connect_errno()) {
    die('Não foi possível se conectar com o banco de dados: ' . mysqli_connect_error());
}
if(isset($_POST['ir'])){

    $usuario = mysqli_real_escape_string($con,$_POST['usuario']);
    $senha = mysqli_real_escape_string($con,base64_encode($_POST['senha']));
    echo $senha;
    if ($usuario != "" && $senha != ""){

        $sql_query = "select count(*) as cntUser from clientes where usuario='".$usuario."' and senha='".$senha."'";
        $result = mysqli_query($con,$sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];

        if($count > 0){
            $_SESSION['uname'] = $usuario;
            header('Location: index.php');
        }else{

            echo "Usuario ou senha invalido";
        }

    }

}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Administração | Pizza DEV</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/admin.css" />
</head>

<body>
    <header class="topo flex container-padding">
        <img src="../assets/images/pizza-dev.png" alt="Pizza DEV" />
    </header>
    <div class="login">
        <h1>Login Admin</h1>

        <form action="" method="post">
            <input type="text" name="usuario" id="usuario" class="input-field" placeholder="* Usuário" value="<?php $usuario; ?>" />
            <input type="password" name="senha" id="senha" class="input-field" placeholder="* Senha" />
            <button type="submit" class="botao" name="ir">
                Acessar
            </button>
             
        </form>
        <a href="cadastrar-usuario.php">Crie sua conta</a>
    </div>
</body>

</html>
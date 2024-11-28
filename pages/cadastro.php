<?php
// Verifica se o formulário foi enviado
if(isset($_POST['acao'])){
    // Trata e obtém os dados do formulário
    $login = strip_tags($_POST['login']);
    $senha = password_hash(strip_tags($_POST['senha']), PASSWORD_DEFAULT);
    $nome = $_POST['nome']; // Obtém o nome do usuário

    // Verifica se já existe um usuário com o mesmo login
    $sql = MySql::getConn()->prepare("SELECT * FROM user WHERE login = ?");
    $sql->execute(array($login));

    // Se o login já existir, exibe uma mensagem de erro e redireciona
    if($sql->rowCount() == 1){
        echo '<script>alert("Já existe este login...")</script>';
        echo '<script>location.href="/e-commerce/?url=login"</script>';
        die();
    }else{
        // Insere o novo usuário no banco de dados
        $sql = MySql::getConn()->prepare("INSERT INTO user VALUES (null, ?,?,?,?,?)");
        $sql->execute(array($login, $senha, "", 0 , $nome));
        echo '<script>alert("Cadastro feito com sucesso")</script>'; // Exibe mensagem de sucesso
        echo '<script>location.href="/e-commerce/?url=login"</script>';

    }
}

// Se o usuário já estiver logado, redireciona para a página principal
if(isset($_SESSION['login'])){
    echo '<script>location.href="/e-commerce"</script>';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="/e-commerce/pages/css/styles.css">
    <link rel="stylesheet" href="pages/fontawesome-free-6.6.0-web/css/all.css">
    <link rel="icon" type="image/x-icon" href="pages/images/1731979779455.png">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="primeira-coluna">
        <h2 class="titulo titulo-primario">Bem-vindo!</h2>
        <p class="descricao descricao-primaria">Já possui cadastro? Clique aqui!</p>
        <button id="entrar" class="btn btn-primario" onclick="window.location.href='/e-commerce/?url=login'">Entrar</button>
    </div>

    <div class="segunda-coluna">
        <h2 class="titulo titulo-secundario">Crie sua conta</h2>
        <p class="descricao descricao-secundaria">Use o seu e-mail pessoal para se registrar:</p>
        <form action="" method="POST" class="form">
            <label class="label-input" for="nome">
                <i class="fa-solid fa-user icone-mod"></i>
                <input type="text" name="nome" id="nome" placeholder="Nome" required>
            </label>
            <label class="label-input" for="login">
                <i class="fa-solid fa-envelope icone-mod"></i>
                <input type="text" name="login" id="login" placeholder="Login" required>
            </label>
            <label class="label-input" for="senha">
                <i class="fa-solid fa-lock icone-mod"></i>
                <input type="password" name="senha" id="senha" placeholder="Senha" required>
            </label>
            <button name="acao" class="btn btn-secundario" type="submit">Criar conta</button>
        </form>
    </div>
</div>

</body>
</html>
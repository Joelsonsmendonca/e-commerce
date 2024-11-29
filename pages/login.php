<?php
// Verifique se o formulário foi enviado
if (isset($_POST['acao'])) {
    // Coleta os valores dos campos login e senha que foram enviados pelo formulário
    $login = strip_tags($_POST['login']);
    $senha = strip_tags($_POST['senha']);

    // Prepara a consulta SQL para buscar usuário por login
    $sql = MySql::getConn()->prepare("SELECT * FROM user WHERE login = ?");
    $sql->execute(array($login));

    // Verifica se o usuário foi encontrado
    if ($sql->rowCount() == 1) {
        // Obter dados do usuário
        $user = $sql->fetch(PDO::FETCH_ASSOC);
        // Compara a senha fornecida com a senha criptografada armazenada no banco de dados
        if (password_verify($senha, $user['senha'])) {
            // Se a senha for válida, Inicializa a sessão do usuário
            $_SESSION['login'] = $login;
            $_SESSION['cargo'] = $user['cargo'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['id'] = $user['id'];
            // Redireciona para a página inicial
            echo '<script>location.href="/e-commerce"</script>';
        } else {
            // Exibe a mensagem de senha incorreta
            echo '<script>alert("Senha incorreta")</script>';
        }
    } else {
        // Exibe a mensagem de login não encontrado
        echo '<script>alert("Login não encontrado")</script>';
    }
} else if (isset($_GET['acao']) && $_GET['acao'] == 'deslogar') {
    // Logout do usuário
    session_unset();
    session_destroy();
    // O usuário é redirecionado para a página inicial
    echo '<script>location.href="/e-commerce"</script>';
    die();
}

// Verifica se o usuário já está logado
if (isset($_SESSION['login'])) {
    // Redireciona o usuário para a página inicial
    echo '<script>location.href="/e-commerce"</script>';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/e-commerce/pages/css/styles.css">
    <link rel="stylesheet" href="pages/fontawesome-free-6.6.0-web/css/all.css">
    <link rel="icon" type="image/x-icon" href="/e-commerce/pages/images/1731979779455.png">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="primeira-coluna">
        <h2 class="titulo titulo-primario">Olá! Já se cadastrou?</h2>
        <p class="descricao descricao-primaria">Se ainda não tiver cadastro, clique aqui!</p>
        <button id="criar" class="btn btn-primario" onclick="window.location.href='/e-commerce/?url=cadastro'">Criar conta</button>
    </div>

    <div class="segunda-coluna">
        <h2 class="titulo titulo-secundario">Entre na sua conta</h2>
        <p class="descricao descricao-secundaria">Use o seu login para entrar:</p>

        <form action="" method="POST" class="form">
            <label class="label-input" for="login">
                <i class="fa-solid fa-envelope icone-mod"></i>
                <input type="text" name="login" id="email2" placeholder="Login" required>
            </label>
            <label class="label-input" for="senha">
                <i class="fa-solid fa-lock icone-mod"></i>
                <input type="password" name="senha" id="senha2" placeholder="Senha" required>
            </label>
            <a class="senha" href="#">Esqueceu sua senha?</a>
            <button name="acao" class="btn btn-secundario" type="submit">Entrar</button>
        </form>
    </div>
</div>
</body>
</html>
<?php
// Check if the form was submitted
if (isset($_POST['acao'])) {
    // Get and sanitize form data
    $login = strip_tags($_POST['login']);
    $senha = strip_tags($_POST['senha']);
    $nome = isset($_POST['nome']) ? strip_tags($_POST['nome']) : '';

    // Prepare SQL query to fetch user by login
    $sql = MySql::getConn()->prepare("SELECT * FROM user WHERE login = ?");
    $sql->execute(array($login));

    // Check if the user was found
    if ($sql->rowCount() == 1) {
        // Get user data
        $user = $sql->fetch(PDO::FETCH_ASSOC);
        // Verify the password
        if (password_verify($senha, $user['senha'])) {
            // Initialize user session
            $_SESSION['login'] = $login;
            $_SESSION['cargo'] = $user['cargo'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['id'] = $user['id'];
            // Redirect to the homepage
            echo '<script>location.href="/e-commerce"</script>';
        } else {
            // Display incorrect password message
            echo '<script>alert("Senha incorreta")</script>';
        }
    } else {
        // Display login not found message
        echo '<script>alert("Login não encontrado")</script>';
    }
} else if (isset($_GET['acao']) && $_GET['acao'] == 'deslogar') {
    // Logout the user
    session_unset();
    session_destroy();
    // Redirect to the homepage
    echo '<script>location.href="/e-commerce"</script>';
    die();
}

// Check if the user is already logged in
if (isset($_SESSION['login'])) {
    // Redirect to the homepage
    echo '<script>location.href="/e-commerce"</script>';
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <link rel="stylesheet" href="/pages/css/styles.css"> <!-- Certifique-se de que o caminho esteja correto -->
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

        <!-- Formulário de login -->
        <form action="" method="POST" class="form">
            <!-- Campo de login -->
            <label class="label-input" for="login">
                <i class="fa-solid fa-envelope icone-mod"></i>
                <input type="text" name="login" id="login" placeholder="Login" required>
            </label>

            <!-- Campo de senha -->
            <label class="label-input" for="senha">
                <i class="fa-solid fa-lock icone-mod"></i>
                <input type="password" name="senha" id="senha" placeholder="Senha" required>
            </label>

            <!-- Lembre-se de mim -->
            <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Lembrar-me
                </label>
            </div>

            <!-- Link para recuperação de senha -->
            <a class="senha" href="#">Esqueceu sua senha?</a>

            <!-- Botão de login -->
            <button name="acao" class="btn btn-secundario w-100 py-2" type="submit">Entrar</button>
        </form>
    </div>
</div>
</body>
</html>

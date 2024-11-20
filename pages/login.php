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

<div class="container">
    <form method="POST">
        <h1 class="h3 mb-3 fw-normal">Faça login</h1>

        <div class="form-floating">
            <input name="login" type="text" class="form-control" id="floatingInput">
            <label for="floatingInput">Login</label>
        </div>
        <br/>
        <div class="form-floating">
            <input name="senha" type="password" class="form-control" id="floatingPassword">
            <label for="floatingPassword">Senha</label>
        </div>

        <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Lembrar-me
            </label>
        </div>
        <button name="acao" class="btn btn-primary w-100 py-2" type="submit">Entrar</button>
    </form>
</div>
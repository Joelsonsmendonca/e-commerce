<?php
// Verifica se o formulário foi enviado
if(isset($_POST['acao'])){
    // Obtém e trata os dados do formulário
    $login = strip_tags($_POST['login']);
    $senha = strip_tags($_POST['senha']);
    $nome = $_POST['nome'] ? $_POST['nome'] : '';

    // Prepara a consulta SQL para buscar o usuário pelo login
    $sql = MySql::getConn()->prepare("SELECT * FROM user WHERE login = ?");
    $sql->execute(array($login));

    // Verifica se o usuário foi encontrado
    if($sql->rowCount() == 1){
        // Obtém os dados do usuário
        $user = $sql->fetch(PDO::FETCH_ASSOC);
        // Verifica se a senha está correta
        if(password_verify($senha, $user['senha'])){
            // Inicia a sessão do usuário
            $_SESSION['login'] = $login;
            $_SESSION['cargo'] = $user['cargo'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['id'] = $user['id'];
            // Redireciona para a página inicial
            echo '<script>location.href="/e-commerce"</script>';
        } else {
            // Exibe mensagem de senha incorreta
            echo '<script>alert("Senha incorreta")</script>';
        }
    } else {
        // Exibe mensagem de login não encontrado
        echo '<script>alert("Login não encontrado")</script>';
    }
} else if (isset($_GET['acao']) && $_GET['acao'] == 'deslogar') {
    // Desloga o usuário
    $_SESSION['login'] = "";
    unset($_SESSION['login']);
    // Redireciona para a página inicial
    echo '<script>location.href="/e-commerce"</script>';
    die();
}

// Verifica se o usuário já está logado
if(isset($_SESSION['login'])){
    // Redireciona para a página inicial
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
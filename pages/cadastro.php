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
        echo '<script>location.href="/e-commerce"</script>';
        die();
    }else{
        // Insere o novo usuário no banco de dados
        $sql = MySql::getConn()->prepare("INSERT INTO user VALUES (null, ?,?,?,?,?)");
        $sql->execute(array($login, $senha, "", 0 , $nome));
        echo '<script>alert("Cadastro feito com sucesso")</script>'; // Exibe mensagem de sucesso
    }
}

// Se o usuário já estiver logado, redireciona para a página principal
if(isset($_SESSION['login'])){
    echo '<script>location.href="/e-commerce"</script>';
}
?>

<div class="container">
    <form method="POST">
        <h1 class="h3 mb-3 fw-normal">Cadastro</h1>

        <div class="form-floating">
            <input name="nome" type="text" class="form-control" id="floatingInput" placeholder="Maria José">
            <label for="floatingInput">Nome</label>
        </div>

        <br/>

        <div class="form-floating">
            <input name="login" type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Login</label>
        </div>
        <br/>
        <div class="form-floating">
            <input name="senha" type="password" class="form-control" id="floatingPassword" placeholder="Password">
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
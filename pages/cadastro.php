<?php
if(isset($_POST['acao'])){
    $login = strip_tags($_POST['login']);
    $senha = strip_tags($_POST['senha']);
    $nome = $_POST['nome'];

    $sql = MySql::getConn()->prepare("SELECT * FROM user WHERE login = ?");
    $sql->execute(array($login));

    if($sql->rowCount() == 1){
        //
        echo '<script>alert("Já existe este login...")</script>';
        echo '<script>location.href="/e-commerce"</script>';
        die();
    }else{
        $sql = MySql::getConn()->prepare("INSERT INTO user VALUES (null, ?, ?,?)");
        $sql->execute(array($login, $senha, ""));
        echo '<script>alert("Cadastro feito com sucesso")</script>';
    }
}

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
            <label for="floatingPassword">Password</label>
        </div>

        <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
Remember me
</label>
        </div>
        <button name="acao" class="btn btn-primary w-100 py-2" type="submit">Entrar</button>
        <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2024</p>

    </form>
</div>
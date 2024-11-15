<?php

    $url = "http://localhost:63342/e-commerce/?url=cadastrar-produto";

// Verifica se o formulário foi enviado
if(isset($_POST['acao'])){
    // Obtém os dados do formulário
    $nome = $_POST['nome-produto'];
    $descricao = $_POST['descricao-produto'];
    $preco = number_format((float)$_POST['preco'], 2, '.', ''); // Formata o preço como decimal

    // Verifica se o arquivo foi enviado
    if(isset($_FILES['foto'])){
        $foto = $_FILES['foto'];

        // Verifica se o arquivo foi enviado sem erros
        if($foto['error'] == UPLOAD_ERR_OK){
            // Obtém a extensão do arquivo
            $extensao = pathinfo($foto['name'], PATHINFO_EXTENSION);
            // Gera um novo nome único para o arquivo
            $novoNome = uniqid() . '.' . $extensao;
            // Define o diretório de destino do arquivo
            $diretorio = 'uploads/' . $novoNome;

            // Move o arquivo para o diretório de uploads
            if(move_uploaded_file($foto['tmp_name'], $diretorio)){
                // Verifica se o usuário está logado
                if(isset($_SESSION['id'])){
                    // Prepara a consulta SQL para inserir os dados no banco de dados
                    $sql = MySql::getConn()->prepare("INSERT INTO produtos VALUES (null, ?,?,?,?,?)");
                    // Executa a consulta com os dados do formulário e o caminho do arquivo
                    $sql->execute(array($nome, $descricao, $preco, $diretorio, $_SESSION['id']));
                    // Define a mensagem de sucesso na sessão
                    echo '<script>alert("Produto cadastrado com sucesso")</script>';
                    // Redireciona para a mesma página
                    header("Location: $url");
                    exit();
                } else {
                    // Exibe uma mensagem de erro se o usuário não estiver logado
                    echo '<script>alert("Usuário não está logado")</script>';
                }
            } else {
                // Exibe uma mensagem de erro se o arquivo não puder ser movido
                echo '<script>alert("Erro ao mover o arquivo")</script>';
            }
        } else {
            // Exibe uma mensagem de erro se nenhum arquivo for enviado
            echo '<script>alert("Nenhum arquivo foi enviado")</script>';
        }
    }
}
?>
<div class="container">
    <form method="POST" enctype="multipart/form-data">
        <h1 class="h3 mb-3 fw-normal">Cadastro</h1>

        <div class="form-floating">
            <input name="nome-produto" type="text" class="form-control" id="floatingInput">
            <label for="floatingInput">Nome do produto</label>
        </div>

        <br/>

        <div class="form-floating">
            <input name="descricao-produto" type="text" class="form-control" id="floatingInput">
            <label for="floatingInput">Descrição</label>
        </div>

        <br/>

        <div class="form-floating">
            <input name="preco" type="number" class="form-control" step="0.01" id="floatingInput">
            <label for="floatingInput">Preço</label>
        </div>

        <br/>
        <div class="form-floating">
            <input name="foto" type="file" class="form-control" id="floatingInput">
            <label for="floatingInput">Foto</label>
        </div>
        <br/>

        <button name="acao" class="btn btn-primary w-100 py-2" type="submit">Cadastrar</button>
        <br/>
    </form>
</div>
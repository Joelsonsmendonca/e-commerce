<?php
session_start();
include '../MySql.php';

if ($_SESSION['cargo'] != 1) {
    header('Location: /e-commerce/index.php');
    exit();
}

if (isset($_GET['produto_id']) && is_numeric($_GET['produto_id'])) {
    $produto_id = $_GET['produto_id'];
    $sql = MySql::getConn()->prepare("SELECT * FROM produtos WHERE id = ?");
    $sql->execute([$produto_id]);
    $produto = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$produto) {
        header('Location: /e-commerce/index.php');
        exit();
    }
} else {
    header('Location: /e-commerce/index.php');
    exit();
}

if (isset($_POST['acao'])) {
    $nome = $_POST['nome-produto'];
    $descricao = $_POST['descricao-produto'];
    $preco = number_format((float)$_POST['preco'], 2, '.', '');

    $sql = MySql::getConn()->prepare("UPDATE produtos SET `nome-produto` = ?, `descricao-produto` = ?, preco = ? WHERE id = ?");
    $sql->execute([$nome, $descricao, $preco, $produto_id]);

    header('Location: /e-commerce/index.php');
    exit();
}
?>

<div class="container">
    <form method="POST">
        <h1 class="h3 mb-3 fw-normal">Editar Produto</h1>

        <div class="form-floating">
            <input name="nome-produto" type="text" class="form-control" id="floatingInput" value="<?php echo htmlspecialchars($produto['nome-produto']); ?>">
            <label for="floatingInput">Nome do produto</label>
        </div>

        <br/>

        <div class="form-floating">
            <input name="descricao-produto" type="text" class="form-control" id="floatingInput" value="<?php echo htmlspecialchars($produto['descricao-produto']); ?>">
            <label for="floatingInput">Descrição</label>
        </div>

        <br/>

        <div class="form-floating">
            <input name="preco" type="number" class="form-control" step="0.01" id="floatingInput" value="<?php echo htmlspecialchars($produto['preco']); ?>">
            <label for="floatingInput">Preço</label>
        </div>

        <br/>

        <button name="acao" class="btn btn-primary w-100 py-2" type="submit">Salvar</button>
    </form>
</div>
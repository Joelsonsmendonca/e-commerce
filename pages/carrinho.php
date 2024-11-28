<?php
require_once __DIR__ . '/../MySql.php';

// Inicializa o carrinho se ele não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

$carrinho = $_SESSION['carrinho'];

// Atualiza a quantidade do produto no carrinho
if (isset($_POST['update_quantidade'])) {
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];
    if (isset($carrinho[$produto_id])) {
        if ($quantidade == 0) {
            unset($carrinho[$produto_id]);
        } else {
            $carrinho[$produto_id]['quantidade'] = $quantidade;
        }
        $_SESSION['carrinho'] = $carrinho;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <link rel="stylesheet" href="path/to/index.css">
</head>
<body>
<div class="container carrinho-container">
    <h1 class="carrinho-titulo">Seu Carrinho</h1>
    <table class="table table-striped carrinho-table">
        <thead>
        <tr>
            <th>Foto</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Total</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($carrinho) > 0): ?>
            <?php foreach ($carrinho as $produto_id => $produto): ?>
                <?php if (is_array($produto)): ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($produto['foto']); ?>" class="img-fluid"></td>
                        <td><?php echo htmlspecialchars($produto['nome-produto']); ?></td>
                        <td><?php echo htmlspecialchars($produto['descricao-produto']); ?></td>
                        <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="produto_id" value="<?php echo $produto_id; ?>">
                                <input type="number" name="quantidade" value="<?php echo $produto['quantidade']; ?>" min="0" step="1" class="form-control" style="width: 80px; display: inline;">
                                <button type="submit" name="update_quantidade" class="btn btn-atualizar btn-sm">Atualizar</button>                            </form>
                        </td>
                        <td>R$ <?php echo number_format($produto['preco'] * $produto['quantidade'], 2, ',', '.'); ?></td>
                        <td>
                            <a href="pages/remover_do_carrinho.php?produto_id=<?php echo $produto_id; ?>" class="btn btn-danger btn-sm">Remover</a>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Erro: Item do carrinho inválido.</td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Seu carrinho está vazio.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <?php
    $total = 0;
    foreach ($carrinho as $produto) {
        if (is_array($produto)) {
            $total += $produto['preco'] * $produto['quantidade'];
        }
    }
    ?>
    <div class="carrinho-total">
        <h2>Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h2>
    </div>
    <a href="/e-commerce/" class="carrinho-btn">Continuar Comprando</a>
</div>
</body>
</html>

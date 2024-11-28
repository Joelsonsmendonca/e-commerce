<body>
<div class="container mt-5 produto-container">
    <?php
    require_once __DIR__ . '/../MySql.php';

    if (isset($produto_id) && is_numeric($produto_id)) {
        $sql = MySql::getConn()->prepare("SELECT * FROM produtos WHERE id = ?");
        $sql->execute([$produto_id]);
        $produto = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$produto) {
            echo '<script>alert("Produto não encontrado!"); window.location.href = "/e-commerce/index.php";</script>';
            exit();
        }
    } else {
        echo '<script>alert("ID de produto inválido!"); window.location.href = "/e-commerce/index.php";</script>';
        exit();
    }
    ?>

    <div class="produto-card card">
        <div class="produto-imagem">
            <img class="produto-img" src="<?php echo htmlspecialchars($produto['foto']); ?>" alt="Imagem do produto">
        </div>
        <div class="produto-detalhes card-body">
            <h1 class="produto-titulo"><?php echo htmlspecialchars($produto['nome-produto']); ?></h1>
            <p class="produto-descricao card-text">Descrição: <?php echo htmlspecialchars($produto['descricao-produto']); ?></p>
            <p class="produto-preco preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
            <div class="produto-botoes d-flex">
                <a href="pages/adicionarCarrinho.php?produto_id=<?php echo $produto['id']; ?>" class="btn btn-primary btn-comprar">Comprar agora</a>
                <a href="/e-commerce/index.php" class="btn btn-secondary btn-voltar">Continuar comprando</a>
            </div>
        </div>
    </div>
</div>
</body>

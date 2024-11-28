<body>
<div class="container mt-5">
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

    <div class="card">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?php echo htmlspecialchars($produto['foto']); ?>" class="img-fluid rounded-start" alt="Imagem do produto">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h1 class="card-title"><?php echo htmlspecialchars($produto['nome-produto']); ?></h1>
                    <p class="card-text"><?php echo htmlspecialchars($produto['descricao-produto']); ?></p>
                    <p class="card-text"><strong>Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></strong></p>
                    <a href="pages/adicionarCarrinho.php?produto_id=<?php echo $produto['id']; ?>" class="btn btn-primary">Adicionar ao carrinho</a>
                    <a href="/e-commerce/index.php" class="btn btn-primary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<style>
    body {
        padding-top: 70px;
    }
</style>
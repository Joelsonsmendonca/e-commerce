<?php
// Incluindo o documento de conexão com o banco de dados e iniciando a conexão
include 'MySql.php';
session_start();
// Obtendo a URL atual
$currentUrl = $_SERVER['REQUEST_URI'];
$pasta_raiz = '/e-commerce/index.php';

// Verificando se a URL é a raiz do site
if ($currentUrl == '/e-commerce/' || $currentUrl == "$pasta_raiz") {
    $sql = MySql::getConn()->prepare("SELECT * FROM produtos");
    $sql->execute();
    $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <!-- Cabeçalho estático -->
    <!--<link rel="stylesheet" href="/pages/css/styles.css">-->
    <link rel="icon" type="image/x-icon" href="pages/images/1731979779455.png">
    <?php
    // Verifica se a página atual NÃO é login ou registro
    if (!isset($_GET['url']) || ($_GET['url'] !== 'login' && $_GET['url'] !== 'cadastro')) {
        ?>
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
            <div class="col-md-3 mb-2 mb-md-0">
                <a href="/e-commerce" class="d-inline-flex link-body-emphasis text-decoration-none">
                    <svg class="bi" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                </a>
            </div>
            <?php
            // Mensagem de boas-vindas
            if (isset($_SESSION['login'])) {
                echo '<h6>Olá, ' . $_SESSION['nome'] . '</h6>';
            }
            ?>
            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="/e-commerce" class="nav-link px-2 link-secondary">Inicio</a></li>
                <li><a href="../e-commerce/?url=carrinho" id="carrinho" class="nav-link px-2">Carrinho</a></li>
                <li><a href="#" class="nav-link px-2">Pricing</a></li>
                <li><a href="#" class="nav-link px-2">FAQs</a></li>
                <li><a href="#" class="nav-link px-2">About</a></li>
            </ul>
            <?php
            // Verificação se o usuário está logado, caso não, aparece o botão de entrar/registrar
            if (!isset($_SESSION['login'])) {
                ?>
                <div class="col-md-3 text-end">
                    <button type="button" id="Login" class="btn btn-outline-primary me-2">Entrar</button>
                    <button type="button" id="Cadastro" class="btn btn-primary">Registrar-se</button>
                </div>

            <?php } else { ?>
                <?php if ($_SESSION['cargo'] == 1) { ?> <!-- Verifica o cargo de administrador, caso seja 1 pode cadastrar produto -->
                    <div class="col-md-3 text-end">
                    <button type="button" id="cadastrar-produto" class="btn btn-primary">cadastrar produto</button>
                <?php } ?> <!-- Caso esteja logado, aparece botão de deslogar -->
                <button id="deslogar" type="button" class="btn btn-primary">deslogar</button>
                </div>
            <?php } ?>
        </header>
        <?php
    } // Fecha o if
    ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php
if (isset($_GET['url'])) {
    $url = $_GET['url'];
    if (preg_match('/^produto$/', $url)) {
        $produto_id = $_GET['id'];  // Agora o ID será capturado corretamente
        include('pages/produto.php');
    } elseif (file_exists('pages/' . $url . '.php')) {
        include('pages/' . $url . '.php');
    } else {
        include('pages/404.php');
    }
}

?>

<div class="container">
    <div class="row">
        <?php if ($currentUrl == '/e-commerce/' || $currentUrl == "$pasta_raiz"){ ?>
            <?php foreach ($produtos as $key=> $produto): ?>
                <div class="col-md-4">
                    <a href="?url=produto&id=<?php echo $produto['id']; ?>" id="detalhes" class="text-decoration-none">
                    <div class="card mb-4" style="width: 100%;">
                        <img src="<?php echo htmlspecialchars($produto['foto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($produto['nome-produto']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($produto['nome-produto']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($produto['descricao-produto']); ?></p>
                            <p class="card-text"><strong>Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></strong></p>
                            <a href="pages/adicionarCarrinho.php?produto_id=<?php echo $produto['id']; ?>" class="btn btn-primary">Adicionar ao carrinho</a>
                        </div>
                    </div>
                </div>
                </a>
            <?php endforeach; ?>
        <?php }; ?>
    </div>
</div>

<script>
    // Adiciona um evento de clique ao botão de cadastro de produto
    document.addEventListener('click', (event) => {
        const target = event.target;

        // Botão de cadastro de produto
        if (target.id === 'cadastrar-produto') {
            window.location.href = "?url=cadastrar-produto";
        }

        // Botão de login
        if (target.id === 'Login') {
            window.location.href = "?url=login";
        }

        // Botão de cadastro de usuários
        if (target.id === 'Cadastro') {
            window.location.href = "?url=cadastro";
        }

        // Botão de deslogar
        if (target.id === 'deslogar') {
            window.location.href = "?url=Login&acao=deslogar";
        }

        // Botão do carrinho
        if (target.id === 'carrinho') {
            window.location.href = "?url=carrinho";
        }

        // Botão de detalhes do produto
        if (target.id === 'detalhes') {
            const produtoId = target.dataset.produtoId; // Obter o ID do produto do atributo data
            if (produtoId) {
                window.location.href = `?url=produto&id=${produtoId}`;
            }
        }
    });


</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
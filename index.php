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

$urlValida = true;
if (isset($_GET['url'])) {
    $url = $_GET['url'];
    if (!preg_match('/^produto$/', $url) && !file_exists('pages/' . $url . '.php')) {
        $urlValida = false;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <?php
    // Verifica se a página atual NÃO é login ou registro
    if (!isset($_GET['url']) || ($_GET['url'] !== 'login' && $_GET['url'] !== 'cadastro')) {
        if ($urlValida) { ?>
    <!-- Cabeçalho estático -->
    <link rel="stylesheet" href="pages/css/index.css">
    <link rel="stylesheet" href="pages/fontawesome-free-6.6.0-web/css/all.css">
    <link rel="icon" type="image/x-icon" href="pages/images/1731979779455.png">


            <header>
                <?php
                // Mensagem de boas-vindas
                if (isset($_SESSION['login'])) {
                    echo '<h6>Olá, ' . $_SESSION['nome'] . '</h6>';
                }
                ?>
                <div class="barra-navegacao">
                    <div class="conteudo-cabecalho">
                        <div onclick="window.location.href='/e-commerce'" style="cursor: pointer;">
                            <h1 class="logotipo">ÔMEGA<span class="logotipo-destaque">STORE</span></h1>
                        </div>

                        <!-- Navegação com links para diferentes seções do site -->
                        <nav>
                            <ul>
                                <li><a href="/e-commerce">Início</a></li>
                                <li><a href="../e-commerce/?url=carrinho">Produtos</a></li>
                                <li><a href="#">Sobre</a></li>
                                <li><a href="#">Contato</a></li>
                            </ul>
                        </nav>

                        <!-- Carrinho Ícone -->
                        <button type="submit" id="carrinho" class="btn-carrinho">
                            <i class="fa-solid fa-cart-shopping" id="carrinho-icone"></i>
                        </button>
                    </div>
                </div>

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
        <?php }
    } ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-commerce</title>
</head>
<body>
<div class="container">
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
    <?php if ($currentUrl == '/e-commerce/' || $currentUrl == "http://localhost/e-commerce/?url=cadastro"): ?>

    <section class="shop container">
        <?php if ($currentUrl == '/e-commerce/' || $currentUrl == "$pasta_raiz"): ?>
            <h2 class="section-titulo"><b>Explore Nossos Produtos</b></h2>
        <?php endif; ?>
        <div class="shop-conteudo">
            <?php if (!empty($produtos)) : ?>
                <?php foreach ($produtos as $produto) : ?>
                    <div class="produto-box">
                        <!-- Imagem do produto -->
                        <a href="?url=produto&id=<?php echo $produto['id']; ?>">
                            <img src="<?php echo htmlspecialchars($produto['foto']); ?>"
                                 alt="<?php echo htmlspecialchars($produto['nome-produto']); ?>"
                                 class="produto-img">


                            <!-- Título do produto -->
                            <h2 class="produto-titulo">
                                <b><?php echo htmlspecialchars($produto['nome-produto']); ?></b>
                            </h2>

                            <!-- Preço do produto -->
                            <span class="preco">
                        R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                    </span>
                        </a>
                        <!-- Ícone de adicionar ao carrinho -->
                        <a href="pages/adicionarCarrinho.php?produto_id=<?php echo $produto['id']; ?>&redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                           class="add-carrinho">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</div>

<footer class="footer">
    <div class="container">
        <div class="footer-conteudo">
            <div class="footer-col">
                <div onclick="window.location.href='/e-commerce'" style="cursor: pointer;">
                    <h3><span class="logotipo-destaque">ÔMEGA</span>STORE</h3>
                </div>
                <p>© 2022 ÔMEGA STORE. Todos os direitos reservados.</p>
            </div>
            <div class="footer-col">
                <h3>Links</h3>
                <ul>
                    <li><a href="#">Início</a></li>
                    <li><a href="#">Produtos</a></li>
                    <li><a href="#">Sobre</a></li>
                    <li><a href="#">Contato</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Contato</h3>
                <ul>
                    <li><a href="tel:11999999999">(11) 99999-9999</a></li>
                    <li>
                        <a href="#" target="_blank">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                        <a href="#" target="_blank">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" target="_blank">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script src="pages/ecommerce.js"></script>
<?php endif; ?>

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

        // Botão de desconectar
        if (target.id === 'deslogar') {
            window.location.href = "?url=Login&acao=deslogar";
        }

        // Botão do carrinho
        if (target.id === 'carrinho' || target.id === 'carrinho-icone') {
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
</body>
</html>
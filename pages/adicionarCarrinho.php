<?php
session_start();
include '../MySql.php';

// Verifica se o produto_id foi passado na URL
if (isset($_GET['produto_id']) && is_numeric($_GET['produto_id'])) {
    $produto_id = $_GET['produto_id'];
    $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '/e-commerce/index.php';

    // Consulta o produto no banco de dados
    $sql = MySql::getConn()->prepare("SELECT * FROM produtos WHERE id = ?");
    $sql->execute([$produto_id]);
    $produto = $sql->fetch(PDO::FETCH_ASSOC);

    // Verifica se o produto foi encontrado
    if ($produto) {
        // Inicializa o carrinho se não estiver configurado
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // Adiciona ou atualiza a quantidade do produto no carrinho
        if (isset($_SESSION['carrinho'][$produto_id])) {
            $_SESSION['carrinho'][$produto_id]['quantidade'] += 1;
        } else {
            $produto['quantidade'] = 1;
            $_SESSION['carrinho'][$produto_id] = $produto;
        }

        // Redireciona para a página de origem
        header("Location: $redirect");
        exit();
    } else {
        // Produto não encontrado
        header("Location: $redirect");
        exit();
    }
} else {
    // ID inválido
    header("Location: /e-commerce/index.php");
    exit();
}
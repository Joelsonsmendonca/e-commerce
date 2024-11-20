<?php
session_start(); // Inicia a sessão

if (isset($_GET['produto_id']) && is_numeric($_GET['produto_id'])) {
    $produtoId = $_GET['produto_id'];
    if (isset($_SESSION['carrinho'][$produtoId])) {
        unset($_SESSION['carrinho'][$produtoId]);
    }
}
header('Location: /e-commerce/index.php?url=carrinho');
exit();
?>
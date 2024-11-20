<?php
session_start();
include '../MySql.php';

if ($_SESSION['cargo'] != 1) {
    header('Location: /e-commerce/index.php');
    exit();
}

if (isset($_GET['produto_id']) && is_numeric($_GET['produto_id'])) {
    $produto_id = $_GET['produto_id'];
    $sql = MySql::getConn()->prepare("DELETE FROM produtos WHERE id = ?");
    $sql->execute([$produto_id]);
}

header('Location: /e-commerce/index.php');
exit();
?>
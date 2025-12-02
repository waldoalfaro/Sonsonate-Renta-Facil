<?php
session_start();


if (isset($_SESSION['usuario'])) {
    header("Location: dashboard.php");
    exit;
}


header("Location: PaginaWeb.php");
exit;
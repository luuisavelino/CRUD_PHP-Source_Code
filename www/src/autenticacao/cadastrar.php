<?php

session_start();

require_once '../../vendor/autoload.php';

use \App\Domain\Model\Usuario;
use \App\Infrastructure\Repository\UsuarioDao;

if ($_SERVER["REQUEST_METHOD"] === 'POST'){


    if (empty($_POST['usuario']) || empty($_POST['senha']) || empty($_POST['email']) ||empty($_POST['empresa'])) {
        header('location: cadastrar.php?status=error');
        exit;
    }

    if ($_POST['senha'] != $_POST['senhaConfirmada']) {
        header('location: cadastrar.php?status=error');
        exit;
    }

    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('location: cadastrar.php?status=error');
        exit;
    }

    $verificacaoDao = new UsuarioDao();
    $row = $verificacaoDao->confirmaUsuario($_POST['usuario']);

    if($row != 0) {
        header('Location: cadastrar.php?status=error');
        exit;
    }


    $usuario = new Usuario();
    $usuario->setUsuario($_POST['usuario']);
    $usuario->setSenha($_POST['senha']);
    $usuario->setEmail($_POST['email']);
    $usuario->setEmpresa($_POST['empresa']);

    $UsuarioDao = new UsuarioDao();
    $UsuarioDao->create($usuario);

    header('location: ./login.php');
    exit;

}

include __DIR__.'/telaCadastrar.php';
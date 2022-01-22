<?php

require_once './sessao-usuarios.php';
require_once '../../vendor/autoload.php';

use \App\Domain\Model\Usuario;
use \App\Infrastructure\Repository\UsuarioDao;

define('TITLE','Cadastro de Usuarios');

if ($_SERVER["REQUEST_METHOD"] === 'POST'){


    if (empty($_POST['usuario']) || empty($_POST['senha']) || empty($_POST['email']) || empty($_POST['empresa']) || empty($_POST['permissao'])) {
        header('location: usuarios.php?status=error');
        exit;
    }

    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('location: usuarios.php?status=error');
        exit;
    }

    $usuario = new Usuario();
    $usuario->setUsuario($_POST['usuario']);
    $usuario->setSenha($_POST['senha']);
    $usuario->setEmail($_POST['email']);
    $usuario->setEmpresa($_POST['empresa']);
    $usuario->setPermissao($_POST['permissao']);

    $UsuarioDao = new UsuarioDao();
    $UsuarioDao->create($usuario);

    header('location: usuarios.php?status=success');
    exit;
}


include __DIR__.'/includes/header.php';
include __DIR__.'/includes/formulario.php';
include __DIR__.'/includes/footer.php';
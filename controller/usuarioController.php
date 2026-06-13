<?php
// Controlador de Usuario
// Se encarga del login y del registro de nuevos usuarios (RF01, RF02)

require_once __DIR__ . '/../models/Usuario.php';

$usuarioModelo = new Usuario($conexion);

$accion = $_GET['accion'] ?? 'login';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ---------- LOGIN ----------
    if ($accion === 'login') {

        $correo = trim($_POST['correo']);
        $password = $_POST['password'];

        $usuario = $usuarioModelo->buscarPorCorreo($correo);

        if ($usuario && password_verify($password, $usuario['password'])) {

            // Guardamos los datos del usuario en la sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_rol'] = $usuario['rol'];

            header('Location: index.php?page=ventas');
            exit;

        } else {
            $error = "Correo o contraseña incorrectos";
        }
    }

    // ---------- REGISTRO ----------
    if ($accion === 'registro') {

        $nombre = trim($_POST['nombre']);
        $correo = trim($_POST['correo']);
        $password = $_POST['password'];

        if ($nombre === '' || $correo === '' || $password === '') {
            $error = "Todos los campos son obligatorios";
        } else {

            $existe = $usuarioModelo->buscarPorCorreo($correo);

            if ($existe) {
                $error = "Ese correo ya está registrado";
            } else {
                $usuarioModelo->registrar($nombre, $correo, $password);
                header('Location: index.php?page=login');
                exit;
            }
        }
    }
}

// Mostramos la vista que corresponda
if ($accion === 'registro') {
    require __DIR__ . '/../public/views/registro.php';
} else {
    require __DIR__ . '/../public/views/login.php';
}

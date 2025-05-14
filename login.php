//Código PHP para el inicio de sesión
<?php
session_start();


$archivo = '/var/www/html/inicios_sesion.txt';

//La contraseña
define("CLAVE", "1234");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];

    if ($password === CLAVE) {

//Guarda la siguiente información en el archivo del principio 
        $fecha = date("Y-m-d H:i:s");
        file_put_contents($archivo, "$fecha - Usuario: $usuario\n", FILE_APPEND | LOCK_EX);
        echo "Escritura realizada";

        $_SESSION['usuario'] = $usuario;
        header("Location: index.php"); //Redirige a la página principal
        exit;
    } else {
        $error = "Contraseña incorrecta."; //Si está mal la contraseña no deja entrar
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="flex flex-col bg-white p-6 rounded-xl shadow-lg w-96">
        <h1 class="text-xl mb-4 text-center font-semibold">Inicio de sesión</h1>
        <?php if (isset($error)) echo "<p class='text-red-500 mb-2'>$error</p>"; ?>
        <form method="POST">
            <input name="usuario" type="text" placeholder="Nombre" required class="border w-full border-gray-700 rounded-md px-2 py-1 mb-4">
            <input name="password" type="password" placeholder="Contraseña" required class="border w-full border-gray-700 rounded-md px-2 py-1 mb-4">
            <button type="submit" class="bg-black w-full text-white py-2 rounded-md">Entrar</button>
        </form>
    </div>
</body>
</html>

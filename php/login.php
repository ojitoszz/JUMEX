<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<?php
// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Obtener datos del formulario
$usuario = $_POST["username"];
$password = $_POST["password"];

// Consulta SQL (corregida para evitar inyección SQL)
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ? AND pass = ?");
$stmt->bind_param("ss", $usuario, $password);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    // Iniciar sesión u otras operaciones necesarias
    
    header("location: Home.php");
} else {
    // Mostrar alerta de SweetAlert
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Acceso denegado',
                text: 'Usuario o contraseña incorrectos',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '../index.html'; // Redireccionar si se desea
            });
          </script>";
}
?>

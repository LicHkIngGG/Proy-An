<?php
// Incluir el archivo de configuración de la base de datos
require_once "db.php";

// Definir variables e inicializar con valores vacíos
$email = $password = "";
$email_err = $password_err = "";

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Por favor, ingrese su email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validar contraseña
    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor, ingrese su contraseña.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Verificar errores de entrada antes de autenticar al usuario
    if (empty($email_err) && empty($password_err)) {
        // Preparar una declaración select
        $sql = "SELECT id, name, email, password FROM users WHERE email = ?";

        if ($stmt = $conn->prepare($sql)) {
            // Vincular variables a la declaración preparada como parámetros
            $stmt->bind_param("s", $param_email);

            // Establecer parámetros
            $param_email = $email;

            // Intentar ejecutar la declaración preparada
            if ($stmt->execute()) {
                // Almacenar resultado
                $stmt->store_result();

                // Verificar si el email existe, luego verificar la contraseña
                if ($stmt->num_rows == 1) {
                    // Vincular variables de resultado
                    $stmt->bind_result($id, $name, $email, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // La contraseña es correcta, inicia una sesión nueva
                            session_start();

                            // Almacenar datos en variables de sesión
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $name;
                            $_SESSION["email"] = $email;

                            // Redirigir al usuario a la página de inicio
                            header("location: web.php");
                            exit; // Asegúrate de salir después de redirigir
                        } else {
                            // La contraseña no es válida
                            $password_err = "La contraseña que has ingresado no es válida.";
                        }
                    }
                } else {
                    // El email no existe
                    $email_err = "No se encontró ninguna cuenta con ese email.";
                }
            } else {
                echo "Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
            }

            // Cerrar declaración
            $stmt->close();
        }
    }

    // Cerrar conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <h2>Iniciar sesión</h2>
        <p>Por favor, complete sus credenciales para iniciar sesión.</p>
        <form action="index.php" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Iniciar sesión">
            </div>
            <p>¿No tienes una cuenta? <a href="register.php">Regístrate ahora</a>.</p>
        </form>
    </div>    
</body>
</html>
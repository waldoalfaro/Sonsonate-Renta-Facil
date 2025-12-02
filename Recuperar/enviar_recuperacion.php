<?php
session_start();
require '../conexion.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE usuario = ? OR correo = ?");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($resultado->num_rows === 1){
        $fila = $resultado->fetch_assoc();
        $token = bin2hex(random_bytes(32)); // token seguro
        $expira = date('Y-m-d H:i:s', strtotime('+1 minute'));

        $update = $conn->prepare("UPDATE usuarios SET token_recuperacion = ?, expira_token = ? WHERE id_usuario = ?");
        $update->bind_param("ssi", $token, $expira, $fila['id_usuario']);
        $update->execute();

        // Preparar correo
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'Waldoalfa011@gmail.com';
            $mail->Password   = 'biaj hvds wrqv qxbi'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('Waldoalfa011@gmail.com', 'Recuperar Contraseña');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Recuperar Contraseña';
            $mail->Body    = "Haz click en el siguiente enlace para restablecer tu contraseña: 
            <a href='http://localhost/Sistema-Renta-Facil/Recuperar/restablecer.php?token=$token'>Restablecer contraseña</a>
            <br>El enlace expira en 1 hora.";

            $mail->send();
            $_SESSION['recuperar_exito'] = "Se envió un correo con el enlace de recuperación.";
            header("Location: recuperar.php");
            exit;

        } catch (Exception $e) {
            $_SESSION['recuperar_error'] = "No se pudo enviar el correo. Intenta más tarde.";
            header("Location: recuperar.php");
            exit;
        }
    } else {
        $_SESSION['recuperar_error'] = "Correo no encontrado.";
        header("Location: recuperar.php");
        exit;
    }
}
?>

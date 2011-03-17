<?php
$nombre = $_POST['nombre'];
$mail = $_POST['email'];
$escuela = $_POST['escuela'];

if( $nombre == "" || $mail == "" || $escuela == "")
{
		header('location: contacto.php');
}else{

$header = 'From: ' . $mail . " \r\n";
$header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
$header .= "Mime-Version: 1.0 \r\n";
$header .= "Content-Type: text/plain";

$mensaje = "Este mensaje fue enviado por " . $nombre . ", de la escuela " . $escuela . " \r\n";
$mensaje .= "Su e-mail es: " . $mail . " \r\n";
$mensaje .= "Mensaje: " . $_POST['mensaje'] . " \r\n";
$mensaje .= "Enviado el " . date('d/m/Y', time());

$para = 'registro@socialgamersgdl.org';
$asunto = 'Contacto desde la web SGGDL';

mail($para, $asunto, utf8_decode($mensaje), $header);

header('location: contacto.php');
}
?>
	<?php 
session_start();
require_once 'registrationEv1.php';
require 'facebook/facebook.php';
$salt = "Bn+HfJRhzRDMT6MABn+HfJRhzRDMT6MuO1/rGFeBdJmSqLS9wuO1/rGFeBdYxOFOMjofEEUgYVg";
$maps_key = "ABQIAAAA8v6MHbrRr3H8QAP047b0LhTl6kdZIddW1u7SnJ54lT1ZuSgq3xRAHU-xO8nioLGcQoxxy_U4EOAWXQ";

$facebook = new Facebook(array(
	'appId'  => '149409948455161',//'131929556820645',
	'secret' => 'd30bbef29c86265fd1d1b5266bf1e9c9',//'6e9f54033a3f3cb08da5038337d76473',
	'cookie' => true,
));

$session = $facebook->getSession();
$me = array();

if ($session) {
	try {
		$uid = $facebook->getUser();
		$me = $facebook->api('/me');
	} catch (FacebookApiException $e) {
		error_log($e);
	}
}

$facebook_logout_url = $facebook->getLogoutUrl();
$registration = new Registration(array_merge($_POST, $_GET, $me));
$verified_is_registered = $registration->verified_is_registered();

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Social Gamers GDL</title>
<link rel="stylesheet" type="text/css" href="basic.css"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo $maps_key; ?>&sensor=false" type="text/javascript"></script>
</head>
<body onload="initialize()">
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId   : '<?php echo $facebook->getAppId(); ?>',
      session : <?php echo json_encode($session); ?>,
      status  : true,
      cookie  : true,
      xfbml   : true
    });

    FB.Event.subscribe('auth.login', function() {
      window.location.reload();
    });
  };

  (function() {
    var e = document.createElement('script');
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
  }());
</script>
 <script type="text/javascript">

    function initialize() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(20.677790, -103.372786), 15);
		var point = new GLatLng(20.677790, -103.372786);
    	map.addOverlay(new GMarker(point));
        map.setUIToDefault();
      }
    }

    </script>
<?php if ($registration->status == "user_registered" || $registration->status == "user_already_registered" ||
 		  $registration->status == "form_error"): ?>
	<div class="message"><?php echo $registration->message; ?></div>
<?php endif ?>

<div id="head">
<a href="http://www.facebook.com/pages/Social-Gamers-GDL/185175491526354"><img src="images/facebook.png" style="margin-left:20px" /></a>
    <a href="https://twitter.com/socialgamersgdl"><img src="images/twitter.png"  style="margin-left:20px" /></a>
</div>

<div class="left">

  <img src="images/LogoSocialGamers.png" alt="banner" style="margin-left:30px" />
  <br /><br /><br /><br />
    <ul>
    <li><a href="index.php">Inicio</a></li>
    <li class="active"><a href="inscripciones.php">Inscripciones</a></li>
    <li ><a href="colaboradores.php">Colaboradores</a></li>
    <li><a href="agenda.php">Agenda</a></li>
    <li><a href="FAQS.php">FAQS</a></li>
    <li><a href="contacto.php">Contacto</a></li>
    </ul>
     
    <br /><br />
     <div style="margin-left:20px;">
<iframe  src="http://www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/pages/Social-Gamers-GDL/185175491526354&amp;width=200&amp;colorscheme=dark&amp;show_faces=true&amp;stream=true&amp;header=false&amp;height=62" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:62px;" allowTransparency="true"></iframe>
<br /><br />
</div>
</div>

<div class="right">

 <!--<img src="images/portfolio.gif" style="border: none; margin: 0;" alt="portfolio" />-->
  <br /><br /><br />

 <div class="content">
	<h1>Curso de Flash</h1>
	<br />
	<p> Aqu&iacute; debo meter una muy linda descripci&oacute;n sobre el curso de Flash, pero ahorita urge m&aacute;s acabar con la parte t&eacute;cnica, as&iacute; que se las debo.</p>
    
    <br /> <br /> <br />
  
    <?php if ($registration->status != "user_registered" && $registration->status != "user_already_registered"): ?>
	<h3>Registro</h3>

	<p>Te pedimos que te registres para confirmar tu asistencia, eso nos ayuda a darnos una idea de cuanta gente esperar y tambi&eacute;n es una forma de dar a conocer lo que vas a hacer. Puedes hacerlo con tu cuenta de Twitter <strike>o de Facebook.</strike></p>
<?php endif ?>

<?php if ($registration->status == "init" || !empty($registration->verified_user)): ?>

	<div class="login-buttons">
		<div class="twitter-button">
			<?php if ( $verified_is_registered || (!empty($registration->verified_user) && $registration->verified_user['social_web'] == "twitter") ): ?>
				<img src="images/twitter_signin_inactive.png" alt="Registrate con Twitter" title="Registrate con Twitter">
			<?php else: ?>
				<a href="twitterEv1/redirect.php"><img src="images/twitter_signin.png" alt="Registrate con Twitter" title="Registrate con Twitter"></a>
			<?php endif ?>
		</div>
		<div class="facebook-button">
			<?php if ( $verified_is_registered ): ?>
				<img src="images/facebook_signin_inactive.png" alt="Registrate con Facebook" title="Registrate con Facebook">
			<?php elseif (!empty($me) && (!empty($registration->verified_user) && $registration->verified_user['social_web'] == "twitter")): ?>
				<a href="/"><img src="images/facebook_signin.png" alt="Registrate con Facebook" title="Registrate con Facebook"></a>
			<?php elseif (!empty($me)): ?>
				<img src="images/facebook_signin_inactive.png" alt="Registrate con Facebook" title="Registrate con Facebook">
			<?php else: ?>
				<fb:login-button v="2" onlogin="javascript:fb_login_button_click();">Login with Facebook</fb:login-button>
			<?php endif ?>
		</div>			
	</div>
<?php endif ?> 

<?php if ( !$verified_is_registered && ($registration->status == "twitter_verified" || $registration->status == "facebook_form" || 
										$registration->status == "form_error") ): ?>
	
	<div class="register_container">
		<div class="register_left">
			<img src="<?php echo $registration->verified_user['social_avatar_url'];?>" width="48" height="48" alt="avatar de usuario"/><br />
			<img src="images/<?php echo $registration->verified_user['social_web']; ?>16x16.png" width="16" height="16" style="margin-top:10px;" alt="social web"/>
		</div>

		<div class="register_right">
			<form action="/inscripcionesEv1.php" method="post" accept-charset="utf-8" style:"margin: 0px;">
				<input type="hidden" name="form_key" value="<?php echo md5($salt.$registration->verified_user['social_id']); ?>">
				<input type="hidden" name="social_web" value="<?php echo $registration->verified_user['social_web']; ?>">
				<input type="hidden" name="social_id" value="<?php echo $registration->verified_user['social_id']; ?>">
				<input type="hidden" name="social_username" value="<?php echo $registration->verified_user['social_username']; ?>">
				<input type="hidden" name="social_url" value="<?php echo $registration->verified_user['social_url']; ?>">
				<input type="hidden" name="social_avatar_url" value="<?php echo $registration->verified_user['social_avatar_url']; ?>">
				<table border="0" cellpadding="0" id="list_registered">
				<tbody>
					<tr>
						<td colspan="3"><h3>Datos personales</h3></td>							
					</tr>
					<tr>
						<td>
							<label for="name"><em>*</em> Nombre (s):</label><br />
							<input type="text" size="20" name="name" value="<?php echo $registration->verified_user['name']; ?>" id="name"><br /> 
						</td>
						<td>
							<label for="activity"><em>*</em> Apellido Paterno: </label>
							<input type="text" size="20" name="first_name" value="" id="first_name">
						</td>
						<td>
							<label for="activity"><em>*</em> Apellido Materno: </label>
							<input type="text" size="20" name="last_name" value="" id="last_name">
						</td>
					</tr>
					<tr>
						<td>
							<label for="activity"><em>*</em> E-mail: </label>
							<input type="text" size="20" name="email" value="" id="email">
						</td>
						<td>
							<label for="activity">Tel&eacute;fono: </label>
							<input type="text" size="20" name="phone" value="" id="phone">				
						</td>
						<td>
							<label for="activity">Celular: </label>
							<input type="text" size="20" name="cel_phone" value="" title="331-111-1111" id="cel_phone">
						</td>
					</tr>
					<tr>
						<td colspan="3"><h3>Direcci&oacute;n</h3></td>
					</tr>
					<tr>
						<td>
							<label for="activity"><em>*</em> Calle: </label>
							<input type="text" size="20" name="street" value="" id="street">				
						</td>
						<td>
							<label for="activity"><em>*</em> Num: </label>
							<input type="text" size="20" name="num" value="" id="num">				
						</td>
						<td>
							<label for="activity"><em>*</em> Colonia: </label>
							<input type="text" size="20" name="colony" value="" id="colony">				
						</td>
					</tr>
					<tr>
						<td>
							<label for="activity"><em>*</em> Ciudad: </label>
							<input type="text" size="20" name="city" value="" id="city">				
						</td>
						<td>
							<label for="activity"><em>*</em> C&oacute;digo Postal: </label>
							<input type="text" size="20" name="postal_code" value="" id="postal_code">				
						</td>
					</tr>
					<tr>
						<td>
							<label for="activity"><em>*</em> Universidad de procedencia: </label>
						</td>
						<td colspan="2">
							<select name="procedencia" id="procedencia" width="370px" style="width:370px">
								<option value='-2'>Universidad Tecnol�gica de la Zona Metropolitana de Guadalajara</option>
							  	<option value="-1">NINGUNA</option>
								<option value='412'>ANTIGUO Y BENEMERITO COLEGIO SANTA IN�S</option>
								<option value='591'>ANUIES - 286 Lic - Examen oral</option>
								<option value='586'>ANUIES - 286 Lic - Pr�ctico</option>
								<option value='502'>ANUIES-286 Lic.</option>
								<option value='365'>Bachillerato Juan de la Barrera</option>
								<option value='507'>Bachilleres "Veracruz"</option>
								<option value='474'>Benem�rita Universidad Aut�noma de Puebla</option>
								<option value='473'>Benem�rita y Centenaria Escuela Normal del Estado de San Luis Potos�</option>
								<option value='506'>CECYTE (Baja California)</option>
								<option value='359'>CECYTE (S.L.P.)</option>
								<option value='552'>Cementos Moctezuma, S.A. de C.V.</option>
								<option value='583'>CENEVAL - Piloto de Qu�mica</option>
								<option value='271'>CENIDET</option>
								<option value='430'>Centro de Actualizaci�n del Magisterio de Ciudad Ju�rez</option>
								<option value='603'>Centro de Bachillerato Tecnol�gico Industrial y de Servicios No. 230</option>
								<option value='528'>CENTRO DE ESTUDIOS SUPERIORES DE EDUCACI�N ESPECIALIZADA</option>
								<option value='535'>CENTRO DE ESTUDIOS SUPERIORES DE TUXTEPEC</option>
								<option value='375'>CENTRO DE ESTUDIOS SUPERIORES DEL ESTADO DE SONORA (CERRADO)</option>
								<option value='495'>Centro de Estudios Tecnol�gicos Industrial y de Servicios No. 100</option>
								<option value='419'>Centro Educativo Tom�s Moro, A.C.</option>
								<option value='537'>Centro Universitario Alianza</option>
								<option value='383'>Centro Universitario de Ciencias Sociales y Humanidades, UdeG (cerrado)</option>
								<option value='56'>Centro Universitario de la Costa - U de G</option>
								<option value='98'>CEPPEMS SEG</option>
								<option value='114'>CERTIFICACI�N EN ENFERMER�A</option>
								<option value='284'>CIIDET</option>
								<option value='377'>Colegio Atid</option>
								<option value='500'>Colegio Bilbao</option>
								<option value='424'>Colegio Buena Tierra, S.C.</option>
								<option value='590'>Colegio Crist�bal Col�n</option>
								<option value='523'>COLEGIO DE BACHILLERES DEL ESTADO DE CAMPECHE</option>
								<option value='508'>Colegio de Bachilleres del Estado de Morelos</option>
								<option value='421'>Colegio de Estudios Cient�ficos y Tecnol�gicos del Estado de Sonora</option>
								<option value='395'>Colegio de Postgraduados</option>
								<option value='584'>COLEGIO DE SAN IGNACIO DE LOYOLA VIZCA�NAS IAP</option>
								<option value='465'>COLEGIO MADRID, A.C.</option>
								<option value='97'>Colegio Reina Mar�a</option>
								<option value='526'>Complejo Educativo Ignacio Allende</option>
								<option value='106'>CONALEP</option>
								<option value='504'>CONALEP (Estado de Guanajuato)</option>
								<option value='553'>Consejo Nacional de Fomento Educativo</option>
								<option value='34'>Coordinaci�n General del Egel, UABC</option>
								<option value='265'>CRODE CELAYA</option>
								<option value='262'>CRODE CHIHUAHUA</option>
								<option value='296'>CRODE M�RIDA</option>
								<option value='293'>CRODE ORIZABA</option>
								<option value='534'>DEPARTAMENTO DE EDUCACI�N NORMAL DE SAN LUIS POTOS�</option>
								<option value='599'>DGETI (QUER�TARO)</option>
								<option value='394'>Educaci�n Superior Suiza, S.C.</option>
								<option value='154'>Escuela de Bachilleres Diurna - Constituci�n de 1917</option>
								<option value='524'>Escuela de Enfermer�a "Beatriz Gonz�lez Ortega"</option>
								<option value='533'>ESCUELA JOS� IBARRA OLIVARES</option>
								<option value='470'>Escuela Libre de Derecho</option>
								<option value='484'>Escuela Normal del Estado de Quer�taro `Andres Balvanera`</option>
								<option value='370'>Escuela Normal Particular "Camilo Arriaga"</option>
								<option value='347'>Escuela Preparatoria Dr. Alberto Zoebisch, S.C.</option>
								<option value='491'>Escuela Preparatoria Estatal No. 5 - Agust�n Franco Villanueva</option>
								<option value='401'>Escuela Preparatoria Regional del Rinc�n</option>
								<option value='525'>Escuela Secundaria Diurna No. 209 - Francisco Villa -</option>
								<option value='592'>Escuela Yvette Aranda</option>
								<option value='95'>Examen General de Conocimientos de la Licenciatura - Acuerdo 286 de la SEP</option>
								<option value='406'>Fideicomiso de Formaci�n y Capacitaci�n para el Personal de la Marina Mercante Nacional</option>
								<option value='428'>INFOTEC</option>
								<option value='151'>Instituto Andersen, A.C.</option>
								<option value='468'>INSTITUTO BLAISE PASCALE</option>
								<option value='152'>Instituto Carlos Gracida, A.C.</option>
								<option value='587'>Instituto Cenca</option>
								<option value='447'>Instituto de Ciencias y Estudios Superiores de Michoac�n, A.C.</option>
								<option value='446'>Instituto de Ciencias y Estudios Superiores de San Luis Potos�</option>
								<option value='386'>Instituto de Ciencias y Estudios Superiores de Tamaulipas, A.C.</option>
								<option value='11'>Instituto de Educaci�n de Aguascalientes</option>
								<option value='351'>Instituto de Educaci�n de Aguascalientes - Rezagados y For�neos</option>
								<option value='544'>INSTITUTO DE EDUCACI�N SUPERIOR "JOS� VASCONCELOS"</option>
								<option value='515'>Instituto de Servicios Educativos  y Pedag�gicos de Baja California</option>
								<option value='532'>Instituto Nacional de Bellas Artes y Literatura</option>
								<option value='536'>INSTITUTO PARA LA EDUCACI�N TECNICA DE SALAMANCA, A.C.</option>
								<option value='131'>Instituto Polit�cnico Nacional</option>
								<option value='516'>INSTITUTO SOR JUANA IN�S DE LA CRUZ</option>
								<option value='378'>Instituto T�cnico y Bancario San Carlos, A.C.</option>
								<option value='442'>INSTITUTO TECNOL�GICO AUT�NOMO DE M�XICO</option>
								<option value='198'>INSTITUTO TECNOL�GICO DE ACAPULCO</option>
								<option value='174'>INSTITUTO TECNOL�GICO DE AGUA PRIETA</option>
								<option value='30'>INSTITUTO TECNOL�GICO DE AGUASCALIENTES</option>
								<option value='211'>INSTITUTO TECNOL�GICO DE ALTAMIRA</option>
								<option value='234'>INSTITUTO TECNOL�GICO DE APIZACO</option>
								<option value='503'>INSTITUTO TECNOL�GICO DE ATITALAQUIA</option>
								<option value='188'>INSTITUTO TECNOL�GICO DE BAH�A DE BANDERAS</option>
								<option value='320'>INSTITUTO TECNOL�GICO DE CAMPECHE</option>
								<option value='127'>INSTITUTO TECNOL�GICO DE CD. JUAREZ</option>
								<option value='145'>INSTITUTO TECNOL�GICO DE CD. MADERO</option>
								<option value='360'>Instituto Tecnol�gico de Celaya (Posgrado)</option>
								<option value='250'>INSTITUTO TECNOL�GICO DE CERRO AZUL</option>
								<option value='286'>INSTITUTO TECNOL�GICO DE CHETUMAL</option>
								<option value='461'>INSTITUTO TECNOL�GICO DE CHIHUAHUA (DGEST)</option>
								<option value='232'>INSTITUTO TECNOL�GICO DE CHIHUAHUA II</option>
								<option value='266'>INSTITUTO TECNOL�GICO DE CHILPANCINGO</option>
								<option value='223'>INSTITUTO TECNOL�GICO DE CIUDAD ALTAMIRANO</option>
								<option value='161'>INSTITUTO TECNOL�GICO DE CIUDAD CUAUHT�MOC</option>
								<option value='192'>INSTITUTO TECNOL�GICO DE CIUDAD GUZM�N</option>
								<option value='237'>INSTITUTO TECNOL�GICO DE CIUDAD JIM�NEZ</option>
								<option value='215'>INSTITUTO TECNOL�GICO DE CIUDAD VALLES</option>
								<option value='201'>INSTITUTO TECNOL�GICO DE COLIMA</option>
								<option value='159'>INSTITUTO TECNOL�GICO DE COMIT�N</option>
								<option value='187'>INSTITUTO TECNOL�GICO DE COMITANCILLO</option>
								<option value='165'>INSTITUTO TECNOL�GICO DE CONKAL</option>
								<option value='218'>INSTITUTO TECNOL�GICO DE CUAUTLA</option>
								<option value='177'>INSTITUTO TECNOL�GICO DE CULIAC�N</option>
								<option value='142'>INSTITUTO TECNOL�GICO DE DELICIAS</option>
								<option value='199'>INSTITUTO TECNOL�GICO DE DURANGO</option>
								<option value='259'>INSTITUTO TECNOL�GICO DE EL LLANO AGUASCALIENTES</option>
								<option value='263'>INSTITUTO TECNOL�GICO DE EL SALTO</option>
								<option value='209'>INSTITUTO TECNOL�GICO DE ENSENADA</option>
								<option value='338'>INSTITUTO TECNOL�GICO DE ESTUDIOS SUPERIORES DE CHALCO</option>
								<option value='135'>Instituto Tecnol�gico de Estudios Superiores de Ecatepec</option>
								<option value='219'>INSTITUTO TECNOL�GICO DE ESTUDIOS SUPERIORES DE IXTAPALUCA</option>
								<option value='342'>INSTITUTO TECNOL�GICO DE ESTUDIOS SUPERIORES DE JILOTEPEC</option>
								<option value='343'>INSTITUTO TECNOL�GICO DE ESTUDIOS SUPERIORES DE JOCOTITL�N</option>
								<option value='210'>INSTITUTO TECNOL�GICO DE ESTUDIOS SUPERIORES DE LOS CABOS</option>
								<option value='322'>INSTITUTO TECNOL�GICO DE ESTUDIOS SUPERIORES DE SAN FELIPE DEL PROGRESO</option>
								<option value='345'>INSTITUTO TECNOL�GICO DE ESTUDIOS SUPERIORES DE VILLA GUERRERO</option>
								<option value='315'>INSTITUTO TECNOL�GICO DE ESTUDIOS SUPERIORES DE ZAMORA</option>
								<option value='173'>INSTITUTO TECNOL�GICO DE GUAYMAS</option>
								<option value='172'>INSTITUTO TECNOL�GICO DE HUATABAMPO</option>
								<option value='196'>INSTITUTO TECNOL�GICO DE HUEJUTLA</option>
								<option value='240'>INSTITUTO TECNOL�GICO DE IGUALA</option>
								<option value='407'>INSTITUTO TECNOL�GICO DE IZTAPALAPA</option>
								<option value='268'>INSTITUTO TECNOL�GICO DE JIQUILPAN</option>
								<option value='197'>INSTITUTO TECNOL�GICO DE LA COSTA GRANDE</option>
								<option value='274'>INSTITUTO TECNOL�GICO DE LA CUENCA DEL PAPALOAPAN</option>
								<option value='158'>INSTITUTO TECNOL�GICO DE LA PAZ</option>
								<option value='245'>INSTITUTO TECNOL�GICO DE LA PIEDAD</option>
								<option value='275'>INSTITUTO TECNOL�GICO DE LA REGI�N MIXE</option>
								<option value='287'>INSTITUTO TECNOL�GICO DE LA ZONA MAYA</option>
								<option value='290'>INSTITUTO TECNOL�GICO DE LA ZONA OLMECA</option>
								<option value='246'>INSTITUTO TECNOL�GICO DE L�ZARO C�RDENAS</option>
								<option value='224'>INSTITUTO TECNOL�GICO DE LE�N</option>
								<option value='323'>INSTITUTO TECNOL�GICO DE LERMA</option>
								<option value='272'>INSTITUTO TECNOL�GICO DE LINARES</option>
								<option value='357'>INSTITUTO TECNOL�GICO DE LOS MOCHIS</option>
								<option value='121'>INSTITUTO TECNOL�GICO DE MATAMOROS</option>
								<option value='288'>INSTITUTO TECNOL�GICO DE MATEHUALA</option>
								<option value='214'>INSTITUTO TECNOL�GICO DE MAZATL�N</option>
								<option value='452'>INSTITUTO TECNOL�GICO DE M�RIDA</option>
								<option value='402'>INSTITUTO TECNOL�GICO DE MILPA ALTA</option>
								<option value='294'>INSTITUTO TECNOL�GICO DE MINATITL�N</option>
								<option value='176'>INSTITUTO TECNOL�GICO DE NOGALES</option>
								<option value='148'>INSTITUTO TECNOL�GICO DE NUEVO LAREDO</option>
								<option value='354'>INSTITUTO TECNOL�GICO DE NUEVO LE�N</option>
								<option value='276'>INSTITUTO TECNOL�GICO DE OAXACA</option>
								<option value='191'>INSTITUTO TECNOL�GICO DE OCOTL�N</option>
								<option value='141'>INSTITUTO TECNOL�GICO DE ORIZABA</option>
								<option value='230'>INSTITUTO TECNOL�GICO DE PARRAL</option>
								<option value='238'>INSTITUTO TECNOL�GICO DE PIEDRAS NEGRAS</option>
								<option value='277'>INSTITUTO TECNOL�GICO DE PINOTEPA</option>
								<option value='283'>INSTITUTO TECNOL�GICO DE QUER�TARO</option>
								<option value='239'>INSTITUTO TECNOL�GICO DE ROQUE</option>
								<option value='186'>INSTITUTO TECNOL�GICO DE SALINA CRUZ</option>
								<option value='138'>INSTITUTO TECNOL�GICO DE SAN JUAN DEL R�O</option>
								<option value='179'>INSTITUTO TECNOL�GICO DE SAN LUIS POTOS�</option>
								<option value='71'>INSTITUTO TECNOL�GICO DE SONORA</option>
								<option value='231'>INSTITUTO TECNOL�GICO DE TAPACHULA</option>
								<option value='282'>INSTITUTO TECNOL�GICO DE TECOMATL�N</option>
								<option value='133'>INSTITUTO TECNOL�GICO DE TEHUAC�N</option>
								<option value='156'>INSTITUTO TECNOL�GICO DE TIJUANA</option>
								<option value='255'>INSTITUTO TECNOL�GICO DE TIZIM�N</option>
								<option value='410'>INSTITUTO TECNOL�GICO DE TL�HUAC</option>
								<option value='498'>INSTITUTO TECNOL�GICO DE TL�HUAC II</option>
								<option value='221'>INSTITUTO TECNOL�GICO DE TLAJOMULCO</option>
								<option value='278'>INSTITUTO TECNOL�GICO DE TLAXIACO</option>
								<option value='143'>INSTITUTO TECNOL�GICO DE TOLUCA</option>
								<option value='261'>INSTITUTO TECNOL�GICO DE TORRE�N</option>
								<option value='279'>INSTITUTO TECNOL�GICO DE TUXTEPEC</option>
								<option value='160'>INSTITUTO TECNOL�GICO DE TUXTLA GUTI�RREZ</option>
								<option value='295'>INSTITUTO TECNOL�GICO DE �RSULO GALV�N</option>
								<option value='167'>INSTITUTO TECNOL�GICO DE VERACRUZ</option>
								<option value='264'>INSTITUTO TECNOL�GICO DE VILLA MONTEMORELOS</option>
								<option value='248'>INSTITUTO TECNOL�GICO DE VILLAHERMOSA</option>
								<option value='257'>INSTITUTO TECNOL�GICO DE ZACATECAS</option>
								<option value='217'>INSTITUTO TECNOL�GICO DE ZACATEPEC</option>
								<option value='270'>INSTITUTO TECNOL�GICO DE ZIT�CUARO</option>
								<option value='292'>INSTITUTO TECNOL�GICO DEL ALTIPLANO DE TLAXCALA</option>
								<option value='273'>INSTITUTO TECNOL�GICO DEL ISTMO</option>
								<option value='541'>INSTITUTO TECNOLOGICO DEL VALLE DE GUADIANA</option>
								<option value='269'>INSTITUTO TECNOL�GICO DEL VALLE DE MORELIA</option>
								<option value='280'>INSTITUTO TECNOL�GICO DEL VALLE DE OAXACA</option>
								<option value='289'>INSTITUTO TECNOL�GICO DEL VALLE DEL YAQUI</option>
								<option value='512'>Instituto Tecnol�gico Gustavo A. Madero</option>
								<option value='216'>INSTITUTO TECNOL�GICO SUPERIOR DE ACATL�N DE OSORIO</option>
								<option value='251'>INSTITUTO TECNOL�GICO SUPERIOR DE ACAYUCAN</option>
								<option value='170'>INSTITUTO TECNOL�GICO SUPERIOR DE �LAMO TEMAPACHE</option>
								<option value='242'>INSTITUTO TECNOL�GICO SUPERIOR DE ARANDAS</option>
								<option value='181'>INSTITUTO TECNOL�GICO SUPERIOR DE ATLIXCO</option>
								<option value='337'>INSTITUTO TECNOL�GICO SUPERIOR DE C�JEME</option>
								<option value='324'>INSTITUTO TECNOL�GICO SUPERIOR DE CALKIN�</option>
								<option value='213'>INSTITUTO TECNOL�GICO SUPERIOR DE CANANEA</option>
								<option value='487'>INSTITUTO TECNOL�GICO SUPERIOR DE CHAMPOT�N</option>
								<option value='244'>INSTITUTO TECNOL�GICO SUPERIOR DE CHAPALA</option>
								<option value='400'>Instituto Tecnol�gico Superior de Chicontepec</option>
								<option value='303'>INSTITUTO TECNOL�GICO SUPERIOR DE CINTALAPA</option>
								<option value='229'>INSTITUTO TECNOL�GICO SUPERIOR DE CIUDAD ACU�A</option>
								<option value='316'>INSTITUTO TECNOL�GICO SUPERIOR DE CIUDAD CONSTITUCI�N</option>
								<option value='190'>INSTITUTO TECNOL�GICO SUPERIOR DE CIUDAD HIDALGO</option>
								<option value='183'>INSTITUTO TECNOL�GICO SUPERIOR DE CIUDAD SERD�N</option>
								<option value='258'>INSTITUTO TECNOL�GICO SUPERIOR DE COATZACOALCOS</option>
								<option value='398'>INSTITUTO TECNOL�GICO SUPERIOR DE COCULA</option>
								<option value='325'>INSTITUTO TECNOL�GICO SUPERIOR DE COMALCALCO</option>
								<option value='166'>INSTITUTO TECNOL�GICO SUPERIOR DE COSAMALOAPAN</option>
								<option value='147'>INSTITUTO TECNOL�GICO SUPERIOR DE EL GRULLO</option>
								<option value='93'>INSTITUTO TECNOL�GICO SUPERIOR DE ESC�RCEGA</option>
								<option value='180'>INSTITUTO TECNOL�GICO SUPERIOR DE FELIPE CARRILLO PUERTO</option>
								<option value='314'>INSTITUTO TECNOL�GICO SUPERIOR DE FRESNILLO</option>
								<option value='488'>INSTITUTO TECNOLOGICO SUPERIOR DE GUANAJUATO</option>
								<option value='252'>INSTITUTO TECNOL�GICO SUPERIOR DE HUATUSCO</option>
								<option value='300'>INSTITUTO TECNOL�GICO SUPERIOR DE HUAUCHINANGO</option>
								<option value='247'>INSTITUTO TECNOL�GICO SUPERIOR DE HUETAMO</option>
								<option value='195'>INSTITUTO TECNOL�GICO SUPERIOR DE HUICHAPAN</option>
								<option value='225'>INSTITUTO TECNOL�GICO SUPERIOR DE IRAPUATO</option>
								<option value='207'>INSTITUTO TECNOL�GICO SUPERIOR DE JER�Z</option>
								<option value='404'>INSTITUTO TECNOL�GICO SUPERIOR DE JES�S CARRANZA</option>
								<option value='241'>INSTITUTO TECNOL�GICO SUPERIOR DE LA COSTA CHICA</option>
								<option value='297'>INSTITUTO TECNOL�GICO SUPERIOR DE LA MONTA�A</option>
								<option value='163'>INSTITUTO TECNOL�GICO SUPERIOR DE LA REGI�N CARBON�FERA</option>
								<option value='227'>INSTITUTO TECNOL�GICO SUPERIOR DE LA REGI�N DE LOS LLANOS</option>
								<option value='310'>INSTITUTO TECNOL�GICO SUPERIOR DE LA SIERRA NORTE DE PUEBLA</option>
								<option value='363'>INSTITUTO TECNOL�GICO SUPERIOR DE LAGOS DE MORENO</option>
								<option value='253'>INSTITUTO TECNOL�GICO SUPERIOR DE LAS CHOAPAS</option>
								<option value='200'>INSTITUTO TECNOL�GICO SUPERIOR DE LERDO</option>
								<option value='326'>INSTITUTO TECNOL�GICO SUPERIOR DE LIBRES</option>
								<option value='205'>INSTITUTO TECNOL�GICO SUPERIOR DE LORETO</option>
								<option value='308'>INSTITUTO TECNOL�GICO SUPERIOR DE LOS REYES</option>
								<option value='327'>INSTITUTO TECNOL�GICO SUPERIOR DE LOS R�OS</option>
								<option value='328'>INSTITUTO TECNOL�GICO SUPERIOR DE MACUSPANA</option>
								<option value='411'>INSTITUTO TECNOL�GICO SUPERIOR DE MART�NEZ DE LA TORRE</option>
								<option value='413'>INSTITUTO TECNOL�GICO SUPERIOR DE MASCOTA, O.P.D.</option>
								<option value='301'>INSTITUTO TECNOL�GICO SUPERIOR DE MISANTLA</option>
								<option value='164'>INSTITUTO TECNOL�GICO SUPERIOR DE MONCLOVA</option>
								<option value='204'>INSTITUTO TECNOL�GICO SUPERIOR DE MOTUL</option>
								<option value='157'>INSTITUTO TECNOL�GICO SUPERIOR DE MULEG�</option>
								<option value='433'>INSTITUTO TECNOL�GICO SUPERIOR DE M�ZQUIZ</option>
								<option value='403'>INSTITUTO TECNOLOGICO SUPERIOR DE NARANJOS</option>
								<option value='235'>INSTITUTO TECNOL�GICO SUPERIOR DE NOCHISTL�N</option>
								<option value='162'>INSTITUTO TECNOL�GICO SUPERIOR DE NUEVO CASAS GRANDES</option>
								<option value='254'>INSTITUTO TECNOL�GICO SUPERIOR DE P�NUCO</option>
								<option value='298'>INSTITUTO TECNOL�GICO SUPERIOR DE P�TZCUARO</option>
								<option value='302'>INSTITUTO TECNOL�GICO SUPERIOR DE PEROTE</option>
								<option value='169'>INSTITUTO TECNOL�GICO SUPERIOR DE POZA RICA</option>
								<option value='203'>INSTITUTO TECNOL�GICO SUPERIOR DE PROGRESO</option>
								<option value='212'>INSTITUTO TECNOL�GICO SUPERIOR DE PUERTO PE�ASCO</option>
								<option value='329'>INSTITUTO TECNOL�GICO SUPERIOR DE PUERTO VALLARTA</option>
								<option value='330'>INSTITUTO TECNOL�GICO SUPERIOR DE R�O VERDE</option>
								<option value='490'>INSTITUTO TECNOL�GICO SUPERIOR DE SALVATIERRA</option>
								<option value='312'>INSTITUTO TECNOL�GICO SUPERIOR DE SAN ANDR�S TUXTLA</option>
								<option value='299'>INSTITUTO TECNOL�GICO SUPERIOR DE SAN MIGUEL EL GRANDE</option>
								<option value='331'>INSTITUTO TECNOL�GICO SUPERIOR DE SAN PEDRO COAHUILA</option>
								<option value='423'>INSTITUTO TECNOL�GICO SUPERIOR DE SANTA MAR�A DEL ORO</option>
								<option value='226'>INSTITUTO TECNOL�GICO SUPERIOR DE SANTIAGO PAPASQUIARO</option>
								<option value='332'>INSTITUTO TECNOL�GICO SUPERIOR DE TAC�MBARO</option>
								<option value='405'>INSTITUTO TECNOL�GICO SUPERIOR DE TALA</option>
								<option value='522'>INSTITUTO TECNOL�GICO SUPERIOR DE TAMAZULA DE GORDIANO (DGEST)</option>
								<option value='178'>INSTITUTO TECNOL�GICO SUPERIOR DE TAMAZUNCHALE</option>
								<option value='168'>INSTITUTO TECNOL�GICO SUPERIOR DE TANTOYUCA VERACRUZ</option>
								<option value='171'>INSTITUTO TECNOL�GICO SUPERIOR DE TEAPA DE LA REGI�N SIERRA</option>
								<option value='333'>INSTITUTO TECNOL�GICO SUPERIOR DE TEPEACA</option>
								<option value='185'>INSTITUTO TECNOL�GICO SUPERIOR DE TEPEXI</option>
								<option value='306'>INSTITUTO TECNOL�GICO SUPERIOR DE TEQUILA</option>
								<option value='182'>INSTITUTO TECNOL�GICO SUPERIOR DE TEZIUTL�N</option>
								<option value='313'>INSTITUTO TECNOL�GICO SUPERIOR DE TIERRA BLANCA</option>
								<option value='567'>INSTITUTO TECNOLOGICO SUPERIOR DE TLATLAUQUITEPEC</option>
								<option value='317'>INSTITUTO TECNOL�GICO SUPERIOR DE TLAXCO</option>
								<option value='202'>INSTITUTO TECNOL�GICO SUPERIOR DE VALLADOLID</option>
								<option value='425'>INSTITUTO TECNOL�GICO SUPERIOR DE VENUSTIANO CARRANZA</option>
								<option value='334'>INSTITUTO TECNOL�GICO SUPERIOR DE VILLA LA VENTA</option>
								<option value='356'>INSTITUTO TECNOL�GICO SUPERIOR DE XALAPA</option>
								<option value='311'>INSTITUTO TECNOL�GICO SUPERIOR DE ZACAPOAXTLA</option>
								<option value='206'>INSTITUTO TECNOL�GICO SUPERIOR DE ZACATECAS NORTE</option>
								<option value='236'>INSTITUTO TECNOL�GICO SUPERIOR DE ZACATECAS OCCIDENTE</option>
								<option value='335'>INSTITUTO TECNOL�GICO SUPERIOR DE ZAPOPAN</option>
								<option value='220'>INSTITUTO TECNOL�GICO SUPERIOR DE ZAPOTLANEJO</option>
								<option value='222'>INSTITUTO TECNOL�GICO SUPERIOR DEL OCCIDENTE DEL ESTADO DE HIDALGO</option>
								<option value='193'>INSTITUTO TECNOL�GICO SUPERIOR DEL ORIENTE DEL ESTADO DE HIDALGO</option>
								<option value='304'>INSTITUTO TECNOL�GICO SUPERIOR DEL SUR DE GUANAJUATO</option>
								<option value='256'>INSTITUTO TECNOL�GICO SUPERIOR DEL SUR DEL ESTADO DE YUCAT�N</option>
								<option value='309'>INSTITUTO TECNOL�GICO SUPERIOR PURHEPECHA</option>
								<option value='208'>INSTITUTO TECNOL�GICO SUPERIOR ZACATECAS SUR</option>
								<option value='469'>LAMAR MEXICANA, A.C.</option>
								<option value='374'>Mi cliente (PRUEBA EGEL)</option>
								<option value='477'>Odontolog�a (Aplicaci�n EGEL)</option>
								<option value='352'>Preparatoria Jos� Ma. Morelos y Pav�n, A.C.</option>
								<option value='482'>PREPARATORIA REGIONAL TEJUPILCO, A.C.</option>
								<option value='103'>Registro en L�nea (DEMO)</option>
								<option value='78'>Secretar�a Acad�mica Regional Zona Coatzacoalcos-Minatitl�n, U Veracruzana</option>
								<option value='427'>Secretar�a de Educaci�n de Jalisco</option>
								<option value='596'>Secretar�a de Educaci�n del Estado de M�xico</option>
								<option value='420'>Secretar�a de Educaci�n del Gobierno del Estado de Yucat�n</option>
								<option value='520'>Secretaria de Educaci�n y Cultura del Estado de Sonora</option>
								<option value='438'>SECRETARIA DE SERVICIOS DE SALUD DE VILLAHERMOSA</option>
								<option value='496'>Servicios Educativos de Quintana Roo</option>
								<option value='476'>SISTEMA EDUCATIVO ESTATAL REGULAR</option>
								<option value='492'>TECNOL�GICO DE ESTUDIOS SUPERIORES DE CHIMALHUAC�N</option>
								<option value='463'>TECNOL�GICO DE ESTUDIOS SUPERIORES DE COACALCO</option>
								<option value='344'>TECNOL�GICO DE ESTUDIOS SUPERIORES DE TIANGUISTENCO</option>
								<option value='0'>Tecnol�gico de Monterrey</option>
								<option value='69'>Unidad Culiac�n, U. Valle del Bravo</option>
								<option value='26'>UNITEC - Universidad Tecnol�gica de M�xico</option>
								<option value='128'>Universidad An�huac</option>
								<option value='379'>Universidad Aut�noma Agraria Antonio Narro</option>
								<option value='140'>Universidad Aut�noma Benito Ju�rez de Oaxaca</option>
								<option value='575'>Universidad Aut�noma de Baja California (Cerrado)</option>
								<option value='557'>Universidad Aut�noma de Baja California (EGEL-Tijuana)</option>
								<option value='361'>Universidad Aut�noma de Baja California Sur</option>
								<option value='2'>Universidad Aut�noma de Chiapas</option>
								<option value='120'>Universidad Aut�noma de Ciudad Ju�rez</option>
								<option value='455'>Universidad Aut�noma de Fresnillo, A.C.</option>
								<option value='112'>Universidad Aut�noma de Guerrero</option>
								<option value='578'>UNIVERSIDAD AUT�NOMA DE NUEVO LE�N</option>
								<option value='440'>Universidad Aut�noma de Quer�taro</option>
								<option value='129'>Universidad Aut�noma de San Luis Potosi</option>
								<option value='497'>Universidad Aut�noma de Sinaloa_</option>
								<option value='369'>Universidad Aut�noma de Tamaulipas</option>
								<option value='570'>Universidad Aut�noma de Yucat�n (ACREL-EIN)</option>
								<option value='582'>Universidad Aut�noma de Zacatecas_</option>
								<option value='450'>Universidad Aut�noma del Estado de Hidalgo (Ex�menes de Admisi�n)</option>
								<option value='153'>Universidad Aut�noma del Estado de M�xico (Cerrado)</option>
								<option value='451'>Universidad Aut�noma del Estado de Morelos</option>
								<option value='519'>UNIVERSIDAD AUT�NOMA IND�GENA DE M�XICO</option>
								<option value='545'>Universidad Aut�noma Metropolitana</option>
								<option value='429'>Universidad Continente Americano</option>
								<option value='126'>Universidad Cuauht�moc</option>
								<option value='109'>Universidad de Colima</option>
								<option value='123'>Universidad de Occidente</option>
								<option value='513'>Universidad del Caribe</option>
								<option value='529'>Universidad del F�tbol y Ciencias del Deporte, A.C.</option>
								<option value='82'>Universidad del Golfo de M�xico, San Andr�s Tuxtla - ACREL-EIN</option>
								<option value='466'>Universidad del Valle de Atemajac</option>
								<option value='6'>Universidad del Valle de M�xico</option>
								<option value='602'>Universidad Estatal del Valle de Ecatepec</option>
								<option value='453'>Universidad Iberoamericana Puebla</option>
								<option value='517'>Universidad Iberoamericana Torre�n</option>
								<option value='28'>Universidad Iberoamericana, Ciudad de M�xico</option>
								<option value='494'>Universidad Interamericana de Guaymas</option>
								<option value='483'>Universidad Intercultural del Estado de M�xico</option>
								<option value='543'>Universidad Intercultural del Estado de Puebla</option>
								<option value='601'>Universidad Intercultural del Estado de Tabasco</option>
								<option value='505'>Universidad Internacional Jefferson</option>
								<option value='136'>Universidad Ju�rez Aut�noma de Tabasco</option>
								<option value='13'>Universidad Ju�rez del Estado de Durango</option>
								<option value='554'>Universidad La Salle - Nezahualc�yotl</option>
								<option value='549'>UNIVERSIDAD LATINA DE MEXICO</option>
								<option value='579'>Universidad Metropolitana de Monterrey</option>
								<option value='367'>Universidad Michoacana de San Nicol�s de Hidalgo</option>
								<option value='593'>Universidad Modelo (EGEL)</option>
								<option value='422'>Universidad Nacionial Aeron�utica en Quer�taro</option>
								<option value='439'>Universidad Panamericana</option>
								<option value='445'>Universidad Pedag�gica Nacional (Exani III)</option>
								<option value='471'>Universidad Pedag�gica Nacional (Unidad 022 - Tijuana)</option>
								<option value='531'>Universidad Pedag�gica Nacional (Unidad 111 - Guanajuato)</option>
								<option value='562'>Universidad Pedag�gica Nacional (Unidad 141 - Guadalajara)</option>
								<option value='521'>Universidad Pedag�gica Nacional (Unidad 213 - Tehuac�n)</option>
								<option value='556'>Universidad Pedag�gica Nacional (Unidad 282 - Tampico)</option>
								<option value='542'>Universidad Pedag�gica Nacional (Unidad 283 - Matamoros)</option>
								<option value='565'>UNIVERSIDAD PEDAGOGICA NACIONAL (Unidad 285 - Reynosa)</option>
								<option value='368'>Universidad Pedag�gica Nacional (UNIDADES 142,143,144, 145)</option>
								<option value='555'>UNIVERSIDAD PEDAGOGICA NACIONAL UNIDAD NUEVO LAREDO</option>
								<option value='318'>Universidad Polit�cnica de Altamira</option>
								<option value='408'>Universidad Polit�cnica de Chiapas</option>
								<option value='588'>Universidad Polit�cnica de G�mez Palacio</option>
								<option value='558'>Universidad Polit�cnica de Nuevo Le�n en Apodaca</option>
								<option value='574'>Universidad Polit�cnica de San Luis Potos�</option>
								<option value='480'>Universidad Polit�cnica de Tec�mac</option>
								<option value='514'>Universidad Polit�cnica de Tlaxcala Poniente</option>
								<option value='459'>Universidad Polit�cnica de Tulancingo</option>
								<option value='559'>UNIVERSIDAD POLITECNICA DEL SUR DE ZACATECAS</option>
								<option value='594'>Universidad Polit�cnica Metropolitana de Hidalgo</option>
								<option value='563'>Universidad Polit�cnica Metropolitana de Puebla</option>
								<option value='449'>Universidad Popular Aut�noma del Estado de Puebla</option>
								<option value='472'>Universidad Regiomontana, A.C.</option>
								<option value='572'>UNIVERSIDAD TANGAMANGA S.C.</option>
								<option value='119'>Universidad Tec Milenio</option>
								<option value='384'>Universidad Tec Milenio (Egel-Abierto)</option>
								<option value='426'>Universidad Tecnol�gica de Durango (Admisi�n)</option>
								<option value='467'>Universidad Tecnol�gica de Huejotzingo</option>
								<option value='571'>Universidad Tecnol�gica de Jalisco</option>
								<option value='456'>Universidad Tecnol�gica de la Costa Grande de Guerrero</option>
								<option value='493'>Universidad Tecnol�gica de la Huasteca Hidalguense</option>
								<option value='547'>Universidad Tecnol�gica de la Laguna Durango</option>
								<option value='457'>Universidad Tecnol�gica de la Selva</option>
								<option value='397'>Universidad Tecnol�gica de Le�n</option>
								<option value='589'>Universidad Tecnol�gica de Oriental</option>
								<option value='551'>Universidad Tecnol�gica de Tulancingo</option>
								<option value='485'>UNIVERSIDAD TECNOLOGICA DEL CENTRO DE VERACRUZ</option>
								<option value='479'>UNIVERSIDAD TECNOLOGICA DEL ESTADO DE ZACATECAS</option>
								<option value='548'>Universidad Tecnol�gica del Norte de Guanajuato</option>
								<option value='600'>Universidad Tecnol�gica del Sur de Sonora</option>
								<option value='475'>Universidad Tecnol�gica del Sur del Estado de M�xico</option>
								<option value='481'>Universidad Tecnol�gica del Suroeste de Guanajuato</option>
								<option value='391'>Universidad Tecnol�gica del Valle del Mezquital</option>
								<option value='546'>UNIVERSIDAD TECNOL�GICA FIDEL VEL�ZQUEZ</option>
								<option value='501'>Universidad Vasco de Quiroga, A.C.</option>
								<option value='580'>UNIVERSIDAD VIRTUAL LIVERPOOL</option>
								<option value='444'>Universidad Westhill</option>
			                </select>
						</td>
					</tr>
					<tr>
						<td>
							<label for="own_pc"><em>*</em> Llevar&eacute; mi propio equipo de c&oacute;mputo:</label>
						</td>
						<td>
							<input type="radio" name="own_pc" value="1" checked="checked"/><span class="bold"> Si<br/>
							<input type="radio" name="own_pc" value="0"/><span class="bold"> No</span>
						</td>
					</tr>
				</tbody>
				</table>
				<input type="submit" value="Registrar">
			</form>
		</div>
	</div>
	<script type="text/javascript">$("#activity").focus();</script>
<?php endif ?>


<h3>Lista de Registrados (<?php echo count($registration->users); ?>)</h3>

	<table>
		<thead>
			<tr>
				<th width="10%"></th>
				<th width="60%t">Nombre</th>
				<th width="30%">Red Social</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($registration->users as $user): ?>
			<tr>
				<td><img src="<?php echo $user['social_avatar_url']; ?>" width="48" height="48" /></td>
				<td class="t_name"><?php echo $user['name']; ?></td>
				<td class="t_<?php echo $user['social_web']; ?>"><a href="<?php echo $user['social_url']; ?>"><?php echo $user['social_username']; ?></a></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<div id="footer" style="margin-top:100px; width:500px">
		<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/2.5/mx/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/2.5/mx/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/InteractiveResource" property="dct:title" rel="dct:type">Social Gamers GDL</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://buulinc.com" property="cc:attributionName" rel="cc:attributionURL">Buul Social Technologies S.A. de C.V.</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/2.5/mx/">Creative Commons Attribution-NonCommercial-ShareAlike 2.5 Mexico License</a>.<br />Based on a work at <a xmlns:dct="http://purl.org/dc/terms/" href="http://buulgames.com.mx/socialgamersgdl/" rel="dct:source">buulgames.com.mx</a>.<br />Permissions beyond the scope of this license may be available at <a xmlns:cc="http://creativecommons.org/ns#" href="h
 ttp://mx.linkedin.com/in/fernandosahagun/es" rel="cc:morePermissions">http://mx.linkedin.com/in/fernandosahagun/es</a>.
 || Agradecimientos especiales a <a href="http://twitter.com/pablasso">@pablasso</a>
 <br/>  <a href="http://www.templatesold.com/" target="_blank">Website Templates</a> by <a href="http://www.free-css-templates.com/" target=		"_blank">Free CSS Templates</a>
	</div>
</div>

</div>

</body>
</html>
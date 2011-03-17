<?php 
session_start();
require_once 'registrationEv2.php';
require 'facebook/facebook.php';
$salt = "typearandomsalt";

$facebook = new Facebook(array(
	'appId'  => 'yourfbappid',
	'secret' => 'yourfbsecret',
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
</div>

<div class="right">

 <!--<img src="images/portfolio.gif" style="border: none; margin: 0;" alt="portfolio" />-->
  <br /><br /><br />

 <div class="content">
	<h1>Blender</h1>
	<br />
	<p> Aqu&iacute; debo meter una muy linda descripci&oacute;n sobre el curso de Blender, pero ahorita urge m&aacute;s acabar con la parte t&eacute;cnica, as&iacute; que se las debo.</p>
    
    <br /> <br /> <br />
   
    <?php if ($registration->status != "user_registered" && $registration->status != "user_already_registered"): ?>
	<h3>Registro</h3>

	<p>Te pedimos que te registres para confirmar tu asistencia, eso nos ayuda a darnos una idea de cuánta gente esperar y también es una forma de dar a conocer lo que vas a hacer. Puedes hacerlo con tu cuenta de Twitter <strike>o de Facebook.</strike></p>
<?php endif ?>

<?php if ($registration->status == "init" || !empty($registration->verified_user)): ?>

	<div class="login-buttons">
		<div class="twitter-button">
			<?php if ( $verified_is_registered || (!empty($registration->verified_user) && $registration->verified_user['social_web'] == "twitter") ): ?>
				<img src="images/twitter_signin_inactive.png" alt="Registrate con Twitter" title="Registrate con Twitter">
			<?php else: ?>
				<a href="twitterEv2/redirect.php"><img src="images/twitter_signin.png" alt="Registrate con Twitter" title="Registrate con Twitter"></a>
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
			<form action="/inscripcionesEv2.php" method="post" accept-charset="utf-8" style:"margin: 0px;">
				<input type="hidden" name="form_key" value="<?php echo md5($salt.$registration->verified_user['social_id']); ?>">
				<input type="hidden" name="social_web" value="<?php echo $registration->verified_user['social_web']; ?>">
				<input type="hidden" name="social_id" value="<?php echo $registration->verified_user['social_id']; ?>">
				<input type="hidden" name="social_username" value="<?php echo $registration->verified_user['social_username']; ?>">
				<input type="hidden" name="social_url" value="<?php echo $registration->verified_user['social_url']; ?>">
				<input type="hidden" name="social_avatar_url" value="<?php echo $registration->verified_user['social_avatar_url']; ?>">
				<label for="name">Nombre</label><br />
				<input type="text" size="90" name="name" value="<?php echo $registration->verified_user['name']; ?>" id="name" style="height:2em;"><br /><br />
				<label for="activity">¿Qué vas a hacer?</label><br />
				&nbsp;<textarea name="activity" value="" id="activity" cols="65" rows="3"></textarea><br />
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
				<th></th>
				<th>Nombre</th>
				<th>Red Social</th>
				<th>¿Qué voy a hacer?</th>
			</tr>
		</thead>
		<tbody>
        
			<?php foreach ($registration->users as $user): ?>
			<tr>
				<td><img src="<?php echo $user['social_avatar_url']; ?>" width="48" height="48" /></td>
				<td class="t_name"><?php echo $user['name']; ?></td>
				<td class="t_<?php echo $user['social_web']; ?>"><a href="<?php echo $user['social_url']; ?>"><?php echo $user['social_username']; ?></a></td>
				<td class="t_description"><?php echo $user['activity']; ?></td>
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Social Gamers GDL</title>
<link rel="stylesheet" type="text/css" href="basic.css"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script type="text/javascript">
function validar(){
	var a = document.contacto.nombre.value.length;
	var b = document.contacto.escuela.value.length;
	var c = document.contacto.email.value.length;
	var d = document.contacto.email.value;
	
	if(a == 0 || b == 0 || c == 0){
		alert("Por favor rellene todos los campos");
		return 0;
	}else{
		return true;
	}
}
</script>
</head>

<!--GOOGLE ANALYTICS-->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22011435-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

<body>

<!--ENCABEZADO-->
<div id="head">
	<a href="http://www.utzmg.edu.mx"><img src="images/utzmg.jpg" style="margin-left:20px" width="60"></a>
	<a href="http://www.facebook.com/pages/Social-Gamers-GDL/185175491526354"><img src="images/facebook.png" style="margin-left:20px" /></a>
    <a href="https://twitter.com/socialgamersgdl"><img src="images/twitter.png"  style="margin-left:20px" /></a>
</div>

<!--BARRA-->
<div class="left">
	<!--LOGO-->
  	<img src="images/LogoSocialGamersGDL.jpg" alt="banner" style="margin-left:30px" />
  	<!--FECHAS-->
  	<br /><br />
    <div style="margin-left:30px;">TLAJOMULCO 2011<br />JUE7, VIE8 y SAB9 - ABRIL</div>
  	<br /><br />
    <!--MENÚ-->
    <ul>
		<li><a href="index.php">Inicio</a></li>
		<li><a href="inscripciones.php">Inscripciones</a></li>
		<li><a href="colaboradores.php">Colaboradores</a></li>
		<li><a href="agenda.php">Agenda</a></li>
		<li><a href="FAQS.php">FAQS</a></li>
		<li class="active"><a href="contacto.php">Contacto</a></li>
    </ul>
    <br /><br /><br />
	<!--FACEBOOK-->
    <div style="margin-left:30px;margin-top:170px;">
		<script src="http://connect.facebook.net/es_ES/all.js#xfbml=1"></script><fb:like-box href="http://www.facebook.com/pages/Social-Gamers-GDL/185175491526354" width="250" height="375" colorscheme="dark" show_faces="true" stream="false" header="true"></fb:like-box>
	</div>
</div>

<div class="right">

 <!--<img src="images/contact.gif" style="border: none; margin: 0;" alt="portfolio" />-->
  <br /><br /><br />
<div class="content">
<h1>Contactanos</h1>
<br />
<p>&iquest;Tienes alguna duda, sugerencia o algo que quieras contarnos?</p>
<br />
<p>Usa nuestro formulario de contacto aqu&iacute; abajo o env&iacute;anos un email a 

<a href="mailto:registro@socialgamersgdl.org?subject=Contacto Social Gamers GDL">registro@socialgamersgdl.org.</a> 

Te atenderemos lo m&aacute;s pronto posible.</p>
<br /><br />

<form name="contacto" action="send.php" method="post" id="contact" onsubmit="validar()">
	<label><b>Nombre completo</b></label><br /><br />
    <input type="text" name="nombre" value="" /><br /><br />
    <label><b>Universidad / Empresa</b></label><br /><br />
    <input type="text" name="escuela" value="" /><br /><br />
    <label><b>Email</b></label><br /><br />
    <input type="text" name="email" value="" /><br /><br />
    <label><b>Mensaje</b></label><br /><br />
    <textarea name="mensaje" cols="60" rows="8"></textarea><br /><br />
    <input type="submit" name="submit" value="Enviar&nbsp;"/>
</form>

    <!--FOOTER-->
	<div id="footer" style="margin-top:100px; width:500px">
		<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/2.5/mx/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/2.5/mx/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/InteractiveResource" property="dct:title" rel="dct:type">Social Gamers GDL</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://buulinc.com" property="cc:attributionName" rel="cc:attributionURL">Buul Social Technologies S.A. de C.V.</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/2.5/mx/">Creative Commons Attribution-NonCommercial-ShareAlike 2.5 Mexico License</a>.<br />Based on a work at <a xmlns:dct="http://purl.org/dc/terms/" href="http://buulgames.com.mx/socialgamersgdl/" rel="dct:source">buulgames.com.mx</a>.<br />Permissions beyond the scope of this license may be available at <a xmlns:cc="http://creativecommons.org/ns#" href="http://about.me/fernandosahagun" rel="cc:morePermissions">http://about.me/fernandosahagun</a>.
 <br /><br />
 		Agradecimientos especiales a <a href="http://twitter.com/pablasso">@pablasso</a>
 <br/>  <a href="http://www.templatesold.com/" target="_blank">Website Templates</a> by <a href="http://www.free-css-templates.com/" target=		"_blank">Free CSS Templates</a>
	</div>
    
</div>
</div>
</body>
</html>
<?php session_start();
$maps_key = "ABQIAAAA8v6MHbrRr3H8QAP047b0LhTl6kdZIddW1u7SnJ54lT1ZuSgq3xRAHU-xO8nioLGcQoxxy_U4EOAWXQ";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Social Gamers GDL</title>
<link rel="stylesheet" type="text/css" href="basic.css"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo $maps_key; ?>&sensor=false" type="text/javascript"></script>
<script type="text/javascript">

    function initialize() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(20.483477, -103.533289), 14);
		var point = new GLatLng(20.483477, -103.533289);
    	map.addOverlay(new GMarker(point));
        map.setUIToDefault();
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

<body onload="initialize()">

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
		<li class="active"><a href="index.php">Inicio</a></li>
		<li><a href="inscripciones.php">Inscripciones</a></li>
		<li ><a href="colaboradores.php">Colaboradores</a></li>
		<li><a href="agenda.php">Agenda</a></li>
		<li><a href="FAQS.php">FAQS</a></li>
		<li><a href="contacto.php">Contacto</a></li>
    </ul>
    <br /><br /><br />
	<!--FACEBOOK-->
    <div style="margin-left:30px;margin-top:170px;">
		<script src="http://connect.facebook.net/es_ES/all.js#xfbml=1"></script><fb:like-box href="http://www.facebook.com/pages/Social-Gamers-GDL/185175491526354" width="250" height="375" colorscheme="dark" show_faces="true" stream="false" header="true"></fb:like-box>
	</div>
</div>

<!--CONTENIDO-->

<div class="right">
<br /><br /><br />
<div class="content">
	<h1>Social Gamers GDL</h1>
	<br />
    	<p><h3>Congreso que promueve el desarrollo de Videojuegos y las Redes Sociales en Guadalajara, M&eacute;xico. Evento 7, 8 y 9 de Abril 2011.</h3></p>    
    <br />
		<p><h3>Talleres, Conferencias y Desarrollo de Videojuegos ¡¡¡</h3></p>
    <br />
<br />

<!--TWITTER-->
<div style="margin-left:20px">
   <script src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'search',
  search: 'SGGDL',
  interval: 6000,
  title: 'Congreso Social Gamers GDL',
  subject: '#SGGDL',
  width: 530,
  height: 200,
  theme: {
    shell: {
      background: '#1C7FC2',
      color: '#ffffff'
    },
    tweets: {
      background: '#ffffff',
      color: '#444444',
      links: '#1985b5'
    }
  },
  features: {
    scrollbar: false,
    loop: true,
    live: true,
    hashtags: true,
    timestamp: true,
    avatars: true,
    toptweets: true,
    behavior: 'default'
  }
}).render().start();
</script>
    </div>
    
    <!--MAPA-->
    <br />
    	<h4> Ubicación del evento: </h4>
    <br />
        <div style="margin-left:20px" style="width:100%; text-align:center;">
            <div id="map_canvas" style="width: 530px; height: 200px"></div>
            <p class="address">
            <br /> <h6>Km 4.7 carretera Tlajomulco - Tala, Sta Cruz de las Flores.</h6>
            </p>
        </div>
      	
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
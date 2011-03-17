<html>
	<head>
		<script type="text/javascript" src="/assets/js/jquery.js"></script>	
		<script type="text/javascript" src="/assets/js/cracks.js"></script>	
		<script type="text/javascript" src="/assets/js/superfish.js"></script>	
		<script type="text/javascript" src="/assets/js/supersubs.js"></script>	
		<script type="text/javascript" src="/assets/js/hoverIntent.js"></script>	
		<style type='text/css' media='all'>@import url('/assets/css/style.css');</style> 
		<style type='text/css' media='all'>@import url('/assets/css/ie.css');</style> 
		<style type='text/css' media='all'>@import url('/assets/css/ie7.css');</style> 
		<title>Social Gamers Guadalajara</title>
	</head>
	<body>
		<div class="wrapper">
			<div id="top" class="clearfix">
				<div id="logo" class="left"><a href="<?=base_url()?>"></a></div>
			</div>
			<?php $url = $this->uri->segment(2);?>
			<ul id="menu" class="clearfix">
				<li class="blue <?=($url == NULL) ? 'current-menu-item': null?>"><a href="<?=base_url()?>">Inicio</a></li>
				<li class="blue <?=($url == 'subscriptions')? 'current-menu-item': null?>"><a href="<?=base_url()?>pages/subscriptions">Inscripciones</a></li>
				<li class="blue <?=($url == 'collaborators')? 'current-menu-item': null?>"><a href="<?=base_url()?>pages/collaborators">Colaboradores</a></li>
				<li class="blue <?=($url == 'schedule')? 'current-menu-item': null?>"><a href="<?=base_url()?>pages/schedule">Agenda</a></li>
				<li class="blue <?=($url == 'faqs')? 'current-menu-item': null?>"><a href="<?=base_url()?>pages/faqs">FAQs</a></li>
				<li class="blue <?=($url == 'contact')? 'current-menu-item': null?>"><a href="<?=base_url()?>pages/contact">Contacto</a></li>
			</ul>
			<div class="wrapcontent clearfix">
				<div id="sidebar" class="fright" role="complementary">
					<div class="section">
						<ul>
						<li class="twitter"><a href="http://twitter.com/socialgamersgdl" title="Follow us in twitter!">Twitter</a></li>
						<li class="fans"><a href="http://www.facebook.com/pages/Social-Gamers-GDL/185175491526354" title="Become our fan in Facebook!">Facebook</a></li>
						</ul>
					</div>
			    </div><!-- End of Sidebar-->
				<div id="content" clas="fleft" role="main">
					<div class="wrappost">
								<div class="post">
									<div class="entry">
										<div class="clearfix wrapentry">
											<div class="fleft">
                                                <a href="<?=base_url().'pages/'.url_title($post->title)?>" title=""><img src="<?=base_url()?>assets/images/flashplayer_165x165.png" alt=""></a>
                    						</div>
											<div class="info fright clearfix ">
												<h1>
													<a href="<?=base_url().'pages/'.url_title($post->title)?>" rel="bookmark" title="Permanent Link to Pixelmator: Cool image editing for the rest of us"><?=$post->title?></a>
												</h1>						
											</div>
										</div>
										<div class="entry">
											<?=word_wrap(html_entity_decode($post->body,15));?>
										</div>
									</div>

								</div>
					</div>
				</div><!-- End of Left -->
			</div>
			<div id="footer"></div>			
		</div>
	</body>
</html>
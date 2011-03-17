<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * THIS SOFTWARE AND DOCUMENTATION IS PROVIDED "AS IS," AND COPYRIGHT
 * HOLDERS MAKE NO REPRESENTATIONS OR WARRANTIES, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO, WARRANTIES OF MERCHANTABILITY OR
 * FITNESS FOR ANY PARTICULAR PURPOSE OR THAT THE USE OF THE SOFTWARE
 * OR DOCUMENTATION WILL NOT INFRINGE ANY THIRD PARTY PATENTS,
 * COPYRIGHTS, TRADEMARKS OR OTHER RIGHTS.COPYRIGHT HOLDERS WILL NOT
 * BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL OR CONSEQUENTIAL
 * DAMAGES ARISING OUT OF ANY USE OF THE SOFTWARE OR DOCUMENTATION.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://gnu.org/licenses/>.
 * 
 * Description
 * 
 * @license		
 * @author		Ivan A. Zenteno
 * @link		http://www.infapen.com
 * @email		ivan.zenteno@infapen.com
 * 
 * @file		pages.php
 * @version		
 * @date		03/16/2011
 * 
 * Copyright (c) 2011
 */class Pages extends CI_Controller {
	 
	private $vars = array(); 
	 
	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(true);
	}
	
	public function index()
	{
		$this->page();
	}
	 
	public function subscriptions()
	{
		session_start();
		
		$this->vars['salt'] = "Bn+HfJRhzRDMT6MABn+HfJRhzRDMT6MuO1/rGFeBdJmSqLS9wuO1/rGFeBdYxOFOMjofEEUgYVg";
		$this->vars['maps_key'] = "ABQIAAAA8v6MHbrRr3H8QAP047b0LhTl6kdZIddW1u7SnJ54lT1ZuSgq3xRAHU-xO8nioLGcQoxxy_U4EOAWXQ";
		
		$params_facebook = array(
			'appId'  => '149409948455161',//'131929556820645',
			'secret' => 'd30bbef29c86265fd1d1b5266bf1e9c9',//'6e9f54033a3f3cb08da5038337d76473',
			'cookie' => true);

		$this->load->library('facebook', $params_facebook);

		$me = array();
		$params_registration = array_merge($_POST, $_GET, $me);
		$this->load->library('registration', $params_registration);		
		
		$session = $this->facebook->getSession();
		
		if ($session) {
			try {
				$uid = $this->facebook->getUser();
				$me = $this->facebook->api('/me');
			} catch (FacebookApiException $e) {
				error_log($e);
			}
		}
		
		$this->vars['facebook_logout_url'] = $this->facebook->getLogoutUrl();				
		$this->vars['f_api'] = $this->facebook->getAppId();
		$this->vars['registration_status'] = $this->registration->status;
		$this->vars['registration_message'] = $this->registration->message;
		$this->vars['verified_is_registered'] = $this->registration->verified_is_registered();
		$this->vars['verified_user'] = $this->registration->verified_user;

		$this->load->view('subscriptions_view', $this->vars);
	}
	
	public function redirection()
	{		
		/* Load and clear sessions */
		session_start();
		session_destroy();
		
		/* Start session and load library. */
		session_start();

		$params = array('consumer_key' => CONSUMER_KEY, 'consumer_secret' => CONSUMER_SECRET, 'oauth_token' => NULL, 'oauth_token_secret' => NULL);
		$this->load->library('twitteroauth',$params);
		 
		/* Get temporary credentials. */
		$request_token = $this->twitteroauth->getRequestToken(OAUTH_CALLBACK);
		
		/* Save temporary credentials to session. */
		$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
		
		/* If last connection failed don't display authorization link. */
		switch ($this->twitteroauth->http_code) {
		  case 200:
		    /* Build authorize URL and redirect user to Twitter. */
		    $url = $this->twitteroauth->getAuthorizeURL($token);
		    redirect($url); 
		    break;
		  default:
		    /* Show notification if something went wrong. */
		    echo '<p>&iexcl;Recaspitas! no se pudo hacer la conexi&oacute;n. De seguro la culpa la tiene ese tal <a href="http://twitter.com/pablasso">@pablasso</a></p>';
		    echo '<p><a href="/">Volver</a></p>';
		}
	}
	/*
	public function collaborators()
	{
		$this->load->view('pages_view');
	}
	
	public function schedule()
	{
		$this->load->view('pages_view');
	}
	
	public function faqs()
	{
		$this->load->view('pages_view');
	}

	public function contact()
	{
		$this->load->view('pages_view');
	}
	*/
	public function page()
	{
		$this->load->model('pages_model');
		$this->load->helper('inflector');
		$this->load->helper('text');
		$buff_title = $this->uri->segment(3);
		$title = ($buff_title) ? $buff_title : 'default';
		$this->vars['post'] = $this->pages_model->get($title)->row();
		$this->load->view('pages_view', $this->vars);
	}
	
	public function save_page()
	{
		$this->load->model('pages_model');
		$this->load->helper('text');
		if($_POST)
		{
			$this->pages_model->save();
		}
		else	
			$this->load->view('save_view');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
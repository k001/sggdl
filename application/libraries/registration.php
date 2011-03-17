<?php

class registration {
	
	private $params;
	private $salt = "Bn+HfJRhzRDMT6MABn+HfJRhzRDMT6MuO1/rGFeBdJmSqLS9wuO1/rGFeBdYxOFOMjofEEUgYVg";
	private $devhouse_edition = 1;
		
	public $status = "init";
	public $message = "";
	public $verified_user;
	public $users;
	
	var $ci;

	private $db_table = "users";

	function __construct($params) {
		$this->params = $params;
		$this->verified_user = array();
		$this->users = array();
		$this->init_registration();
	}
	
	private function init_registration() {
		$this->ci =& get_instance();
		$this->fetch_all_users();

		// twitter 1 for authorization app
		if (!empty($this->params['oauth_token']) && !empty($this->params['oauth_verifier'])) {
			$this->verify_twitter();
		}
		// twitter 2 for register form in save to our database
		else if( !empty($this->params['form_key']) && !empty($this->params['social_id']) &&	 $this->params['form_key'] == md5($this->salt.$this->params['social_id']) ) {
			if (!$this->verify_form())
				return;
			$this->register_user();
		}
		// facebook 1 for authorization app
		else if (!empty($this->params["first_name"]) && !empty($this->params["last_name"])) {
			$this->verified_user['name'] = $this->params['name'];
			$this->verified_user['social_web'] = "facebook";
			$this->verified_user['social_id'] = $this->params['id'];
			$this->verified_user['social_username'] = $this->params['first_name'];
			$this->verified_user['social_url'] = $this->params['link'];
			$this->verified_user['social_avatar_url'] = "https://graph.facebook.com/{$this->verified_user['social_id']}/picture";
			$this->status = "facebook_form";
		}
		// facebook 2 maybe to save for in out database
		else if (!empty($this->params['social_web']) && $this->params['social_web'] == "facebook" && !empty($this->params['form_key']) && $this->params['form_key'] == md5($this->salt.$this->params['social_id']) ) {
			if (!$this->verify_form())
				return;
			$this->register_user();
		}
	}
	
	private function verify_form() {
			if (empty($this->params['name']) && empty($this->params['last_name']) && empty($this->params['first_name']) && empty($this->params['email']) && empty($this->params['street']) && empty($this->params['num']) && empty($this->params['colony']) && empty($this->params['postal_code']) && empty($this->params['city'])) 
		{
			$this->verified_user['name'] = $this->params['name'];
			$this->verified_user['social_web'] = $this->params['social_web'];
			$this->verified_user['social_id'] = $this->params['social_id'];
			$this->verified_user['social_username'] = $this->params['social_username'];
			$this->verified_user['social_url'] = $this->params['social_url'];
			$this->verified_user['social_avatar_url'] = $this->params['social_avatar_url'];

			$this->status = "form_error";
			$this->message = "Los campos con * son necesarios para hacer tu registro correctamente.";
			return false;
		}
		
		return true;
	}
	
	private function verify_twitter() {
		require_once('twitteroauth.php');
		require_once('config.php');

		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

		unset($_SESSION['oauth_token']);
		unset($_SESSION['oauth_token_secret']);

		if (200 == $connection->http_code) {
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
			$content = $connection->get('account/verify_credentials');
			
			$this->verified_user['name'] = $content->name;
			$this->verified_user['social_web'] = "twitter";
			$this->verified_user['social_id'] = $content->id;
			$this->verified_user['social_username'] = $content->screen_name;
			$this->verified_user['social_url'] = "http://www.twitter.com/{$this->verified_user['social_username']}";
			$this->verified_user['social_avatar_url'] = $content->profile_image_url;
			$this->status = 'twitter_verified';
		}
		else {
			$this->status = "twitter_error";
		}
	}
	
	private function fetch_all_users() {
		$query = "SELECT * FROM `{$this->db_table}` WHERE devhouse_edition = {$this->devhouse_edition}";
		$result = $this->ci->db->query($query);

		$i = 0;
		foreach ($result->result_array() as $row) {
			$this->users[$i]['name'] = $row['name'];
			$this->users[$i]['activity'] = $row['activity'];
			$this->users[$i]['social_web'] = $row['social_web'];
			$this->users[$i]['social_id'] = $row['social_id'];
			$this->users[$i]['social_username'] = $row['social_username'];
			$this->users[$i]['social_url'] = $row['social_url'];
			$this->users[$i]['social_avatar_url'] = $row['social_avatar_url'];
			$i++;
		}
	}
	
	public function verified_is_registered() {
		if (empty($this->verified_user)) {
			return false;
		}
		
		foreach ($this->users as $value) {
			if ($value['social_web'] == $this->verified_user['social_web'] && $value['social_id'] == $this->verified_user['social_id']) {
				return true;
			}
		}
		
		return false;
	}
	
	private function register_user() {
		$this->ci->load->library('array');
		
		foreach ($this->users as $value) {
			if ($value['social_web'] == $this->params['social_web'] && $value['social_id'] == $this->params['social_id']) {
				$this->status = "user_already_registered";
				$this->message = "Ya est&aacute;s registrado con este usuario, si tienes alguna duda cont&aacute;ctanos.";
				return;
			}
		}

		$l = array();
		foreach($_POST as $key => $val):
			$l[$key] = mysql_escape_string($val); 
		endforeach;
			
		$data = elements(array('name', 'social_web', 'social_id', 'social_username', 'social_url', 'social_avatar_url', 'devhouse_edition', 'created', 'first_name', 'last_name', 'email', 'phone', 'cel_phone', 'street', 'num', 'colony', 'city', 'postal_code', 'procedencia', 'own_pc'), $l);
		$this->ci->db->insert($this->db_table, $data);	
		
		end($this->users);
		$last_key = key($this->users) + 1;
		
		$this->users[$last_key]['name'] = $this->params['name'];
		$this->users[$last_key]['social_web'] = $this->params['social_web'];
		$this->users[$last_key]['social_id'] = $this->params['social_id'];
		$this->users[$last_key]['social_username'] = $this->params['social_username'];
		$this->users[$last_key]['social_url'] = $this->params['social_url'];
		$this->users[$last_key]['social_avatar_url'] = $this->params['social_avatar_url'];
		
		$this->status = "user_registered";
		$this->message = "Gracias por confirmar tu asistencia, te hemos agregado en el listado al final de esta p&aacute;gina.";
	}
}

?>

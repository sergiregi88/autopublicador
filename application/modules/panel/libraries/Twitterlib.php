
<?php 
require_once( APPPATH . 'modules/panel/libraries/Twitter/autoloader.php' );


use Abraham\TwitterOAuth\TwitterOAuth;

class Twitterlib
{
	protected $twitter;
	public $ci;

	function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->load->config('twitter');

		$this->twitter = new TwitterOAuth($this->ci->config->item('twitter_consumer_token'), $this->ci->config->item('twitter_consumer_secret'));
	}
	public function auth($redirect_url)
	{
		 $request_token = $this->twitter->oauth('oauth/request_token', array('oauth_callback' => $redirect_url));
        	if($this->twitter->getLastHttpCode()==200)
        	{
        		$this->ci->session->set_userdata('request_token', $request_token['oauth_token']);
			$this->ci->session->set_userdata('request_token_secret', $request_token['oauth_token_secret']);
        		$url = $this->twitter->url('oauth/authorize',$request_token);
        		redirect($url);
        	}
        	else
        	{

        	}
        
	}
	public function checkresponse()
	{

		if($this->ci->input->get('oauth_token') && $this->ci->session->userdata('request_token') !== $this->ci->input->get('oauth_token'))
		{
			echo "req:".$this->ci->session->userdata('request_token')."<br>";
			echo "oath ".$this->ci->input->get('oauth_token');
			exit;
			//redirect(base_url('panel/twitter/connectar_twitter'));
		}
		else
		{
			$this->twitter->setOauthToken($this->ci->session->userdata('request_token'),$this->ci->session->userdata('request_token_secret'));
			$result=$this->twitter->oauth("oauth/access_token", array("oauth_verifier" => $this->ci->input->get('oauth_verifier')));
			if($this->twitter->getLastHttpCode()==200)
			{
				
				return $result;		
			}
			else
			{
				return false;
			}
		}

	}
	public function setAccessToken($access_token)
	{	
		if(is_array($access_token))
		$this->twitter->setOauthToken($access_token['oauth_token'],$access_token['oauth_token_secret']);
		elseif(is_object($access_token))
		$this->twitter->setOauthToken($access_token->oauth_token,$access_token->oauth_token_secret);
	}
	public function getUserdata()
	{
		 $res=$this->twitter->get('account/verify_credentials', array("include_entities" => false));
		 if($this->twitter->getLastHttpCode()==200)
		 {
		 	return $res;
		 }
		 else
		 {
		 	return false;
		 }
	}
	public function get($url,$params)
	{
		 $res=$this->twitter->get($url,array_merge($params));
		 if($this->twitter->getLastHttpCode()==200)
		 {
		 	return $res;
		 }
		 else
		 {
		 	return false;
		 }
	}
	public function post($url,$params)
	{
		 $res=$this->twitter->post($url,array_merge($params));
		 if($this->twitter->getLastHttpCode()==200)
		 {
		 	return $res;
		 }
		 else
		 {
		 	return false;
		 }
	}
	public function upload($params)
	{
		$result = $this->twitter->upload('media/upload', array('media' => $params['media']));
		if(200==$this->twitter->getLastHttpCode())
		{
			if(isset($result->media_id_string))
			{
				$parameters = array('status' => @$params['status'], 'media_ids' => $result->media_id_string);
				$result = $this->twitter->post('statuses/update', $parameters);	
				if($this->twitter->getLastHttpCode()==200)
				{
					return $result;
				}
				else
				{
					return $resultnbb;
				}
			}
			
			
			
		}	
		else
		{
		return false;
		}
        
	}
}

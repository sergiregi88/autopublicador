<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Herramientas extends CI_Controller {
		public function __construct()
	{
		parent::__construct();
		$this->load->model('social_users');		

		$this->load->model('social_user_accounts');

				// To load the CI benchmark and memory usage profiler - set 1==1.
		if (1==2)
		{
			$sections = array(
				'benchmarks' => TRUE, 'memory_usage' => TRUE,
				'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => FALSE,
				'uri_string' => FALSE, 'http_headers' => FALSE, 'session_data' => FALSE
			);
			$this->output->set_profiler_sections($sections);
			$this->output->enable_profiler(TRUE);
		}

		// Load required CI libraries and helpers.
		$this->load->database();
		$this->load->library('session');
 		$this->load->helper('url');
 		$this->load->helper('form');
 		$this->load->helper('language');
 		$this->load->library('form_validation');

  		// IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded!
 		// It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
		$this->auth = new stdClass;

		// Load 'standard' flexi auth library by default.
		$this->load->library('flexi_auth');

     	// Redirect users logged in via password (However, not 'Remember me' users, as they may wish to login properly).
		if ($this->flexi_auth->is_logged_in_via_password() && uri_string() != 'panel/logout')
		{
			// Preserve any flashdata messages so they are passed to the redirect page.
			if ($this->session->flashdata('message')) { $this->session->keep_flashdata('message'); }

			// Redirect logged in admins (For security, admin users should always sign in via Password rather than 'Remember me'.
			if ($this->flexi_auth->is_admin())
			{
				redirect(base_url().'admin');
			}
			else if( uri_string()=='facebook')
			{

				redirect(base_url().'panel/index');

			}
			
			$this->load->vars('section_app','panel');

			$guest=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_id(),array("guestPremium","uacc_group_fk"))->result();	
			if ($this->flexi_auth->is_privileged('acces user free'))
			{
				
				if($guest[0]->guestPremium=="1")
				$this->load->vars('privilege_user_app','prem');
				else
				$this->load->vars('privilege_user_app','free');
			
			}
			else if ($this->flexi_auth->is_privileged('acces user prem'))
			{
				$this->load->vars('privilege_user_app','prem');
			}
		}
		else
		{
			if($this->input->is_ajax_request())
			{
				echo json_encode(array('req_auth'=>1));
				//redirect_js(base_url().'panel');
				exit;
			}
			else
			redirect(base_url().'panel');

		}

		// Note: This is only included to create base urls for purposes of this demo only and are not necessarily considered as 'Best practice'.
		//$this->load->vars('base_url', base_url(). 'auth/');
		//$this->load->vars('includes_dir', 'http://localhost:8888/flexi_auth/includes/');
		//$this->load->vars('current_url', $this->uri->uri_to_assoc(1));

		// Define a global variable to store data that is then used by the end view page.
		$this->data = null;
		$this->data['username']=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_id(),array("upro_first_name"))->result();	
	}

	public function index()
	{
		$this->data['titlepage']="Herramientas";		
		$this->load->view('herramientas/index',$this->data);
	}
	public function checkSelected($str)
	{

		if (!isset($str['user']) && !isset($str['account']))

		{
			$this->form_validation->set_message('checkSelected', 'Debe seleccionar las cuentas donde publicar');
			return FALSE;
		}
		else 
		{
			return TRUE;
		}
	}
	public function limpiar_fotos_facebook($token,$accountid)
	{
		$this->load->library('Facebooklib','','fblib');
		$this->fblib->setSessionFromToken($token);
		  $photos_data = array();
	    $offset = 0;
	    $limit = 500;
	    $data=$this->fblib->api("/".$accountid."/photos/uploaded");
	    var_dump($data);
	    while(isset($data['paging']['next']))
	    {
	    		$next=parse_url($data['paging']['next']);
	    		$data=$this->fblib->api($next['path'].'?'.$next['query']);
	    		 $photos_data = array_merge($photos_data, $data["data"]);

	    }
	    var_dump($photos_data);

	}
	public function limpiar_links_facebook($users,$accounts)
	{

	}



	public function limpiador_facebook()
	{
			$this->form_validation->set_rules('type',"Tipo de limpieza","required");
			$this->form_validation->set_rules('ck_group_ap','Cuentas','callback_checkSelected');
			if($this->input->post())
			{
				if($this->form_validation->run()==TRUE)
				{
					$type_erase=$this->input->post('type');
					$cuentas=$this->input->post('ck_group_ap');
					$users=(isset($cuentas['user'])?$cuentas['user']:array());
					$accounts=(isset($cuentas['account'])?$cuentas['account']:array());
					 foreach ($users as $user) {
						$userRow=$this->social_users->getUserAppUsers(array('user_id'=>$user),1);		 	
						
						
					 }
					 foreach ($accounts as $account) {
					 	$accRow=$this->social_user_accounts->getUserAppAccounts(array('idaccount'=>$account),1);
					 	if($type_erase=='1')
							$this->limpiar_fotos_facebook($accRow[0]->access_token,$account);
						else if($type_erase=="2")
							$this->limpiar_links_facebook($accRow[0]->access_token,$account);
						else{
							$this->limpiar_links_facebook($accRow[0]->access_token,$account);
							$this->limpiar_fotos_facebook($accRow[0]->access_token,$account);
						}
					 }
					
					

				}
				else
				{
					  $errors = $this->form_validation->error_array();
                   echo json_encode(array('msg_errors'=>$errors));      

				}
				
				exit;
			}

			$pages=$this->social_user_accounts->getUserAppAccounts(array('type_account'=>'page','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['data']['event']=$this->social_user_accounts->getUserAppAccounts(array('type_account'=>'event','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['data']['group']=$this->social_user_accounts->getUserAppAccounts(array('type_account'=>'group','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['data']['page']=$pages;
			$this->data['data']['user']=$this->social_users->getUserAppUsers(array('social_network'=>'fb','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['titlepage']="Limpiador de facebook";

		$this->load->view('herramientas/limpiador_facebook',$this->data);
	}
	public function buscador_de_imagenes()
	{

	}
	public function unfollow_twitter()
	{

	}
	public function limpiador_twitter()
	{

	}
	public function extractor_tweets()
	{

	}

}

/* End of file herramientas.php */
/* Location: ./application/modules/panel/controllers/herramientas.php */
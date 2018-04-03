<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 function __construct(){
	 		parent::__construct();
 			$this->load->library('facebook');
			$this->load->library('session');
			$this->load->model('M_data','store');
 	 }

   public function facebook()
	 {
		 //--- get user facebook profile details ----//
		 $user = $this->facebook->request('get', '/me?fields=id, first_name, last_name, email, picture');
		 //--- insert or update user data ----//

 		 $data = $this->store->get_user_login($user['first_name']);

		 if(!empty($data)) {

	 			$data_session_array = array(
	 				'user_id'		=> $data->user_id,
	 				'full_name'		=> $data->first_name . $data->last_name,
	 				'user_email'		=> $data->email,
	 				'picture'		=> $data->name_file,
	 				'user_new'		=> 0
	 			);

 				$this->session->set_userdata($data_session_array);

 				redirect(base_url().'welcome/welcome');
				// * ---- end ----- * //
 		} else {
				$user_id = $this->store->get_max_user_id();
				$data_reg['oauth_provider'] = 'facebook';
				$data_reg['oauth_uid'] 		= $user['id'];
				$data_reg['first_name'] 			= $user['first_name'];
				$data_reg['last_name'] 		= $user['last_name'];
				$data_reg['email'] 			= @$user['email'];
				$data_reg['password'] 		= md5($user_id.'FB');
				$data_reg['password_hint'] 	= $user_id.'FB';
				$data_reg['validate'] 		= md5(@$user['email']);
				$data_reg['name_file'] 		= $user['picture']['data']['url'];
				$data_reg['date_created']	= date('Y-m-d');
				$data_reg['active'] 		= 1;
				$data_reg['user_id'] 			= $user_id;
				if($this->store->save_register($data_reg)) {
						/* ---- start create session login ---- */
						$query = $this->store->get_user_id($user_id);
						$userdata = $query;
						if (count($userdata) > 0){

								$data_session_array = array(
									'user_id'		=> $userdata->id,
									'full_name'		=> $userdata->first_name,
									'user_email'		=> $userdata->email,
									'picture'		=> $userdata->name_file,
									'user_new'		=> 1
								);
								$this->session->set_userdata($data_session_array);
						}
						/* ---- end create session login ---- */
				}
				redirect(base_url().'signup/welcome');
				//---- redirect ----//
	  	}
	 }
   function logout() {
	 		$data_session_array = array(
	 			'user_id'		=> '',
	 			'user_name'		=> '',
	 			'user_email'	=> '',
	 			'user_new'		=> ''
	 		);
	 		$this->session->set_userdata($data_session_array);
	 		redirect(base_url().'welcome');
 	 }
 }

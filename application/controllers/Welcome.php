<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
			$this->load->model('M_data','store');
 	 }
	 public function index()
	 {
		 	$data['title'] = 'started page';
			$data['authUrl'] = $this->facebook->login_url();
			$data['content'] = $this->load->view('front/welcome/index_v', $data, true);
			$this->load->view('front/layout/main_v', $data);
	 }
	 public function welcome()
	 {
			 $data['title'] = 'welcome';
			 $data['authUrl'] = $this->facebook->login_url();
			 $data['content'] = $this->load->view('front/login/logined_v', $data, true);
			 $this->load->view('front/layout/main_v', $data);
	 }
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class test extends CI_Controller {

	public function index()
	{
        $data['temp'] = $this->model_template->gen();
	}
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
<?php

class migration extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		//$this->load->model("Migration_model");
	}


	public function latest()
	{
	
		$this->load->library('migration');

		if ($this->migration->latest() === FALSE)
		{
			show_error($this->migration->error_string());
		} else {
			//$this->Migration_model->migrate();
			echo "Success";
		}
	}
}
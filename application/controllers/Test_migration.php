<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Test_migration extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('migration');
    }
    public function index()
    {
        if (!$this->migration->current()) {
            show_error($this->migration->error_string());
        } else {
            echo 'Migration worked!';
        }
    }
}
        
    /* End of file  Test_migration.php */

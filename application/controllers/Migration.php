<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class migration extends CI_Controller 
{
	function __construct()
	{	
		parent::__construct();
	}
	
	public function index()
	{
        $this->load->library('migration');

        try {
            // Check if there are any pending migrations and apply the latest one
            if (!$this->migration->latest()) {
                // If an error occurs during migration, throw an exception
                throw new Exception($this->migration->error_string());
            }

            // Get the latest migration version from the migration table
            $latest_migration = $this->db->select('version')
                                        ->from('migrations')
                                        ->order_by('version', 'desc')
                                        ->limit(1)
                                        ->get()
                                        ->row();

            // Display the latest migration version number
            if ($latest_migration) {
                echo "Migration successful! <br />Latest migration version: " . $latest_migration->version;
            } else {
                echo "No migrations found.";
            }
        } catch (Exception $e) {
            // Catch any exception and show the error message
            show_error("Migration failed: " . $e->getMessage());
        }
    }
}
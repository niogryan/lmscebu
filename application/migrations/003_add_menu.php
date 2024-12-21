<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_menu extends CI_Migration {

    public function up()
    {
        $fields = array(
            'pathname' => array(
                'name' => 'pathname',
                'type' => 'VARCHAR',
                'constraint' => '50',
            ),
        );
        $this->dbforge->modify_column('tbl_menus', $fields);
        
        //check if isstrictmachineaccess is already in the table if not add it
        if (!$this->db->field_exists('isstrictmachineaccess', 'tbl_user_accounts')) {
            $fields = array(
                'isstrictmachineaccess' => array(
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 0,
                    'after' => 'branch'
                ),
            );
            $this->dbforge->add_column('tbl_user_accounts', $fields);
        }
    }

    public function down()
    {
       
    }
}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_user_cookies extends CI_Migration {

    public function up()
    {
        // Define the user_cookies table structure
        $this->dbforge->add_field([
            'usercookieid' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'cookie_value' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
                'type' => 'varchar',
                'constraint' => 20,
                'default' => 0,
            ],
            'user_agent' => [
                'type' => 'TEXT',
            ],
            'ip_address' => [
                'type' => 'varchar',
                'constraint' => 50,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'expires_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
        ]);

        // Set the primary key
        $this->dbforge->add_key('usercookieid', TRUE);

        // Create the table
        $this->dbforge->create_table('tbl_useraccounts_cookies', TRUE);
    }

    public function down()
    {
       
    }
}
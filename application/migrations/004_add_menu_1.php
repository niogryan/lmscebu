<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_menu_1 extends CI_Migration {

    public function up(){
        // Check if the menu item already exists
        $this->db->where('pathname', 'toolsusermachinevalidation');
        $query = $this->db->get('tbl_menus');

        if ($query->num_rows() == 0) {
            $this->db->insert('tbl_menus', array(
            'category' => 'Tools',
            'pathname' => 'toolsusermachinevalidation',
            'menuname' => 'Users Machine Validation',
            'isenable' => 'T',
            'orderby' => 77,
            'hasadd' => 'F',
            'hasedit' => 'T',
            'hasdelete' => 'F',
            ));
        }
    }

    public function down()
    {
       
    }
}
<?php
    namespace App\Models;
    use CodeIgniter\Model;

    class Login_model extends Model {
        public function __construct() {
            parent:: __construct();

            $this->load->database();
        }

        public function login($email, $password) {
            $query = $this->db->get_where('users', ['emp_email' => $email, 'password' => md5($password)]);
            return $query->row();
        }
    }
?>
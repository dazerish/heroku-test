<?php 

class Login extends BaseController{
    public function __construct() {
        parent::__construct();

        $this->load->helper(['form', 'url']);
        $this->load->library('session');
        // $this->session = new Session();
    }
        
    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect('Login');
        }

        $data['title'] = 'Calibr8 - Login';
        echo view('include/header', $data);
        echo view('login_view');
        echo view('include/footer');
    }

    public function login_validate() {
        $submit = $this->input->post('login');

        if(isset($submit)) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $this->load->model('Login_model');
            $account = $this->Login_model->login($email, $password);

            if(isset($account)) {
                if($account->emp_role == 'administrator') {
                    $sess_data = array(
                        'id' => $account->id,
                        'role' => $account->emp_role,
                        'logged_in' => TRUE
                    );

                    $this->session->set_userdata($sess_data);
                    redirect('Admin');
                }

                // FOR EXECUTIVE
                // if($account->emp_role == 'executive') {
                //     $sess_data = array(
                //         'id' => $account->id,
                //         'role' => $account->emp_role,
                //         'logged_in' => TRUE
                //     );

                //     $this->session->set_userdata($sess_data);
                //     redirect('');
                // }

                if($account->emp_role == 'employee') {
                    $sess_data = array(
                        'id' => $account->id,
                        'role' => $account->emp_role,
                        'logged_in' => TRUE
                    );

                    $this->session->set_userdata($sess_data);
                    redirect('Employee');
                }
            }

            $error = 'Invalid username or password';
            $this->session->set_flashdata('error', $error);
            redirect('Login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('Login');
    }

}


?>
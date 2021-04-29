<?php
// ini_set('max_execution_time', 1800);
// use
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;
use Mpdf\Tag\Pre;
use Symfony\Component\Process\Exception\ProcessFailedException as SymfonyProcessFailedException;
use Symfony\Component\Process\Exception\ProcessFailedException as SymfonyComponentProcessFailedException;

class Repos extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        //phpinfo();
        $this->load->model('project_model');
        $this->load->model('users_model');
    }

    function index()
    {
        return redirect('repos/repos/create');
    }
    function create()
    {

        $this->load->view('repos/create_repos');
    }
    function listProject()
    {
        //$id_account=$this->session->userdata('user_id');
        $data['project'] = $this->project_model->node_air();
        $this->load->view('my_project', $data);
    }

    function statistic()
    {
        //$id_account=$this->session->userdata('user_id');
        $data['project'] = $this->project_model->statistik();
        $this->load->view('statistic', $data);
    }


    function table()
    {
        //$id_account=$this->session->userdata('user_id');
        $data['project'] = $this->project_model->statistik();
        $this->load->view('table', $data);
    }


    public function save()
    {
        $reposname = $this->input->post('project_name');
        $nama_project = $this->input->post('nama_project');
        $cek = $this->db->query("SELECT * FROM project where nama_project='" . $reposname . "'")->num_rows();
        $database = $this->input->post('database');
        $deskripsi = $this->input->post('deskripsi');
        $hostname = config_item('url_visual_svn') . $reposname;

        if ($cek <= 0) {
            system(' chp.exe php cli.php repos/repos/all_process ' . $reposname . ' ' . $database . ' ' . $deskripsi . ' ' . $nama_project);
            $this->session->set_flashdata('message', '<div class="alert alert-success">
        <h4>Berhasil </h4>
        <p>Alamat svn anda adalah "' . $hostname . '"</p>
          </div>');
            $id_account = $this->session->userdata('user_id');
            $this->project_model->save($nama_project,$id_account, $database, $deskripsi, $hostname);
            redirect('repos/repos/listProject');
        } else {
            $this->session->set_flashdata(
                'message',
                'nama project tidak boleh sama'
            );
            redirect('repos/repos/');
        }
    }

    //This function to recover our all process that create the repository till commit it to the repository
    //This function will called in save() function by cli.php function
    public function all_process($reposname, $database, $deskripsi, $nama_project)
    {

        $hostname = config_item('url_visual_svn') . $reposname;
        $this->create_repos($reposname); //create repository
        $this->create_item($reposname);
        $this->check_out($hostname,$reposname); //checkout repo ke htdocs
        $this->copy($reposname); //copy template ke trunk\
        $this->add($reposname);

        $this->commit($reposname); //commit yang udah di copy


        $status_sukses = 1;
        $message = 'nothing';
        $status = $status_sukses;
        $this->project_model->update_status($status, $message, $nama_project);


        if (strlen($deskripsi) > 256) {
            $data = $this->session->set_flashdata('msg', 'kelebihan');
            redirect('repos/repos', $data);
        }
    }

    //This function to create repository svn will be share to the oteher developer team
    public function create_repos($reposname)
    {
        $powerShell = 'C:/Windows/System32/WindowsPowerShell/v1.0/powershell.exe';
        $process = new Process('cd D:\xampp\repositories && svnadmin create ' . $reposname);
        //system('xcopy C:\xampp\htdocs\i-template\auth_svn C:\Repositories');

        $process->setTimeout(NULL);
        $process->run();
        $filesystem = new Filesystem();
        $filesystem->mirror('D:/xampp/htdocs/i-template/auth_svn', 'D:/xampp/repositories/' . $reposname . '/conf');

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            $message = $process->getErrorOutput();
            $status_error = 2;
            $status = $status_error;
            $this->project_model->update_status($status, $message, $reposname);
        }
    }

    public function create_repo($reposname)
    {
        $powerShell = 'C:/Windows/System32/WindowsPowerShell/v1.0/powershell.exe';
        $process = new Process([$powerShell, 'New-SvnRepository', $reposname]);

        $process->setTimeout(NULL);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            $message = $process->getErrorOutput();
            $message = $process->getErrorOutput();
            $status_error = 2;
            $status = $status_error;
            $this->project_model->update_status($status, $message, $reposname);
        } else {
            echo 'berhasil';
        }
    }


    //This function to create item,in case we need only trunk 
    function create_item($reposname)
    {
        $filesystem = new Filesystem();
        system('cd D:/xampp/repositories/' . $reposname . ' && REN db _db && mkdir db');
        $filesystem->mirror('D:/xampp/htdocs/i-template/db143', 'D:/xampp/repositories/' . $reposname . '/db');
    }

    //this funtion to check out revision of repository to our working directory
    function check_out($reposname)
    {
        $hostname = config_item('url_visual_svn') . $reposname . '/trunk';
        $process = new Process('svn co --username ' . config_item('user_svn') . ' --password ' . config_item('pass_svn') . ' ' . $hostname . ' ' . config_item('path_copy') . $reposname);
        $process->setTimeout(NULL);
        $process->run();
        if (!$process->isSuccessful()) {
            $message = $process->getErrorOutput();
            $status_error = 2;
            $status = $status_error;
            $this->project_model->update_status($status, $message, $reposname);
        }

        echo $process->getOutput();
    }


    //This function to copy template to folder that we create before
    function copy($reposname)
    {
        $filesystem = new Filesystem();
        $filesystem->mirror('D:/xampp/htdocs/i-template/template/logs', config_item('path_copy') . $reposname);
    }
    //This function to add the template that we copy before to our svn repository
    function add($reposname)
    {
        $process = new Process('cd ' . config_item('path_copy') . $reposname . ' && svn add *');
        $process->setTimeout(NULL);
        $process->run();
        if (!$process->isSuccessful()) {
            $message = $process->getErrorOutput();
            $status_error = 2;
            $status = $status_error;
            $this->project_model->update_status($status, $message, $reposname);
        }

        echo $process->getOutput();
    }

    //This function to commit our template to the repository
    function commit($reposname)
    {
        // system('cd ' . config_item('path_copy')   . $nama_project .' && chp.exe svn commit -m"n"');
        $process = new Process('cd ' . config_item('path_copy') . $reposname . ' && svn commit -m"n"');
        $process->setTimeout(NULL);
        $process->run();
        if (!$process->isSuccessful()) {
            $message = $process->getErrorOutput();
            $status_error = 2;
            $status = $status_error;
            $this->project_model->update_status($status, $message, $reposname);
        }
        echo $process->getOutput();
    }


    function delete()
    {
        $id = $this->uri->segment(4);
        $this->project_model->delete($id);
        redirect('repos/repos/listProject');
    }

    function get_edit()
    {
        $id = $this->uri->segment(3);
        $result = $this->project_model->get_id($id);
        if ($result->num_rows() > 0) {
            $i = $result->row_array();
            $data = array(
                'id'    => $i['id'],
                'nama_project' => $i['nama_project'],
                'deskripsi'  => $i['deskripsi'],
                'database'     => $i['database'],
            );
            $data['id'] = $this->project_model->get_project();
            $this->load->view('my_project', $data);
        } else {
            echo "Data Was Not Found";
        }
    }



    function update_my_project()
    {


        $nama_project = $this->input->post('nama_project');
        $deskripsi = $this->input->post('deskripsi');
        $database = $this->input->post('database');
        //$id=$this->input->post('id');
        $id = $this->uri->segment(4);
        $this->project_model->update_my_project($nama_project, $database, $deskripsi, $id);
        echo $this->session->set_flashdata('msg', 'info');
        redirect('repos/repos/listProject');
    }




    public function cari()
    {
        $keyword = $this->input->get('keyword');
        $data['project'] = $this->project_model->cari($keyword);
        $this->load->view('table', $data);
    }

    public function register()
    {
        $data = new stdClass();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]', array('is_unique' => 'This email already exists in the database. <a href="forgot-pass" class="btn btn-xs btn-primary">have you forgot your password</a> ?'));
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
        if ($this->form_validation->run() == false) {
            $this->_view_layout("user/register/register", $data);
        } else {
            $username = $this->input->post('username');
            $email    = $this->input->post('email');
            $password = $this->input->post('password');
            if ($user_id = $this->users_model->create_user($username, $email, $password)) {
                $this->_send_confirmation_msg($user_id, $email);
                $this->_view_layout("user/register/register_success", $data);
            } else {
                $data->errors[] = 'There was a problem creating your new account. Please try again.';
                $this->_view_layout("user/register/register", $data);
            }
        }
    }

    function panduan()
    {
        $this->load->view('panduan');
    }
}

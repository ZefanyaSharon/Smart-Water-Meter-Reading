<?php
use Aura\Dispatcher\Exception;

defined('BASEPATH') or exit('No direct script access allowed');

class Migrate extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->input->is_cli_request()) {
            show_error('You don\'t have permission for tis action');
            return;
        }
        $this->load->library('migration');
    }
    public function version($version)
    {
        $migration = $this->migration->version($version);
        if (!$migration) {
            echo $this->migration->error_string();
        } else {
            echo 'Migration doe' . PHP_EOL;
        }
    }
    public function generate($name = false)
    {
        if (!$name) {
            echo "please define migration name" . PHP_EOL;
            return;
        }
        if (!preg_match('/^[a-z_]+$/i', $name)) {
            if (strlen($name) < 4) {
                echo "Migration must be at least 4 charracters long" . PHP_EOL;
                return;
            }
            echo "wrong migration name,allowed charracters: a-z and _\n example:first_migration" . PHP_EOL;
            return;
        }
        $filename = date('Y-m-d-H.i.s') . '_' . $name . '.php';
        try{
            $folderpath = APPPATH . 'migrations';
            if(!is_dir($folderpath)){
                try{
                    mkdir($folderpath);
                }
                catch(Exception $e){
                    echo "Error:\n" . $e->getMessage() . PHP_EOL;
                }
            }
            $filepath=APPPATH . 'migrations/' .$filename;
            if(file_exists($filepath)){
                echo "File allready exists:\n" . $filepath . PHP_EOL;
                return;
            }
            $data['className']=ucfirst($name);
            $template=$this->load->view('cli/migrations/migration_class_template', $data, TRUE);
            //create file
            try{
                $file = fopen($filepath,"w");
                $content = "<?php\n" . $template;
                fwrite($file,$content);
                fclose($file);
            }catch(Exception $e){
                echo "Error:\n" . $e->getMessage() . PHP_EOL;
            }
            echo "Migration created succesfully!\nLocation: " . $filepath . PHP_EOL;

        }catch(Exception $e){
            echo "Can't create migration file !\nError: " . $e->getMessage() . PHP_EOL;
        }
        }
    }
        
    /* End of file  Migrate.php */

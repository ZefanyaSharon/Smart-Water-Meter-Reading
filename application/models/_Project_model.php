<?php
class Project_model extends CI_Model
{
    function save($nama_project, $database, $deskripsi, $hostname,$id_account)
    {
        $data = array(
            'nama_project' => $nama_project,
            'deskripsi' => $deskripsi,
            'link_svn' => $hostname,
            'id_user'=>$id_account,
            'database' => $database
        );
        $this->db->insert('project', $data);
    }
    function get_project()
    {
        $this->load->library('pagination'); // Load librari paginationnya

        $query = "SELECT * FROM project";
        $config['base_url'] = base_url('repos/repos/listProject');
        $config['total_rows']=$this->db->query($query)->num_rows();
        $config['per_page'] = 5;
		$config['uri_segment'] = 4;
        $config['num_links'] = 3;


        $config['full_tag_open']   = '<center><ul class="pagination pagination-sm m-t-xs m-b-xs">';
        $config['full_tag_close']  = '</ul></center>';
        
        $config['first_link']      = 'First'; 
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';
        
        $config['last_link']       = 'Last'; 
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
        
        $config['next_link']       = '&nbsp;<i class="glyphicon glyphicon-menu-right"></i>&nbsp;'; 
        $config['next_tag_open']   = '<li>';
        $config['next_tag_close']  = '</li>';
        
        $config['prev_link']       = '&nbsp;<i class="glyphicon glyphicon-menu-left"></i>&nbsp;'; 
        $config['prev_tag_open']   = '<li>';
        $config['prev_tag_close']  = '</li>';
        
        $config['cur_tag_open']    = '<li class="active"><a href="#">';
        $config['cur_tag_close']   = '</a></li>';
         
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = '</li>';
        $this->pagination->initialize($config);


        $page = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) : 0;
        $query .= " LIMIT ".$page.", ".$config['per_page'];
        $data['limit'] = $config['per_page'];
		$data['total_rows'] = $config['total_rows'];
		$data['pagination'] = $this->pagination->create_links(); // Generate link pagination nya sesuai config diatas
		$data['project'] = $this->db->query($query)->result();


        return $data;
    }


    function delete($id)
    {
        $result = $this->db->where('id', $id);
        $result = $this->db->delete('project');
        return $result;
    }

    //UPDATE PENGGUNA //
	
	function update_my_project($nama_project,$database,$deskripsi, $id){
        
		// $hsl=$this->db->query("UPDATE project set nama_project='$nama_project',database='$database',deskripsi='$deskripsi' where id='$id'");
        // return $hsl;
        
        $data = array(
            'nama_project' => $nama_project,
            'database' => $database,
            'deskripsi' => $deskripsi

          );
          $this->db->where('id', $id);
          $this->db->update('project', $data);
	}

	


    function get_id($id_account){
        $this->load->library('pagination'); // Load librari paginationnya

        $query = "SELECT * FROM project";
        $config['base_url'] = base_url('');
        $config['total_rows']=$this->db->query($query)->num_rows();
        $config['per_page'] = 5;
		$config['uri_segment'] = 4;
        $config['num_links'] = 3;


        $config['full_tag_open']   = '<ul class="pagination pagination-sm m-t-xs m-b-xs">';
        $config['full_tag_close']  = '</ul>';
        
        $config['first_link']      = 'First'; 
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';
        
        $config['last_link']       = 'Last'; 
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
        
        $config['next_link']       = '&nbsp;<i class="glyphicon glyphicon-menu-right"></i>&nbsp;'; 
        $config['next_tag_open']   = '<li>';
        $config['next_tag_close']  = '</li>';
        
        $config['prev_link']       = '&nbsp;<i class="glyphicon glyphicon-menu-left"></i>&nbsp;'; 
        $config['prev_tag_open']   = '<li>';
        $config['prev_tag_close']  = '</li>';
        
        $config['cur_tag_open']    = '<li class="active"><a href="#">';
        $config['cur_tag_close']   = '</a></li>';
         
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = '</li>';
        $this->pagination->initialize($config);


        //$page = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) : 0;
        //$query .= " LIMIT ".$page.", ".$config['per_page'];
        // $data['limit'] = $config['per_page'];
		// $data['total_rows'] = $config['total_rows'];
		// $data['pagination'] = $this->pagination->create_links(); // Generate link pagination nya sesuai config diatas
        $data['project'] = $this->db->query($query);
        $data['project'] = $this->db->like('id_user', $id_account);
        $data['project'] = $this->db->get('project')->result();

        // var_dump($data['project']);
        // die();

        return $data;
    }
    function cari($keyword)
    {
        $this->load->library('pagination'); // Load librari paginationnya

        $query = "SELECT * FROM project";
        $config['base_url'] = base_url('');
        $config['total_rows']=$this->db->query($query)->num_rows();
        $config['per_page'] = 5;
		$config['uri_segment'] = 4;
        $config['num_links'] = 3;


        $config['full_tag_open']   = '<ul class="pagination pagination-sm m-t-xs m-b-xs">';
        $config['full_tag_close']  = '</ul>';
        
        $config['first_link']      = 'First'; 
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';
        
        $config['last_link']       = 'Last'; 
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
        
        $config['next_link']       = '&nbsp;<i class="glyphicon glyphicon-menu-right"></i>&nbsp;'; 
        $config['next_tag_open']   = '<li>';
        $config['next_tag_close']  = '</li>';
        
        $config['prev_link']       = '&nbsp;<i class="glyphicon glyphicon-menu-left"></i>&nbsp;'; 
        $config['prev_tag_open']   = '<li>';
        $config['prev_tag_close']  = '</li>';
        
        $config['cur_tag_open']    = '<li class="active"><a href="#">';
        $config['cur_tag_close']   = '</a></li>';
         
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = '</li>';
        $this->pagination->initialize($config);


        //$page = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) : 0;
        //$query .= " LIMIT ".$page.", ".$config['per_page'];
        // $data['limit'] = $config['per_page'];
		// $data['total_rows'] = $config['total_rows'];
		// $data['pagination'] = $this->pagination->create_links(); // Generate link pagination nya sesuai config diatas
        $data['project'] = $this->db->query($query);
        $data['project'] = $this->db->like('nama_project', $keyword);
        $data['project'] = $this->db->get('project')->result();

        // var_dump($data['project']);
        // die();

        return $data;






        // $this->db->select('*');
        // $this->db->from('project');
        // $this->db->like('nama_project', $keyword);

        // $result = $this->db->get()->result;
        //var_dump($result);
        //die();
        
        
        
        // return (array)$result;




    }
}

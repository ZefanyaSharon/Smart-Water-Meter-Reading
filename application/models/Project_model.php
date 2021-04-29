<?php

use Dotenv\Regex\Result;

class Project_model extends CI_Model
{
    function save($nama_project,$id_account, $database, $deskripsi, $hostname)
    {
        $data = array(
            'id' => guid(),
            'id_user'=>$id_account,
            'nama_project' => $nama_project,
            'deskripsi' => $deskripsi,
            'link_svn' => $hostname,
            'database' => $database
        );
        $this->db->insert('project', $data);
    }
    function get_project()
    {
        $this->load->library('pagination'); // Load librari paginationnya

        $query = "SELECT * FROM project";
        $config['base_url'] = base_url('repos/repos/listProject');
        $config['total_rows'] = $this->db->query($query)->num_rows();
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
        $query .= " LIMIT " . $page . ", " . $config['per_page'];
        $data['limit'] = $config['per_page'];
        $data['total_rows'] = $config['total_rows'];
        $data['pagination'] = $this->pagination->create_links(); // Generate link pagination nya sesuai config diatas
        $data['project'] = $this->db->query($query)->result();


        return $data;
    }

    function node_air(){
        $query = "SELECT * FROM node_air ORDER BY ID DESC LIMIT 1";
        $data['project'] = $this->db->query($query)->result();
        return $data;
    }

    function statistik(){
        $query = "SELECT * FROM node_air";
        $data['project'] = $this->db->query($query)->result();
        return $data;
    }


    function delete($id)
    {
        $result = $this->db->where('id', $id);
        $result = $this->db->delete('project');
        return $result;
    }


    function update_status($status, $message, $nama_project)
    {
        $data = array(
            'is_success' => $status,
            'error_message' => $message
        );
        $result = $this->db->where('nama_project', $nama_project);
        $result = $this->db->update('project', $data);
        return $result;
    }
    function update_my_project($nama_project, $database, $deskripsi, $id)
    {


        $data = array(
            'nama_project' => $nama_project,
            'database' => $database,
            'deskripsi' => $deskripsi

        );
        $this->db->where('id', $id);
        $this->db->update('project', $data);
    }

    function get_id($id_account)
    {
        $this->load->library('pagination'); // Load librari paginationnya

        $query = "SELECT * FROM project";
        $config['base_url'] = base_url('');
        $config['total_rows'] = $this->db->query($query)->num_rows();
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

        $data['project'] = $this->db->query($query);
        $data['project'] = $this->db->like('id_user', $id_account);
        $data['project'] = $this->db->get('project')->result();


        return $data;
    }
    function cari($keyword)
    {
        $this->load->library('pagination'); // Load librari paginationnya

        $query = "SELECT * FROM node_air";
        $config['base_url'] = base_url('');
        $config['total_rows'] = $this->db->query($query)->num_rows();
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
        $data['project'] = $this->db->query($query);
        $data['project'] = $this->db->like('Date', $keyword);
        $data['project'] = $this->db->get('node_air')->result();


        return $data;
    }
}

<?php defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model
{

    private $table = "products";

    public function rules()
    {
        return [
            [
                'field' => 'nama',
                'label' => 'Nama',
                'rules' => 'trim|required'
            ],

            [
                'field' => 'warna',
                'label' => 'Warna',
                'rules' => 'trim|required'
            ],

            [
                'field' => 'asal',
                'label' => 'Asal',
                'rules' => 'trim|required'
            ]
        ];
    }

    public function get()
    {
        return $this->db->get($this->table)->result();
    }


    public function get_join()
    {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->join('category', 'category.cat_id = products.cat_id');
        $this->db->join('akl', 'akl.akl_id = products.akl_id');
        $query = $this->db->get()->result();
        return $query;
    }

    public function edit($id)
    {
        return $this->db->get_where($this->table, ["id" => $id])->row();
    }

    public function store()
    {
        $post = $this->input->post();
        $data = [
            'nama'  => $post['nama'],
            'warna' => $post['warna'],
            'asal'  => $post['asal'],
        ];
        return $this->db->insert($this->table, $data);
    }

    public function update($id)
    {
        $post = $this->input->post();
        $data = [
            'nama'  => $post['nama'],
            'warna' => $post['warna'],
            'asal'  => $post['asal'],
        ];
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function destroy($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}

class Datatables extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Datatables');
    }

    public function index()
    {
        $this->load->view('home');
    }

    public function onetable()
    {
        $this->load->view('onetable');
    }

    public function tablewhere()
    {
        $this->load->view('tablewhere');
    }

    public function tablequery()
    {
        $this->load->view('tablequery');
    }

    function view_data()
    {
        $tables = "artikel";
        $search = array('judul', 'kategori', 'penulis', 'tgl_posting');
        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables($tables, $search, $isWhere);
    }

    function view_data_where()
    {
        $tables = "artikel";
        $search = array('judul', 'kategori', 'penulis', 'tgl_posting');
        $where  = array('kategori' => 'php');
        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_where($tables, $search, $where, $isWhere);
    }

    function view_data_query()
    {
        $query  = "SELECT kategori.nama_kategori AS nama_kategori, subkat.* FROM subkat 
                       JOIN kategori ON subkat.id_kategori = kategori.id_kategori";
        $search = array('nama_kategori', 'subkat', 'tgl_add');
        $where  = null;
        // $where  = array('nama_kategori' => 'Tutorial');

        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }
}

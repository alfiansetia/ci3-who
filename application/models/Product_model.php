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
        $this->db->join('category', 'category.cat_id = products.cat_id', 'left');
        $this->db->join('akl', 'akl.akl_id = products.akl_id', 'left');
        $query = $this->db->get()->result();
        return $query;
    }

    public function edit($id)
    {
        return $this->db->get_where($this->table, ["prod_id" => $id])->row();
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
        return $this->db->update($this->table, $data, ['prod_id' => $id]);
    }

    public function destroy($id)
    {
        return $this->db->delete($this->table, ['prod_id' => $id]);
    }

    
    public function store_import($param)
    {
        $data = [
            'prod_code'  => $param['prod_code'],
            'prod_desc' => $param['prod_desc'],
            'cat_id'    => $param['cat_id'],
            'akl_id'    => $param['akl_id'],
        ];
        return $this->db->insert($this->table, $data);
    }
}


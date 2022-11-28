<?php defined('BASEPATH') or exit('No direct script access allowed');

class Akl_model extends CI_Model
{

    private $table = "akl";

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

    public function edit($id)
    {
        return $this->db->get_where($this->table, ["akl_id" => $id])->row();
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
        return $this->db->update($this->table, $data, ['akl_id' => $id]);
    }

    public function destroy($id)
    {
        return $this->db->delete($this->table, ['akl_id' => $id]);
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


<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cat_model extends CI_Model
{

    private $table = "category";

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

    public function get_by_name($name)
    {
        return $this->db->get_where($this->table, ["cat_name" => $name])->row();
    }

    public function edit($id)
    {
        return $this->db->get_where($this->table, ["cat_id" => $id])->row();
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

    public function store_import($param)
    {
        $data = [
            'cat_name'  => $param['cat_name'],
            'cat_desc'  => $param['cat_desc'],
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
        return $this->db->update($this->table, $data, ['cat_id' => $id]);
    }

    public function update_import($id, $param)
    {
        $data = [
            'cat_name'  => $param['cat_name'],
            'cat_desc'  => $param['cat_desc'],
        ];
        return $this->db->update($this->table, $data, ['cat_id' => $id]);
    }

    public function destroy($id)
    {
        return $this->db->delete($this->table, ['cat_id' => $id]);
    }
}

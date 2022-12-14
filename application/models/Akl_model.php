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

    public function get_by_name($name)
    {
        return $this->db->get_where($this->table, ["akl_name" => $name])->row();
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

    public function store_import($param)
    {
        $data = [
            'akl_name'  => $param['akl_name'],
            'akl_start' => $param['akl_start'],
            'akl_end'   => $param['akl_end'],
            'akl_file'  => $param['akl_file'],
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

    public function update_import($id, $param)
    {
        $data = [
            'akl_name'  => $param['akl_name'],
            'akl_start' => $param['akl_start'],
            'akl_end'   => $param['akl_end'],
            'akl_desc'  => $param['akl_desc'],
            'akl_file'  => $param['akl_file'],
        ];
        return $this->db->update($this->table, $data, ['akl_id' => $id]);
    }

    public function destroy($id)
    {
        return $this->db->delete($this->table, ['akl_id' => $id]);
    }
}

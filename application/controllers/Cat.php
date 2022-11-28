<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Cat_model");
    }

    public function index()
    {
        $data["title"] = "Data Category";
        $data["cat"] = $this->Cat_model->get();
        $this->template->load('template', 'cat/index', $data);
    }

    public function get_data()
    {
        $data = [
            'status' => true,
            'data' => $this->Cat_model->get(),
            'message' => ''
        ];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function add()
    {
        $cat = $this->Cat_model;
        $validation = $this->form_validation;
        $validation->set_rules($cat->rules());
        if ($validation->run()) {
            $cat->store();
            $this->session->set_flashdata('message', '<script> alert("Data Berhasil Disimpan"); </script>');
            redirect("cat");
        }
        $data["title"] = "Tambah Category";
        $this->load->view('header', $data);
        $this->load->view('cat/add', $data);
        $this->load->view('footer');
    }

    public function update($id = null)
    {
        if ($id == null) {
            // redirect('cat');
            show_404();
        } else {
            $cat = $this->Cat_model;
            $validation = $this->form_validation;
            $validation->set_rules($cat->rules());

            if ($validation->run()) {
                $cat->update($id);
                $this->session->set_flashdata('message', '<script> alert("Data Berhasil Diupdate"); </script>');
                redirect("cat");
            } else {
                $data["title"] = "Edit Category";
                $data["cat"] = $cat->edit($id);
                if (!$data["cat"]) {
                    show_404();
                } else {
                    $this->load->view('header', $data);
                    $this->load->view('cat/edit', $data);
                    $this->load->view('footer');
                }
            }
        }
    }

    public function edit($id = null)
    {
        $cat = $this->Cat_model->edit($id);
        if (!$cat) {
            $data = [
                'status'    => false,
                'data'      => '',
                'message'   => 'Data not found',
            ];
        } else {
            $data = [
                'status'    => true,
                'data'      => $cat,
                'message'   => '',
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function destroy()
    {
        if ($this->input->post('id')) {
            $ids = $this->input->post('id');
            foreach ($ids as $id) {
                $this->Cat_model->destroy($id);
            }
            $data = [
                'status'    => true,
                'data'      => '',
                'message'   => 'Data Deleted',
            ];
        } else {
            $data = [
                'status'    => false,
                'data'      => '',
                'message'   => 'Data required',
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}

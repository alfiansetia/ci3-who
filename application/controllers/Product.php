<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Product_model");
    }

    public function index()
    {
        $data["title"] = "Data Product";
        $data["product"] = $this->Product_model->get();
        $this->load->view('header', $data);
        $this->load->view('product/index', $data);
        $this->load->view('footer');
    }

    public function get_data()
    {
        $data = [
            'status' => true,
            'data' => $this->Product_model->get_join(),
            'message' => ''
        ];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function add()
    {
        $product = $this->Product_model;
        $validation = $this->form_validation;
        $validation->set_rules($product->rules());
        if ($validation->run()) {
            $product->store();
            $this->session->set_flashdata('message', '<script> alert("Data Berhasil Disimpan"); </script>');
            redirect("product");
        }
        $data["title"] = "Tambah Product";
        $this->load->view('header', $data);
        $this->load->view('product/add', $data);
        $this->load->view('footer');
    }

    public function edit($id = null)
    {
        if ($id == null) {
            // redirect('product');
            show_404();
        } else {
            $product = $this->Product_model;
            $validation = $this->form_validation;
            $validation->set_rules($product->rules());

            if ($validation->run()) {
                $product->update($id);
                $this->session->set_flashdata('message', '<script> alert("Data Berhasil Diupdate"); </script>');
                redirect("product");
            } else {
                $data["title"] = "Edit Product";
                $data["product"] = $product->edit($id);

                if (!$data["product"]) {
                    show_404();
                } else {
                    $this->load->view('header', $data);
                    $this->load->view('product/edit', $data);
                    $this->load->view('footer');
                }
            }
        }
    }

    public function destroy($id = null)
    {
        if ($id == null) {
            show_404();
        } else {
            $this->Product_model->destroy($id);
            $this->session->set_flashdata('message', '<script> alert("Data Berhasil Dihapus"); </script>');
            redirect("product");
        }
    }
}

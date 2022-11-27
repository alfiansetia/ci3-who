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

    public function import()
    {
        // var_dump($_POST);
        if (isset($_POST['submit'])) {
            $file = $_FILES['product']['tmp_name'];
            $ekstensi  = explode('.', $_FILES['product']['name']);
            if (empty($file)) {
                echo 'File tidak boleh kosong!';
            } else {
                if (strtolower(end($ekstensi)) === 'csv' && $_FILES["product"]["size"] > 0) {
                    $i = 0;
                    $dataArr = array();
                    $handle = fopen($file, "r");
                    while (($row = fgetcsv($handle, 2048))) {
                        $i++;
                        if ($i == 1) continue;
                        $data = [
                            'prod_code' => $row[0],
                            'prod_desc' => $row[1],
                            'cat_id' => $row[2],
                            'akl_id' => $row[3],
                        ];
                        $dataArr[$i] = [
                            'prod_code' => $row[0],
                            'prod_desc' => $row[1],
                            'cat_id' => $row[2],
                            'akl_id' => $row[3],
                        ];
                        $this->Product_model->store_import($data);
                    }
                    fclose($handle);
                    echo ('<pre>');
                    var_dump($dataArr);
                    echo ('</pre>');
                } else {
                    echo 'Format file tidak valid!';
                }
            }
        }

        // $file = base_url('assets/product.csv');
        // $file = fopen($file, "r");
        // $i = 0;
        // $numberOfFields = 4;
        // $csvArr = array();

        // while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
        //     $num = count($filedata);
        //     if ($i > 0 && $num == $numberOfFields) {
        //         $csvArr[$i]['name'] = $filedata[0];
        //         $csvArr[$i]['email'] = $filedata[1];
        //         $csvArr[$i]['phone'] = $filedata[2];
        //         $csvArr[$i]['created_at'] = $filedata[3];
        //     }
        //     $i++;
        // }
        // fclose($file);
        // print_r($csvArr);
    }
}

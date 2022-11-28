<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akl extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Akl_model");
    }

    public function index()
    {
        $data["title"] = "Data AKL";
        $data["akl"] = $this->Akl_model->get();
        $this->template->load('template', 'akl/index', $data);
    }

    public function get_data()
    {
        $data = [
            'status' => true,
            'data' => $this->Akl_model->get(),
            'message' => ''
        ];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function add()
    {
        $akl = $this->Akl_model;
        $validation = $this->form_validation;
        $validation->set_rules($akl->rules());
        if ($validation->run()) {
            $akl->store();
            $this->session->set_flashdata('message', '<script> alert("Data Berhasil Disimpan"); </script>');
            redirect("akl");
        }
        $data["title"] = "Tambah AKL";
        $this->load->view('header', $data);
        $this->load->view('akl/add', $data);
        $this->load->view('footer');
    }

    public function update($id = null)
    {
        if ($id == null) {
            // redirect('akl');
            show_404();
        } else {
            $akl = $this->Akl_model;
            $validation = $this->form_validation;
            $validation->set_rules($akl->rules());

            if ($validation->run()) {
                $akl->update($id);
                $this->session->set_flashdata('message', '<script> alert("Data Berhasil Diupdate"); </script>');
                redirect("akl");
            } else {
                $data["title"] = "Edit AKL";
                $data["akl"] = $akl->edit($id);
                if (!$data["akl"]) {
                    show_404();
                } else {
                    $this->load->view('header', $data);
                    $this->load->view('akl/edit', $data);
                    $this->load->view('footer');
                }
            }
        }
    }

    public function edit($id = null)
    {
        $akl = $this->Akl_model->edit($id);
        if (!$akl) {
            $data = [
                'status'    => false,
                'data'      => '',
                'message'   => 'Data not found',
            ];
        } else {
            $data = [
                'status'    => true,
                'data'      => $akl,
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
                $this->Akl_model->destroy($id);
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

    public function import()
    {
        // var_dump($_POST);
        if (isset($_POST['submit'])) {
            $file = $_FILES['akl']['tmp_name'];
            $ekstensi  = explode('.', $_FILES['akl']['name']);
            if (empty($file)) {
                echo 'File tidak boleh kosong!';
            } else {
                if (strtolower(end($ekstensi)) === 'csv' && $_FILES["akl"]["size"] > 0) {
                    $i = 0;
                    $dataArr = array();
                    $handle = fopen($file, "r");
                    while (($row = fgetcsv($handle, 2048, ';'))) {
                        $i++;
                        if ($i == 1) continue;
                        $data = [
                            'prod_code' => $row[0] == '' ? null : $row[0],
                            'prod_desc' => $row[1] == '' ? null : $row[1],
                            'cat_id' => $row[2] == '' ? null : $row[2],
                            'akl_id' => $row[3] == '' ? null : $row[3],
                        ];
                        $dataArr[$i] = [
                            'prod_code' => $row[0],
                            'prod_desc' => $row[1],
                            'cat_id' => $row[2],
                            'akl_id' => $row[3],
                        ];
                        $this->Akl_model->store_import($data);
                    }
                    fclose($handle);
                    redirect('akl');
                    // echo ('<pre>');
                    // var_dump($dataArr);
                    // echo ('</pre>');
                } else {
                    echo 'Format file tidak valid!';
                }
            }
        }
    }
}

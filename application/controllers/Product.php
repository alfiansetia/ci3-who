<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(["Product_model", "Akl_model", "Cat_model"]);
    }

    public function index()
    {
        $data["title"] = "Data Product";
        $data["product"] = $this->Product_model->get();
        $this->template->load('template', 'product/index', $data);
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

    public function update($id = null)
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

    public function edit($id = null)
    {
        $product = $this->Product_model->edit($id);
        if (!$product) {
            $data = [
                'status'    => false,
                'data'      => '',
                'message'   => 'Data not found',
            ];
        } else {
            $data = [
                'status'    => true,
                'data'      => $product,
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
                $this->Product_model->destroy($id);
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

    // public function tes()
    // {
    //     $var = '22/06/2024';
    //     $date = str_replace('/', '-', $var);
    //     $date1 =  date('Y-m-d', strtotime($date));
    //     echo date('Y-m-d', strtotime(str_replace('/', '-', $var)));
    // }

    public function import()
    {
        if (isset($_POST['submit'])) {
            $file = $_FILES['product']['tmp_name'];
            $ekstensi  = explode('.', $_FILES['product']['name']);
            if (empty($file)) {
                $dataJSON = [
                    'status'    => false,
                    'data'      => '',
                    'message'   => "FILE CAN'T EMPTY!",
                ];
            } else {
                if (strtolower(end($ekstensi)) === 'csv' && $_FILES["product"]["size"] > 0) {
                    $i = 0;
                    $dataArr = array();
                    $handle = fopen($file, "r");
                    while (($row = fgetcsv($handle, 2048, ';'))) {
                        $i++;
                        if ($i == 1) continue;

                        $prod_code = $row[0] == '' ? null : $row[0];
                        $prod_desc = $row[1] == '' ? null : $row[1];

                        $akl_id = null;
                        $akl_name = $row[2] == '' || $row[2] == '-' || $row[2] == 'FALSE' ? null : $row[2];
                        $akl_start = $row[3] == '' ? null : date('Y-m-d', strtotime(str_replace('/', '-', $row[3])));
                        $akl_end = $row[4] == '' ? null : date('Y-m-d', strtotime(str_replace('/', '-', $row[4])));
                        $akl_file = strtoupper($row[5]) != 'V' ? null : strtoupper($row[5]);
                        $akl_desc = $row[6] == '' ? null : $row[6];

                        $cat_id = null;
                        $cat_name = $row[7] == '' ? null : $row[7];
                        $cat_desc = $row[8] == '' ? null : $row[8];

                        if ($akl_name != null) {
                            $akl = $this->Akl_model->get_by_name($akl_name);
                            if ($akl) {
                                $akl_id = $akl->akl_id;
                                $this->Akl_model->update_import($akl_id, [
                                    'akl_name'  => $akl_name,
                                    'akl_start' => $akl_start,
                                    'akl_end'   => $akl_end,
                                    'akl_desc'  => $akl_desc,
                                    'akl_file'  => $akl_file,
                                ]);
                            } else {
                                $this->Akl_model->store_import([
                                    'akl_name'  => $akl_name,
                                    'akl_start' => $akl_start,
                                    'akl_end'   => $akl_end,
                                    'akl_desc'  => $akl_desc,
                                    'akl_file'  => $akl_file,
                                ]);
                            }
                        }

                        if ($cat_name != null) {
                            $cat = $this->Cat_model->get_by_name($cat_name);
                            if ($cat) {
                                $cat_id = $cat->cat_id;
                                $this->Cat_model->update_import($cat_id, [
                                    'cat_name'  => $cat_name,
                                    'cat_desc'  => $cat_desc,
                                ]);
                            } else {
                                $this->Cat_model->store_import([
                                    'cat_name'  => $cat_name,
                                    'cat_desc'  => $cat_desc,
                                ]);
                            }
                        }

                        if ($prod_code != null) {
                            $prod = $this->Product_model->get_by_code($prod_code);
                            if ($prod) {
                                $prod_id = $prod->prod_id;
                                $this->Product_model->update_import($prod_id, [
                                    'prod_code' => $prod_code,
                                    'prod_desc' => $prod_desc,
                                    'cat_id'    => $cat_id,
                                    'akl_id'    => $akl_id,
                                ]);
                            } else {
                                $this->Product_model->store_import([
                                    'prod_code' => $prod_code,
                                    'prod_desc' => $prod_desc,
                                    'cat_id'    => $cat_id,
                                    'akl_id'    => $akl_id,
                                ]);
                            }
                        }

                        // $data = [
                        //     'prod_code' => $prod_code,
                        //     'prod_desc' => $prod_desc,
                        //     'cat_id'    => $cat_id,
                        //     'akl_id'    => $akl_id,
                        // ];
                        // $this->Product_model->store_import($data);
                    }
                    fclose($handle);
                    // redirect('product');
                    // echo ('<pre>');
                    // var_dump($dataArr);
                    // echo ('</pre>');
                    $dataJSON = [
                        'status'    => true,
                        'data'      => '',
                        'message'   => "SUCCESS IMPORT DATA!",
                    ];
                } else {
                    $dataJSON = [
                        'status'    => false,
                        'data'      => '',
                        'message'   => "FILE NOT VALID!",
                    ];
                }
            }
        }else{
            $dataJSON = [
                'status'    => false,
                'data'      => '',
                'message'   => 'NOT FOUND!',
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($dataJSON);

    }
}

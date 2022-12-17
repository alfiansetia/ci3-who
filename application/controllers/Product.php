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
        $post = $this->input->post(null, TRUE);
        if (isset($post['submit'])) {
            $file = $_FILES['product']['tmp_name'];
            $ekstensi  = explode('.', $_FILES['product']['name']);
            if (empty($file)) {
                $this->session->set_flashdata('message', '<script> alert("FILE CAN,T EMPTY!"); </script>');
            } else {
                if (strtolower(end($ekstensi)) === 'csv' && $_FILES["product"]["size"] > 0) {
                    $i = 0;
                    $handle = fopen($file, "r");
                    while (($row = fgetcsv($handle, 2048, ';'))) {
                        $i++;
                        if ($i == 1) continue;

                        $prod_code = $row[0] == '' ? null : $row[0];
                        $prod_desc = $row[1] == '' ? null : $row[1];

                        $akl_id = null;
                        $akl_name = $row[2] == '' || $row[2] == '-' || $row[2] == 'FALSE' ? null : $row[2];
                        $akl_start = $row[3] == '' || $row[3] == '-' || $row[3] == 'FALSE' ? null : date('Y-m-d', strtotime(str_replace('/', '-', $row[3])));
                        $akl_end = $row[4] == '' || $row[4] == '-' || $row[4] == 'FALSE' ? null : date('Y-m-d', strtotime(str_replace('/', '-', $row[4])));
                        $akl_file = strtoupper($row[5]) != 'V' ? null : strtoupper($row[5]);
                        $akl_desc = $row[6] == '' || $row[6] == '-' || $row[6] == 'FALSE' ? null : $row[6];

                        $cat_id = null;
                        $cat_name = $row[7] == '' || $row[7] == '-' || $row[7] == 'FALSE' ? null : $row[7];
                        $cat_desc = $row[8] == '' || $row[8] == '-' || $row[8] == 'FALSE' ? null : $row[8];

                        $param = [
                            'prod_code' => $prod_code,
                            'prod_desc' => $prod_desc,
                        ];

                        if (isset($post['akl']) && $post['akl'] == 'true') {
                            if ($akl_name != null) {
                                $akl = $this->Akl_model->get_by_name($akl_name);
                                if ($akl) {
                                    $akl_id = $akl->akl_id;
                                    $this->Akl_model->update_import($akl->akl_id, [
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
                                    $akl_id = $this->db->insert_id();
                                }
                            }
                            $param['akl_id'] = $akl_id;
                        }

                        if (isset($post['cat']) && $post['cat'] == 'true') {
                            if ($cat_name != null) {
                                $cat = $this->Cat_model->get_by_name($cat_name);
                                if ($cat) {
                                    $cat_id = $cat->cat_id;
                                    $this->Cat_model->update_import($cat->cat_id, [
                                        'cat_name'  => $cat_name,
                                        'cat_desc'  => $cat_desc,
                                    ]);
                                } else {
                                    $this->Cat_model->store_import([
                                        'cat_name'  => $cat_name,
                                        'cat_desc'  => $cat_desc,
                                    ]);
                                    $cat_id = $this->db->insert_id();
                                }
                            }
                            $param['cat_id'] = $cat_id;
                        }

                        if ($prod_code != null) {
                            $prod = $this->Product_model->get_by_code($prod_code);
                            if ($prod) {
                                $prod_id = $prod->prod_id;
                                $this->Product_model->update_import($prod_id, $param);
                            } else {
                                $this->Product_model->store_import($param);
                            }
                        }
                        // echo ('<pre>');
                        // var_dump($param);
                        // echo ('</pre>');
                    }
                    fclose($handle);
                    // redirect('product');
                    // echo ('<pre>');
                    // var_dump($param);
                    // echo ('</pre>');
                    // $dataJSON = [
                    //     'status'    => true,
                    //     'data'      => '',
                    //     'message'   => "SUCCESS IMPORT DATA!",
                    // ];
                    $this->session->set_flashdata('message', '<script> alert("SUCCESS IMPORT DATA!"); </script>');
                } else {
                    $this->session->set_flashdata('message', '<script> alert("FILE NOT VALID!"); </script>');
                }
            }
        } else {
            show_404();
        }
        // if (isset($post['akl']) && $post['akl'] == true) {
        //     $dataJSON = true;
        // } else {
        //     $dataJSON = false;
        // }
        // $dataJSON = [
        //     'a' => 'a',
        //     'b' => 'b'
        // ];
        // $dataJSON['c'] = 'c';
        // header('Content-Type: application/json');
        // echo json_encode($dataJSON);
        // var_dump($_POST);
        redirect('product');
    }


    public function tes($id)
    {
        $data = $this->db->update('products', ['akl_id' => null], ['prod_id' => $id]);
        var_dump($data);
    }
}

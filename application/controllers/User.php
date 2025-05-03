<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_logged_in();
        is_user();
        $this->load->helper('rupiah');
        $this->load->helper('tglindo');
        // $this->load->model('user_model', 'user');
    }

    public function index()
    {
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Beranda';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['list_file'] = $this->db->get('tb_file')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/index', $data);
            $this->load->view('templates/footer');
        } else {
            $upload_image = $_FILES['image']['name'];
            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '2048';
                $config['upload_path'] = './assets/dist/img/profile';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/dist/img/profile/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }
            $id_user = $this->input->post('id_user');
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');
            $hp = $this->input->post('hp');
            $this->db->set('nama', $nama);
            $this->db->set('email', $email);
            $this->db->set('hp', $hp);
            $this->db->where('id_user', $id_user);
            $this->db->update('mst_user');
            $this->session->set_flashdata('message', 'Update data');
            redirect('user/index');
        }
    }

    public function ubah_password()
    {
        $this->form_validation->set_rules('current_password', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'Password Baru', 'required|trim|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Konfirm Password Baru', 'required|trim|min_length[3]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Beranda';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['list_file'] = $this->db->get('tb_file')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/index', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if ($current_password == $new_password) {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">Password baru tidak boleh sama dengan password lama</div>');
                redirect('user/index');
            } else {
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $this->db->set('password', $password_hash);
                $this->db->where('username', $this->session->userdata('username'));
                $this->db->update('mst_user');
                $this->session->set_flashdata('message', 'Ubah password');
                redirect('user/index');
            }
        }
    }

    public function files()
    {
        $this->form_validation->set_rules('nama_dokumen', 'Nama Dokumen', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Galeri File';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['list_file'] = $this->db->get('tb_file')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/files', $data);
            $this->load->view('templates/footer');
        } else {
            $config['upload_path']   = './assets/dokumen/';
            $config['allowed_types'] = 'pdf|docx|doc';
            $config['max_size']      = 2048;
            $this->load->library('upload', $config);
            $this->upload->do_upload('file');
            $file = $this->upload->data('file_name');
            $sess_id = $this->session->userdata('id_user');
            $data = [
                'tgl_upload' => $this->input->post('tgl_upload', true),
                'sess_id' => $sess_id,
                'nama_dokumen' => $this->input->post('nama_dokumen', true),
                'file' => $file
            ];
            $this->db->insert('tb_file', $data);
            $this->session->set_flashdata('message', 'Upload File');
            redirect('user/files');
        }
    }

    public function get_file()
    {
        $id_file = $this->input->post('id_file');
        echo json_encode($this->db->get_where('tb_file', ['id_file' => $id_file])->row_array());
    }

    public function edit_file()
    {
        $upload_image = $_FILES['file']['name'];
        if ($upload_image) {
            $config['allowed_types'] = 'pdf|docx|doc';
            $config['max_size']     = '2048';
            $config['upload_path'] = './assets/dokumen/';
            $this->load->library('upload', $config);
            $id_file = $this->input->post('id_file');
            if ($this->upload->do_upload('file')) {
                $data['file_id'] = $this->db->get_where('tb_file', ['id_file' => $id_file])->row_array();
                $old_file = $data['file_id']['file'];
                if ($old_file != 'default.doc') {
                    unlink(FCPATH . './assets/dokumen/' . $old_file);
                }

                $new_file = $this->upload->data('file_name');
                $this->db->set('file', $new_file);
            } else {
                echo $this->upload->display_errors();
            }
        }
        $id_file = $this->input->post('id_file');
        $nama_dokumen = $this->input->post('nama_dokumen');
        $tgl_upload = $this->input->post('tgl_upload');

        $this->db->set('nama_dokumen', $nama_dokumen);
        $this->db->set('tgl_upload', $tgl_upload);

        $this->db->where('id_file', $id_file);
        $this->db->update('tb_file');
        $this->session->set_flashdata('message', 'Update data');
        redirect('user/files');
    }


    public function download($id_file)
    {
        $data = $this->db->get_where('tb_file', ['id_file' => $id_file])->row_array();
        header("Content-Disposition: attachment; filename=" . $data['file']);
        $fp = fopen("assets/dokumen/" . $data['file'], 'r');
        $content = fread($fp, filesize('assets/dokumen/' . $data['file']));
        fclose($fp);
        echo $content;
        exit;
    }

    public function scan()
    {
        $this->form_validation->set_rules('nama_dokumen_scan', 'Nama Dokumen Scan', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Galeri Berkas Scan';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['list_file'] = $this->db->get('tb_scan')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/scan', $data);
            $this->load->view('templates/footer');
        } else {
            $config['upload_path']   = './assets/images/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 2048;
            $this->load->library('upload', $config);
            $this->upload->do_upload('scan');
            $scan = $this->upload->data('file_name');
            $sess_id_scan = $this->session->userdata('id_user');
            $data = [
                'tgl_upload_scan' => $this->input->post('tgl_upload_scan', true),
                'sess_id_scan' => $sess_id_scan,
                'nama_dokumen_scan' => $this->input->post('nama_dokumen_scan', true),
                'scan' => $scan
            ];
            $this->db->insert('tb_scan', $data);
            $this->session->set_flashdata('message', 'Upload File');
            redirect('user/scan');
        }
    }

    public function get_scan()
    {
        $id_scan = $this->input->post('id_scan');
        echo json_encode($this->db->get_where('tb_scan', ['id_scan' => $id_scan])->row_array());
    }

    public function edit_scan()
    {
        $upload_image = $_FILES['scan']['name'];
        if ($upload_image) {
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']     = '2048';
            $config['upload_path'] = './assets/images/';
            $this->load->library('upload', $config);
            $id_file = $this->input->post('id_scan');
            if ($this->upload->do_upload('scan')) {
                $data['file_id'] = $this->db->get_where('tb_scan', ['id_scan' => $id_file])->row_array();
                $old_file = $data['file_id']['scan'];
                if ($old_file != 'default.doc') {
                    unlink(FCPATH . './assets/images/' . $old_file);
                }

                $new_file = $this->upload->data('file_name');
                $this->db->set('scan', $new_file);
            } else {
                echo $this->upload->display_errors();
            }
        }
        $id_scan = $this->input->post('id_scan');
        $nama_dokumen_scan = $this->input->post('nama_dokumen_scan');
        $tgl_upload_scan = $this->input->post('tgl_upload_scan');

        $this->db->set('nama_dokumen_scan', $nama_dokumen_scan);
        $this->db->set('tgl_upload_scan', $tgl_upload_scan);

        $this->db->where('id_scan', $id_scan);
        $this->db->update('tb_scan');
        $this->session->set_flashdata('message', 'Update data');
        redirect('user/scan');
    }

    public function download_scan($id_scan)
    {
        $data = $this->db->get_where('tb_scan', ['id_scan' => $id_scan])->row_array();
        header("Content-Disposition: attachment; filename=" . $data['scan']);
        $fp = fopen("assets/images/" . $data['scan'], 'r');
        $content = fread($fp, filesize('assets/images/' . $data['scan']));
        fclose($fp);
        echo $content;
        exit;
    }

    public function input()
    {
        $this->form_validation->set_rules('nama_input', 'Nama File Input', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Galeri Berkas Input';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['list_input'] = $this->db->get('tb_input')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/input', $data);
            $this->load->view('templates/footer');
        } else {
            $config['upload_path']   = './assets/input/';
            $config['allowed_types'] = 'pdf|docx|doc';
            $config['max_size']      = 2048;
            $this->load->library('upload', $config);
            $this->upload->do_upload('file_input');
            $file_input = $this->upload->data('file_name');
            $data = [
                'tgl_input_asal' => $this->input->post('tgl_input_asal', true),
                'asal' => $this->input->post('asal', true),
                'no_nama_input' => $this->input->post('no_nama_input', true),
                'nama_input' => $this->input->post('nama_input', true),
                'deskripsi' => $this->input->post('deskripsi', true),
                'file_input' => $file_input
            ];
            $this->db->insert('tb_input', $data);
            $this->session->set_flashdata('message', 'Upload File');
            redirect('user/input');
        }
    }

    public function get_input()
    {
        $id_input = $this->input->post('id_input');
        echo json_encode($this->db->get_where('tb_input', ['id_input' => $id_input])->row_array());
    }

    public function edit_input()
    {
        $upload_image = $_FILES['file_input']['name'];
        if ($upload_image) {
            $config['allowed_types'] = 'pdf|docx|doc';
            $config['max_size']     = '2048';
            $config['upload_path'] = './assets/input/';
            $this->load->library('upload', $config);
            $id_input = $this->input->post('id_input');
            if ($this->upload->do_upload('file_input')) {
                $data['file_id'] = $this->db->get_where('tb_input', ['id_input' => $id_input])->row_array();
                $old_file = $data['file_id']['file_input'];
                if ($old_file != 'default.doc') {
                    unlink(FCPATH . './assets/input/' . $old_file);
                }

                $new_file = $this->upload->data('file_name');
                $this->db->set('file_input', $new_file);
            } else {
                echo $this->upload->display_errors();
            }
        }
        $id_input = $this->input->post('id_input');
        $tgl_input_asal = $this->input->post('tgl_input_asal');
        $asal = $this->input->post('asal');
        $no_nama_input = $this->input->post('no_nama_input');
        $nama_input = $this->input->post('nama_input');
        $deskripsi = $this->input->post('deskripsi');

        $this->db->set('tgl_input_asal', $tgl_input_asal);
        $this->db->set('asal', $asal);
        $this->db->set('no_nama_input', $no_nama_input);
        $this->db->set('nama_input', $nama_input);
        $this->db->set('deskripsi', $deskripsi);

        $this->db->where('id_input', $id_input);
        $this->db->update('tb_input');
        $this->session->set_flashdata('message', 'Update data');
        redirect('user/input');
    }

    public function download_input($id_input)
    {
        $data = $this->db->get_where('tb_input', ['id_input' => $id_input])->row_array();
        header("Content-Disposition: attachment; filename=" . $data['file_input']);
        $fp = fopen("./assets/input/" . $data['file_input'], 'r');
        $content = fread($fp, filesize('./assets/input/' . $data['file_input']));
        fclose($fp);
        echo $content;
        exit;
    }

    public function output()
    {
        $this->form_validation->set_rules('nama_output', 'Nama File output', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Galeri Berkas Output';
            $data['user'] = $this->db->get_where('mst_user', ['username' => $this->session->userdata('username')])->row_array();
            $data['list_output'] = $this->db->get('tb_output')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_user', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/output', $data);
            $this->load->view('templates/footer');
        } else {
            $config['upload_path']   = './assets/output/';
            $config['allowed_types'] = 'pdf|docx|doc';
            $config['max_size']      = 2048;
            $this->load->library('upload', $config);
            $this->upload->do_upload('file_output');
            $file_output = $this->upload->data('file_name');
            $data = [
                'tgl_output_asal' => $this->input->post('tgl_output_asal', true),
                'asal_output' => $this->input->post('asal_output', true),
                'no_nama_output' => $this->input->post('no_nama_output', true),
                'nama_output' => $this->input->post('nama_output', true),
                'deskripsi_output' => $this->input->post('deskripsi_output', true),
                'file_output' => $file_output
            ];
            $this->db->insert('tb_output', $data);
            $this->session->set_flashdata('message', 'Upload File');
            redirect('user/output');
        }
    }

    public function get_output()
    {
        $id_output = $this->input->post('id_output');
        echo json_encode($this->db->get_where('tb_output', ['id_output' => $id_output])->row_array());
    }

    public function edit_output()
    {
        $upload_image = $_FILES['file_output']['name'];
        if ($upload_image) {
            $config['allowed_types'] = 'pdf|docx|doc';
            $config['max_size']     = '2048';
            $config['upload_path'] = './assets/output/';
            $this->load->library('upload', $config);
            $id_output = $this->input->post('id_output');
            if ($this->upload->do_upload('file_output')) {
                $data['file_id'] = $this->db->get_where('tb_output', ['id_output' => $id_output])->row_array();
                $old_file = $data['file_id']['file_output'];
                if ($old_file != 'default.doc') {
                    unlink(FCPATH . './assets/output/' . $old_file);
                }

                $new_file = $this->upload->data('file_name');
                $this->db->set('file_output', $new_file);
            } else {
                echo $this->upload->display_errors();
            }
        }
        $id_output = $this->input->post('id_output');
        $tgl_output_asal = $this->input->post('tgl_output_asal');
        $asal_output = $this->input->post('asal_output');
        $no_nama_output = $this->input->post('no_nama_output');
        $nama_output = $this->input->post('nama_output');
        $deskripsi_output = $this->input->post('deskripsi_output');

        $this->db->set('tgl_output_asal', $tgl_output_asal);
        $this->db->set('asal_output', $asal_output);
        $this->db->set('no_nama_output', $no_nama_output);
        $this->db->set('nama_output', $nama_output);
        $this->db->set('deskripsi_output', $deskripsi_output);

        $this->db->where('id_output', $id_output);
        $this->db->update('tb_output');
        $this->session->set_flashdata('message', 'Update data');
        redirect('user/output');
    }

    public function download_output($id_output)
    {
        $data = $this->db->get_where('tb_output', ['id_output' => $id_output])->row_array();
        header("Content-Disposition: attachment; filename=" . $data['file_output']);
        $fp = fopen("./assets/output/" . $data['file_output'], 'r');
        $content = fread($fp, filesize('./assets/output/' . $data['file_output']));
        fclose($fp);
        echo $content;
        exit;
    }
}

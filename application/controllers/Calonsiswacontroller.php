<?php

/**
 *
 * Author Rizki Mufrizal <mufrizalrizki@gmail.com>
 * Since Apr 21, 2016
 * Time 7:20:48 PM
 * Encoding UTF-8
 * Project Metode-Saw
 * Package Expression package is undefined on line 14, column 14 in Templates/Scripting/PHPClass.php.
 *
 */
class Calonsiswacontroller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('calonsiswa');
        $this->load->model('nilaicalonasisten');
    }

    public function index() {

        $data['calon_asis'] = $this->calonsiswa->ambilCalonAsisten();
        $data['titleBrow'] = "DATA CALAS-SPKTI";
        $this->load->view('tbcalonasistenview', $data);
    }

    public function tambahCalonSiswa() {
        $val = array(
            'nim' => $this->input->post('nim'),
            'nama' => $this->input->post('nama'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'alamat' => $this->input->post('alamat')
        );
        $this->CalonSiswa->tambahCalonSiswa($val);
        redirect('admin/CalonSiswaController');
    }

    public function ambilCalonSiswaDanNilaiBerdasarkanNim($nim) {
        $data['calon_siswa_nilai'] = $this->CalonSiswa->ambilCalonSiswaBerdasarkanNim($nim);
        $this->load->view('admin/CalonSiswaTambahNilaView', $data);
    }

}

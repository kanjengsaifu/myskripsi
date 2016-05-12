<?php

/**
 *
 * Author Rizki Mufrizal <mufrizalrizki@gmail.com>
 * Since Apr 21, 2016
 * Time 10:16:56 PM
 * Encoding UTF-8
 * Project Metode-SAW
 * Package Expression package is undefined on line 14, column 14 in Templates/Scripting/PHPClass.php.
 *
 */
class Nilaicalonasistencontroller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('nilaicalonasisten');
        $this->load->model('calonsiswa');
        $this->load->model('Himpunan');
    }

    public function index() {
        $data['nilai_calon_asisten'] = $this->nilaicalonasisten->ambilNilaiCalasSemua();
        $data['titleBrow'] = "NILAI CALAS-SPKTI";
        $this->load->view('tabelnilaicalasview',$data );
    }

    public function tambahNilaiCalonAsisten() {

        $nim = $this->input->post('npm');
        $c1 = $this->input->post('c1');
        $c2 = $this->input->post('c2');
        $c3 = $this->input->post('c3');
        $c4 = $this->input->post('c4');
        $c5 = $this->input->post('c5');
        $c6 = $this->input->post('c6');

        if ($c6=="LOKAL"){
              $c6=20;
              $c6a= 20.0;
        }
        else if($c6=="NASIONAL"){
              $c6=60;
              $c6a= 60.0;

        }
        else if($c6=="INTERNASIONAL"){
              $c6=100;
              $c6a= 100.0;

        }

        else if($c6=="NONE"){
              $c6=0;
              $c6a= 0;
        }

        if ($c5>=2.85 && $c5<=3.1 ){
            $c5=20;
        }
        else if($c5>3.1 && $c5<=3.4)
        {
            $c5=40;

        }
        else if($c5>3.4 && $c5<=3.65)
        {
            $c5=61;

        }
        else if($c5>3.65 && $c5<=4.00)
        {

            $c5=100;

        }
        else{
            $c5=0;

        }

        foreach ($this->Himpunan->ambilHimpunan() as $h) {
            if ($c1 >= $h->batas_atas and $c1 <= $h->batas_bawah) {
                $c1 = $h->nilai;
            }
            if ($c2 >= $h->batas_atas and $c2 <= $h->batas_bawah) {
                $c2 = $h->nilai;
            }
            if ($c3 >= $h->batas_atas and $c3 <= $h->batas_bawah) {
                $c3 = $h->nilai;
            }
            if ($c4 >= $h->batas_atas and $c4 <= $h->batas_bawah) {
                $c4 = $h->nilai;
            }
            if ($c5 >= $h->batas_atas and $c5 <= $h->batas_bawah) {
                $c5 = $h->nilai;
            }
            if ($c6 >= $h->batas_atas and $c6 <= $h->batas_bawah) {
                $c6 = $h->nilai;
            }

        }

        // switch ($c6) {
        //   case "LOKAL":
        //         $c6=20;
        //   break;
        //   case "NASIONAL":
        //         $c6=60;
        //   break;
        //   case "INTERNASIONAL":
        //         $c6=100;
        //   break;
        //
        //     default:
        //         $sc6=0;
        //
        // }

        //print ($c6a);


        $val = array(
            'id_nilai' => rand(),
            'nilai_asli_c1' => $this->input->post('c1'),
            'nilai_asli_c2' => $this->input->post('c2'),
            'nilai_asli_c3' => $this->input->post('c3'),
            'nilai_asli_c4' => $this->input->post('c4'),
            'nilai_asli_c5' => $this->input->post('c5'),
            'nilai_asli_c6' =>  $c6a,
            'c1' => $c1,
            'c2' => $c2,
            'c3' => $c3,
            'c4' => $c4,
            'c5' => $c5,
            'c6' => $c6,
            'npm' => $nim
        );
        $this->nilaicalonasisten->tambahNilaiCalonAsisten($val);

        $valCalonSiswa = array(
            'status' => TRUE
        );
        $this->calonsiswa->ubahCalonSiswa($valCalonSiswa, $nim);

         redirect('HimpunanController');

    }
    function import_csv_calas() {

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {

            redirect('index/calas?status=csvgagal');

        } else {

            $file_data = $this->upload->data();
            $file_path =  './uploads/'.$file_data['file_name'];

            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);
                foreach ($csv_array as $row) {
                    $insert_data =
                     array('kode_peserta'=>$row['kode_peserta'],
                    			 'npm'=>$row['npm'],
                        	 'nama'=>$row['nama'],
                        	 'kelas'=>$row['kelas'],
                        	 'semester'=>$row['semester'],
        										'jenis_kelamin'=>$row['jenis_kelamin'],
        										'agama'=>$row['agama'],
        										'no_hp'=>$row['no_hp'],
        										'email'=>$row['email'],
        										'alamat'=>$row['alamat']);


                $this->model_admin->m_insert_csvcalas($insert_data);
                }

                foreach ($csv_array as $row1) {
                    $insert_data = array('npm'=>$row1['npm'],
                        				'c1'=>$row1['ipk'],
                        				'c2'=>$row1['prestasi'],
                        				'c3'=>$row1['nilai_teori'],
                        				'c4'=>$row1['nilai_praktek'],
                        				'c5'=>$row1['nilai_presentasi'],
                        				'c6'=>$row1['nilai_wawancara']);


                $this->model_admin->m_insert_csvcalas1($insert_data);
                }

                $val = array(
                    'id_nilai' => rand(),
                    'nilai_asli_c1' => $this->input->post('c1'),
                    'nilai_asli_c2' => $this->input->post('c2'),
                    'nilai_asli_c3' => $this->input->post('c3'),
                    'nilai_asli_c4' => $this->input->post('c4'),
                    'nilai_asli_c5' => $this->input->post('c5'),
                    'nilai_asli_c6' =>  $c6a,
                    'c1' => $c1,
                    'c2' => $c2,
                    'c3' => $c3,
                    'c4' => $c4,
                    'c5' => $c5,
                    'c6' => $c6,
                    'npm' => $nim
                );

                redirect('index/calas?status=ok');

            } else

            	echo '<script language="javascript">';
				echo 'alert("Upload gagal")';
				echo '</script>';

                redirect('index/calas','refresh');
        }
    }

}

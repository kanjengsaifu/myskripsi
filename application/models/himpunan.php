<?php

class Himpunan extends CI_Model{


    public function ambilHimpunan(){

      return $this->db->get('tb_himpunan')->result();

    }

    public function ambilHimpunanJson(){

      return  $this->db->get('tb_himpunan')->result();



    }









}







?>

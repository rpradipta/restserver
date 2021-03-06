<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Api extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        //untuk memuat model M_produk.php agar dapat dipakai di controller ini
        $this->load->model(array('m_produk'));
        $this->load->model(array('m_airline'));
        $this->load->model(array('m_pesanan'));
    }

    //Menampilkan data produk
    function tiket_get() {
        $id = $this->get('kode_tiket');
        if ($id == '') {
            $produk = $this->m_produk->getProduk();
        } else {
            $produk = $this->m_produk->getProdukByIdTiket($id);
        }
        $this->response($produk, 200);
    }

    function pesan_get() {
        $id = $this->get('kode_order');
        if ($id == '') {
            $produk = $this->m_pesanan->getProduk();
        } else {
            $produk = $this->m_pesanan->getProdukById($id);
        }
        $this->response($produk, 200);
    }
    
    //Mengubah data produk
    function tiket_post() {
        //mengambil ID yang dikirim melalui method post
        $id = $this->post('id');
        
        //mengambil data yang dikirim melalui method post
         $data = array(
                'tgl_berangkat'        =>  $this->input->post('tgl'),
                'harga'      =>  $this->input->post('harga'),
                'asal'     =>  $this->input->post('asal'),            
                 
                'tujuan'     =>  $this->input->post('tujuan')
                );
        
        //proses update data ke dalam database
        $update = $this->m_produk->updateProduk($id,$data);
        //pengecekan apakah proses update berhasil atau tidak
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
    
    //Menambah data produk
    function tiket_put() {
        //mengambil data yang dikirim melalui method put
        $airline = $this->m_airline->getAirlineId($this->put('airline'));
        $asl = substr($this->put('asal'), 0,3);
        $tjn = substr($this->put('tujuan'), 0,3);   
        $hrg = $this->put('harga')/1000;
        $kode = substr($airline, 0,2).$asl.$tjn.$hrg;
       $data = array(
                'kode_tiket'      => $kode,
                'id_airline'      => $airline,
                'tgl_berangkat'      => $this->put('tgl'),
                'harga'      => $this->put('harga'),
                'asal'     => $this->put('asal'),
                'tujuan'      => $this->put('tujuan')
        );
        //proses insert data ke dalam database
        $insert = $this->m_produk->insertProduk($data);

        //pengecekan apakah proses insert berhasil atau tidak
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
    
    //Menghapus salah satu data produk
    function tiket_delete() {
        //mengambil data ID yang dikirim melalui method post
        $id = $this->delete('kode_tiket');
        //proses delete data dari database
        $delete = $this->m_produk->deleteProduk($id);

        //pengecekan apakah proses delete berhasil atau tidak
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //Masukan function selanjutnya disini
}
?>

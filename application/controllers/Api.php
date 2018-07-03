<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Api extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        //untuk memuat model M_produk.php agar dapat dipakai di controller ini
        $this->load->model(array('m_produk'));
    }

    //Menampilkan data produk
    function tiket_get() {
        $id = $this->get('id');
        if ($id == '') {
            $produk = $this->m_produk->getProduk();
        } else {
            $produk = $this->m_produk->getProdukById($id);
        }
        $this->response($produk, 200);
    }
    
    //Mengubah data produk
    function tiket_post() {
        //mengambil ID yang dikirim melalui method post
        $id = $this->post('id');
        //mengambil data yang dikirim melalui method post
        $data = array(
                'nama'      => $this->post('nama'),
                'tipe'      => $this->post('tipe'),
                'harga'     => $this->post('harga'),
                'stok'      => $this->post('stok')
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
        $data = array(
                'nama'      => $this->put('nama'),
                'tipe'      => $this->put('tipe'),
                'harga'     => $this->put('harga'),
                'stok'      => $this->put('stok')
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
        $id = $this->delete('id');
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

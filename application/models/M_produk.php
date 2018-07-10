<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_produk extends CI_Model{
    private $table = "ticket";
    
    function getProduk(){        
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
    function getProdukById($id){
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function getProdukByIdTiket($id){
        $this->db->where('kode_tiket',$id);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function updateProduk($id,$data){
        $this->db->where('kode_tiket', $id);
        return $this->db->update($this->table, $data);
    }
    
    function insertProduk($data){
        return $this->db->insert($this->table,$data);
    }
    
    function deleteProduk($id){
        $this->db->where('kode_tiket', $id);
        $query = $this->db->delete($this->table);
        if($this->db->affected_rows() == '1'){
            return true;
        }else{
            return false;
        }
    }
}
?>

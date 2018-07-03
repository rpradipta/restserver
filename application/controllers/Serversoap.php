<?php 

if(! defined("BASEPATH")) exit("No direct script access allowed");

class Serversoap extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        
        $ns = 'http://'.$_SERVER['HTTP_HOST'].'/serversoap/index.php/serversoap/';
        
        // load nusoap toolkit library in controller
        $this->load->library("Nusoap_library"); 
          
        // create soap server object
        $this->nusoap_server = new soap_server(); 
        
        // wsdl configuration
        $this->nusoap_server->configureWSDL("Membuat Server SOAP", $ns);
        
        // server namespace
        $this->nusoap_server->wsdl->schemaTargetNamespace = $ns;

        //parameter pada fungsi penjumlahan berserta tipe datanya
        $input_array = array ('a' => "xsd:string", 'b' => "xsd:string"); 

        //nilai kembalian beserta tipe datanya
        $return_array = array ("hasil" => "xsd:string");

        //proses registrasi fungsi penjumlahan
        $this->nusoap_server->register(
            'penjumlahan',                  // method name
            $input_array,                   // input parameters
            $return_array,                  // output parameters    
            "urn:SOAPServerWSDL",           // namespace
            "urn:".$ns."penjumlahan",       // soap action
            "rpc",                          // style
            "encoded",                      // use
            "Penjumlahan Dua Angka"         // documentation 
        );
         
    }
        public function index(){
           
           function penjumlahan($a,$b){
               $c = $a + $b;
               return $c;
           }

           // read raw data from request body
           $this->nusoap_server->service(file_get_contents("php://input")); 
        }

}
    
?>

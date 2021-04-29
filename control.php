<?php
class dht22{
 public $link='';
 function __construct($flow_rate, $total_pemakaian){
  $this->connect();
  $this->storeInDB($flow_rate, $total_pemakaian);
 }
 
 function connect(){
  $this->link = mysqli_connect('localhost','root','') or die('Cannot connect to the DB');
  mysqli_select_db($this->link,'create_project') or die('Cannot select the DB');
 }
 
 function storeInDB($flow_rate, $total_pemakaian){
  $query = "insert into node_air set total_pemakaian='".$total_pemakaian."', flow_rate='".$flow_rate."'";
  $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
  if($result === TRUE){echo "Data Tersimpan";}else{echo "Gagal Menyimpan data";}
 }	
 
}
if($_GET['dataFlow_rate'] != '' and  $_GET['dataTotal_pemakaian'] != ''){
 $dht22=new dht22($_GET['dataFlow_rate'],$_GET['dataTotal_pemakaian']);
}

?>
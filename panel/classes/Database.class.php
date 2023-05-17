<?php


class Database {

    private $host = "localhost";
	private	$user = "root";
    private $pass = "";
    private $database = "ticketsystem";
    public $conn;

    public function __construct() {

        $polaczenie = mysqli_connect ($this->host, $this->user, $this->pass, $this->database);
        $polaczenie->set_charset("utf8");

        if (!$polaczenie) {
		    die("Wystąpił błąd połączenia z baza danych"); 
        } else {
            return $this->conn = $polaczenie;
        }

    }
    
    public function connect() {
        
       return $this->conn;

    }
    
    public function doQuery($sql) {
    
         $this->conn->query($sql);
    }
    
    public function doFetch($sql) {
        

		$table = array();
        
        if ($zapytanie = $this->conn->query($sql)) {
            
            $ile = $zapytanie -> num_rows;

            if ($ile > 0)
            {
            
                while ($obiekt = $zapytanie -> fetch_assoc()) {
                    
                    $table[] = $obiekt;
                    
                }
            } else {
                $table[] = null;
            }

            
        }
        
		return $table;
        
    }
    
    
    public function doSelect($sql, $ile = false)
    {
        
		$newArray = array();
        $arr = array();
        
        if ($zapytanie = $this->conn->query($sql)){
            
            while ($table = $zapytanie->fetch_assoc()){
                $newArray[] = $table;
            }
			
			
            
            if ($ile === true) {
                $arr = count($newArray);
            } else {
                $arr = $newArray;
            }

        }
        
        return $arr;
        
    }

    public function getLastIdOfColumn($column) {

        $sql = "select id from ".$column." order by id DESC LIMIT 1";
        $id = "";

        if ($q = $this->conn->query($sql) ) {

            $tmp = $q -> fetch_assoc();

            $id  = $tmp['id'];

            if ($id <= 0 ) {
                $id = 1;
            }
           
            
        }

        return $id;

    }
    
}

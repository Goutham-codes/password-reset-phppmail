<?php
    class Users{
        private $conn;
        private $table='user';

        public $u_id;
        public $uname;
        public $email;
        public $password;
        public $address;
        public $phone;

        public function __construct($db){
        	$this->conn=$db;
        }

        public function update($newpass){
            
            echo $newpass;
            $query='UPDATE '.$this->table.' SET password= :password WHERE email= :email';
            $stmt=$this->conn->prepare($query);
            $stmt->bindParam(':password',$newpass);
            $stmt->bindParam(':email',$this->email);
            $stmt->execute();
            return $stmt;
        }

    }
?>
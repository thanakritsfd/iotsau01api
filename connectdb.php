<?php
//ไฟล์กลางที่ทำงานเพื่อใช้ในการติดต่อกับ Database
class DatabaseConnect{
    //ตัวแปรที่จะใช้ในการติดต่อกับ DB
    private $host = "localhost"; //ชื่อ Server/Host/Damain ที่เก็บ DB 
    private $uname = "root";  //Username ที่เข้าใช้งาน DB
    private $pword = "123456789";      //Password ที่เข้าใช้งาน DB
    private $dbname = "iotsau_01_db";   //ชื่อ DB

    // private $uname = "u231198616_iotgroupa";  //Username ที่เข้าใช้งาน DB
    // private $pword = "S@u028074500";      //Password ที่เข้าใช้งาน DB
    // private $dbname = "u231198616_iotgroupa_db";   //ชื่อ DB

    //ตัวแปรที่ใช้สำหรับติดต่อกับฐานข้อมูล
    public $connDB;

    //ฟังก์ชันที่ใช้สำหรับติดต่อไปยัง DB
    public function getConnection(){        
        $this->connDB = null;

        try{
            //คำสั่งติดต่อ DB
            $this->connDB = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",$this->uname, $this->pword
            );
            
            $this->connDB->exec("set names utf8");
            //echo "Connection OK";
        }catch(PDOException $ex){
            //echo "Connection NOT OK";
        }

        //ส่งผลการติดต่อไปยัง DB กลับไปยังจุดที่เรียกใช้ฟังก์ชัน
        return $this->connDB;
    }
}
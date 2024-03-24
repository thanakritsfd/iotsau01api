<?php
//ใช้ทำงานกับข้อมูล กับ Table: user_tb ใน  Database: iot_sau01_db 
//มี Insert, Update, Delete, Select (ดึง, ค้น, ตรวจสอบ, เอามา)
class User
{
    //สร้างตัวแปรที่ใช้สำหรับการติดต่อกับ DB เพื่อมาใช้กับการทำงานกับ Table ใน DB
    private $connectDB;

    //สร้างตัวแปรที่แมปกับ column ใน table
    public $userId;
    public $userFullname;
    public $userName;
    public $userPassword;
    public $userAge;

    public $message; //ตัวแปรสารพัดประโยชน์

    //สร้าง Constructor เพื่อรับค่ามากำหนดให้กับตัวแปรที่ใช้สำหรับการติดต่อกับ DB
    public function __construct($connectDB)
    {
        $this->connectDB = $connectDB;
    }

    //เป็นส่วนของฟังก์ชันต่าง ตามวัตถุประสงค์การทำงานของแต่ละ API ที่จะทำงานกับตาราง User
    public function getUser()
    {
        //สร้างคำสั่ง SQL
        $strSQL = "SELECT * FROM user_tb";

        //สร้าง Statement เพื่อใช้งานคำสั่ง SQL
        $stmt = $this->connectDB->prepare($strSQL);

        //สั่ง SQL ทำงานผ่าน Statement
        $stmt->execute();

        //ส่งค่ากลับผลลัพธ์จากการใช้งานคำสั่ง SQL
        return $stmt;
    }

    public function checkLoginUser()
    {
        //สร้างคำสั่ง SQL
        $strSQL = "SELECT * FROM user_tb WHERE userName = :userName and userPassword = :userPassword";

        //สร้าง Statement เพื่อใช้งานคำสั่ง SQL
        $stmt = $this->connectDB->prepare($strSQL);

        //ตรวจสอบค่าที่ส่งมาจาก Client ก่อนเพื่อที่จะกำหนดให้กับ Parameter ของ SQL
        $this->userName = htmlspecialchars(strip_tags($this->userName));
        $this->userPassword = htmlspecialchars(strip_tags($this->userPassword));

        //กำหนดค่าที่ส่งมาจาก Client ให้กับ Parameter ของ SQL
        $stmt->bindParam(":userName", $this->userName);
        $stmt->bindParam(":userPassword", $this->userPassword);

        //สั่ง SQL ทำงานผ่าน Statement
        $stmt->execute();

        //ส่งค่ากลับผลลัพธ์จากการใช้งานคำสั่ง SQL
        return $stmt;
    }

    public function insertUser()
    {
        //สร้างคำสั่ง SQL
        $strSQL = "INSERT INTO 
                    user_tb (userFullname, userName, userPassword, userAge) 
                   VALUES  
                   (:userFullname, :userName, :userPassword, :userAge)";

        //สร้าง Statement เพื่อใช้งานคำสั่ง SQL
        $stmt = $this->connectDB->prepare($strSQL);

        //ตรวจสอบค่าที่ส่งมาจาก Client ก่อนเพื่อที่จะกำหนดให้กับ Parameter ของ SQL
        $this->userFullname = htmlspecialchars(strip_tags($this->userFullname));
        $this->userName = htmlspecialchars(strip_tags($this->userName));
        $this->userPassword = htmlspecialchars(strip_tags($this->userPassword));
        $this->userAge = intval(htmlspecialchars(strip_tags($this->userAge)));

        //กำหนดค่าที่ส่งมาจาก Client ให้กับ Parameter ของ SQL
        $stmt->bindParam(":userFullname", $this->userFullname);
        $stmt->bindParam(":userName", $this->userName);
        $stmt->bindParam(":userPassword", $this->userPassword);
        $stmt->bindParam(":userAge", $this->userAge);

        //สั่ง SQL ทำงานผ่าน Statement
        if ($stmt->execute()) {
            //insert สำเร็จ
            return true;
        } else {
            //insert ไม่สำเร็จ
            return false;
        }
    }

    public function updateUser()
    {
        //สร้างคำสั่ง SQL
        $strSQL = "UPDATE user_tb SET 
                     userFullname = :userFullname, userName = :userName, userPassword = :userPassword, userAge = :userAge
                   WHERE
                     userId = :userId";

        //สร้าง Statement เพื่อใช้งานคำสั่ง SQL
        $stmt = $this->connectDB->prepare($strSQL);

        //ตรวจสอบค่าที่ส่งมาจาก Client ก่อนเพื่อที่จะกำหนดให้กับ Parameter ของ SQL
        $this->userId = intval(htmlspecialchars(strip_tags($this->userId)));
        $this->userFullname = htmlspecialchars(strip_tags($this->userFullname));
        $this->userName = htmlspecialchars(strip_tags($this->userName));
        $this->userPassword = htmlspecialchars(strip_tags($this->userPassword));
        $this->userAge = intval(htmlspecialchars(strip_tags($this->userAge)));

        //กำหนดค่าที่ส่งมาจาก Client ให้กับ Parameter ของ SQL
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":userFullname", $this->userFullname);
        $stmt->bindParam(":userName", $this->userName);
        $stmt->bindParam(":userPassword", $this->userPassword);
        $stmt->bindParam(":userAge", $this->userAge);

        //สั่ง SQL ทำงานผ่าน Statement
        if ($stmt->execute()) {
            //update สำเร็จ
            return true;
        } else {
            //update ไม่สำเร็จ
            return false;
        }
    }

    function deleteUser()
    {
        //สร้างคำสั่ง SQL
        $strSQL = "DELETE FROM  user_tb WHERE userId = :userId";

        //สร้าง Statement เพื่อใช้งานคำสั่ง SQL
        $stmt = $this->connectDB->prepare($strSQL);

        //ตรวจสอบค่าที่ส่งมาจาก Client ก่อนเพื่อที่จะกำหนดให้กับ Parameter ของ SQL
        $this->userId = intval(htmlspecialchars(strip_tags($this->userId)));

        //กำหนดค่าที่ส่งมาจาก Client ให้กับ Parameter ของ SQL
        $stmt->bindParam(":userId", $this->userId);

        //สั่ง SQL ทำงานผ่าน Statement
        if ($stmt->execute()) {
            //delete สำเร็จ
            return true;
        } else {
            //delete ไม่สำเร็จ
            return false;
        }
    }
}

<?php 
//API ที่ทำหน้าที่รับ request จาก client เพื่อไปนำข้อมูลที่ client ส่งมาแก้ไขไปบันทึกใน DB แล้ว response กลับไปยัง client ว่าแก้ไขบันทึกเรียบร้อยแล้ว

//กำหนดการเรียกใช้ข้าม Domain
header("Access-Control-Allow-Origin: *");
//กำหนดเนื้อหาข้อมูลที่ใช้ในการรับส่งเป็น JSON และเข้ารหัสอักขระเป็น UTF-8
header("Content-Type: application/json; charset=UTF-8");

//เรียกใช้งานไฟล์ connectdb.php, user.php
require_once "./../../connectdb.php";
require_once "./../../models/user.php";

$connectDB = new DatabaseConnect();
$user = new User($connectDB->getConnection()); //สร้าง Connection DB

//ตัวแปรเก็บค่าที่ส่งมาจากฝั่ง Client ซึ่งเป็น JSON มาทำการ decode เพื่อเอามาใช้งาน
$data = json_decode(file_get_contents("php://input"));

//เอาค่าที่เก็บในตัวแปรหลังจากการ decode มากำหนดให้กับตัวแปรที่จะใช้กับฟังก์ชันที่ model
$user->userId = $data->userId;
$user->userFullname = $data->userFullname;
$user->userName = $data->userName;
$user->userPassword = $data->userPassword;
$user->userAge = $data->userAge;

//เรียกใช้ฟังก์ชัน update แล้วตรวจสอบผล
if( $user->updateUser()){
    //update สำเร็จ
    $resultArray = array(
        "message"=>"1"
    );
    http_response_code(200);
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
}else{
    //update ไม่สำเร็จ
    $resultArray = array(
        "message"=>"0"
    );
    http_response_code(200);
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
}
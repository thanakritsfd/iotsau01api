<?php 
//API ที่ทำหน้าที่รับ request จาก client เพื่อไป query ข้อมูลจาก DB แล้ว response ส่งกลับไปยัง client
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
$user->userName = $data->userName;
$user->userPassword = $data->userPassword;

//เรียกใช้ฟังก์ชัน checkLoginUser()
$result = $user->checkLoginUser();

//ตรวจสอบผลที่ได้จากการ query ข้อมูลว่ามีข้อมูลหรือไม่
//ตรวจสอบว่า $result มีข้อมูลหรือไม่
if ($result->rowCount() > 0) {
    //มีข้อมูล ในที่นี้คือ Username/Password ถูกต้อง
    //จะส่งค่า ไอดี ชื่อ และอายุกลับไป
    $resultData = $result->fetch(PDO::FETCH_ASSOC);
    extract($resultData);
    $resultArray = array(
        "message" => "1",
        "userId" => strval($userId),
        "userFullname" => $userFullname,
        "userAge" => strval($userAge)
    );
    http_response_code(200);
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
} else {
    //มีข้อมูล ในที่นี้คือ Username/Password ไม่ถูกต้อง
    $resultArray = array(
        "message"=>"0"
    );
    http_response_code(200);
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
}

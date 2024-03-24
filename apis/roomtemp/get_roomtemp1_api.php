<?php
header("Access-control-allow-origin: *");
header("content-type: application/json; charset=UTF-8");

require_once "./../../connectdb.php";
include_once "./../../models/roomtemp.php";

$databaseConnect = new DatabaseConnect();
$connDB = $databaseConnect->getConnection();

$getallRoomtemp = new Roomtemp($connDB);

//เรียกใช้ Function ตามวัตถุประสงค์ของ API ตัวนี้
$stmt = $getallRoomtemp->getallRoomtemp();

//นับแถวเพื่อดูว่าได้ข้อมูลมาไหม 
$numrow = $stmt->rowCount();

//สร้างตัวแปรมาเก็บข้อมูลที่ได้จากการเรียกใช้ function เพื่อส่งกับไปยังส่วนที่เรียกใช้ API
$getallRoomtemp_arr = array();

//ตรวจสอบผล และส่งกลับไปยังส่วนที่เรียกใช้ API
if ($numrow > 0) {
    //มีข้อมูล เอาข้อมูลใสาตัวแปร และเตรียมส่งกลับ
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $getallRoomtemp_item = array(
            "temp1" => $temp1,
            "datesave" => $datesave,
            "timesave" => $timesave,
        );

        array_push($getallRoomtemp_arr, $getallRoomtemp_item);
    }
} else {
    //ไม่มีข้อมูล เอาข้อมูลใส่ตัวแปร และเตรียมส่งกลับ
    $getallRoomtemp_item = array(
        "massage" => "0"
    );
        array_push($getallRoomtemp_arr, $getallRoomtemp_item);
}

//คำสั่งจัดการข้อมูลใหเฃ้เป็น JSON เพื่อส่งกลับ
http_response_code(200);
echo json_encode($getallRoomtemp_arr, JSON_UNESCAPED_UNICODE);
<?php


/* TABLE */


//DROP TABLE IF EXISTS `shipments`;
//CREATE TABLE IF NOT EXISTS `shipments` (
//`id` int(11) NOT NULL AUTO_INCREMENT,
//  `name` varchar(255) NOT NULL,
//  `weight` varchar(255) NOT NULL,
//  `height` varchar(255) NOT NULL,
//  `order_addres` varchar(255) NOT NULL,
//  `delivery_price` varchar(255) NOT NULL,
//  `phone_number` varchar(11) NOT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=MyISAM DEFAULT CHARSET=latin1;
//COMMIT;


/* connection to database  */

try {
    $conn = new PDO("mysql:host=localhost;dbname=shipments", 'root', '');
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}



/* ENTER INTO DATA TABLE  */


if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(isset($_POST['name']) && isset($_POST['weight']) && isset($_POST['height']) && isset($_POST['order_address']) && isset($_POST['delivery_price']) &&  isset($_POST['phone_number'])) {


        $name = $_POST['name'];
        $weight = $_POST['weight'];
        $height = $_POST['height'];
        $order_address = $_POST['order_address'];
        $delivery_price = $_POST['delivery_price'];
        $phone_number = $_POST['phone_number'];

        $sql = "INSERT INTO `shipments` (`id`, `name`, `weight`,`height`,`order_address`,`delivery_price`,`phone_number`) VALUES (null, :name,:weight,:height,:order_address,:delivery_price,:phone_number)";
        $stmt= $conn->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':weight' => $weight,
            ':height' => $height ,
            ':order_address' => $order_address ,
            ':delivery_price' => $delivery_price ,
            ':phone_number' => $phone_number,
        ]);
        if($stmt){
            $resultData = array('status' => true, 'message' => 'shipments inserted successfully  ');
        }else{
            $resultData = array('status' => false, 'message' => 'Error in insert ');
        }


    }else{
        $resultData = array('status' => false, 'message' => 'please enter all fields ');
    }


}


/* FETCH DATA by ID  */

if(isset($_GET['order'])) {
    $order_number = $_GET['order'];
    $shipments = $conn->prepare('SELECT * FROM `shipments` where id = :order ');
    $shipments->execute([
        ':order' => $order_number,
    ]);
   echo json_encode($shipments->fetchAll(PDO::FETCH_ASSOC));

}



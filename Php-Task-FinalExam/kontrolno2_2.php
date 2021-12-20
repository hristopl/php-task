<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
$host="localhost"; $username="root"; $password="";

$conn=new mysqli($host,$username,$password);

if($conn->connect_error) { die ("Connection failed:". $conn->connect_error."!");}
echo "Connected successfully!<br>";

$conn-> set_charset('utf8');

$fnumber = mysqli_real_escape_string($conn,$_REQUEST['fnumber']);
$first_name = mysqli_real_escape_string($conn,$_REQUEST['first_name']);
$last_name=mysqli_real_escape_string($conn,$_REQUEST['last_name']);
$kurs=mysqli_real_escape_string($conn,$_REQUEST['kurs']);
$uspeh=mysqli_real_escape_string($conn,$_REQUEST['uspeh']);

$sql = "CREATE DATABASE IF NOT EXISTS Uni COLLATE utf8_general_ci";
if($conn->query($sql) === TRUE) { echo "Database created successfully!<br>";}
else{ die("Error creating database: ".$conn->error);}

$sql="USE Uni";
if($conn->query($sql) === TRUE) {echo "Database selected successfully!<br>";}
else{ die("Error selecting database: ".$conn->error."!");}


$sql="CREATE TABLE IF NOT EXISTS Students (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
fnumber INT(10) NOT NULL,
first_name VARCHAR(30) NOT NULL,
last_name VARCHAR(30) NOT NULL,
kurs VARCHAR(30) NOT NULL,
uspeh FLOAT)";
if($conn->query($sql) === TRUE) {echo "Table Students created successfully!<br>";}
else{ die("Error creating table: ".$conn->error."!");}

$sql="INSERT INTO Students (fnumber, first_name, last_name, kurs, uspeh) VALUES
('$fnumber', '$first_name','$last_name','$kurs','$uspeh')";
if(mysqli_query($conn,$sql)){
    echo "Records added successfully.";
} else{
echo "ERROR: Could not insert into table $sql." .mysqli_error($conn);
}

//Извличане на всички записи от таблицата Students.
echo "<br> Всички записи са:<br>";
$sql="SELECT * FROM Students";
$result=$conn->query($sql);
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        echo $row["id"] . ": Фак. номер " . $row["fnumber"] . " - " . $row["first_name"] . " " . $row["last_name"] . " - " 
        . $row["kurs"] . ", " . ", успех " . $row["uspeh"] . " <br>";
    }
} else { echo "No results....<br>";}
// Успех над 4,50
echo "<br> Студенти с успех над 4,50 са:<br>";
$sql="SELECT * FROM Students WHERE uspeh > 4.5";
$result=$conn->query($sql);
if($result->num_rows > 0) {
    while ($row=$result->fetch_assoc()) {
        echo $row["id"] . ": Фак. номер " . $row["fnumber"] . " - " . $row["first_name"] . " " . $row["last_name"] . " - "
        . $row["kurs"] . ", " . ", успех " . $row["uspeh"] . " <br>";
    }
} else{ echo"No results...<br>";}
//Студенти от 2-ри курс
echo "<br> Студенти от 2ри курс са:<br>";
$sql="SELECT * FROM Students WHERE kurs = 2";
$result=$conn->query($sql);
if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
        echo $row["id"] . ": Фак. номер " . $row["fnumber"] . " - " . $row["first_name"] . " " . $row["last_name"] . " - "
        . $row["kurs"] . ", " . ", успех " . $row["uspeh"] . " <br>";
    }
} else { echo "No results....<br>"; }

//Студенти с четен факултетен номер

echo"<br> Студенти с четен факултетен номер са: <br>";
$sql="SELECT * FROM Students WHERE fnumber %2 = 0";
$result = $conn->query($sql);
if($result -> num_rows >0) {
    while($row = $result->fetch_assoc()) {
        echo $row["id"] . ": Фак. номер " . $row["fnumber"] . " - " . $row["first_name"] . " " . $row["last_name"] . " - "
        . $row["kurs"] . ", " . ", успех " . $row["uspeh"] . " <br>";
    }
} else {echo "No results...<br>";}

$conn->close();
?>
</body>
</html>
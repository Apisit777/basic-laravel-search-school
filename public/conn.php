<?php 

echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Id</th><th>Firstname</th><th>Lastname</th></tr>";

class TableRows extends RecursiveIteratorIterator {
  function __construct($it) {
    parent::__construct($it, self::LEAVES_ONLY);
  }

  function current() {
    return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
  }

  function beginChildren() {
    echo "<tr>";
  }

  function endChildren() {
    echo "</tr>" . "\n";
  }
}

// $servername = "HQ2DB07";
// $username = "product_master_db";
// $password = "zTr3h8eJCAdn2RGO9PMqk1bplH4E7jZI";
// $myDB = "product_master";

$servername = "localhost";
$username = "root";
$password = "";
$myDB = "laravel_product_master";

// $servername = "10.10.35.73";
// $username = "root";
// $password = "password";
// $myDB = "dealer_db";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$myDB", $username, $password);
  // $conn = new PDO("mysql:host=$servername;port=33306;dbname=$myDB", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";

  $stmt = $conn->prepare("SELECT * FROM com_customer_dl2_test");
  $stmt->execute();

  // set the resulting array to associative
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
    echo $v;
  }

} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}


?>
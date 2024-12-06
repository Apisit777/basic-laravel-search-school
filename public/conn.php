<?php 

echo "<style>
    table { border-collapse: collapse; width: 100%; margin-bottom: 10px; }
    th, td { border: 1px solid black; padding: 8px; text-align: left; }
    .pagination { display: flex; justify-content: space-between; align-items: center; margin-top: 10px; }
    .pagination a, .pagination span { padding: 5px 10px; margin: 0 2px; text-decoration: none; border: 1px solid #ddd; border-radius: 5px; }
    .pagination a:hover { background-color: #f0f0f0; }
    .pagination span.active { background-color: #007bff; color: white; border: 1px solid #007bff; }
</style>";

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

// Pagination variables
// $pageLength = 100; // Number of records per page
$pageLength = 1000; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page, default is 1
$page = max(1, $page); // Ensure page is at least 1
$offset = ($page - 1) * $pageLength; // Calculate offset

try {
    $conn = new PDO("mysql:host=$servername;dbname=$myDB", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Count total records
    $countStmt = $conn->prepare("SELECT COUNT(*) FROM com_customer_dl2_test");
    $countStmt->execute();
    $totalRecords = $countStmt->fetchColumn();
    $totalPages = ceil($totalRecords / $pageLength);

    // Fetch records with LIMIT and OFFSET
    $stmt = $conn->prepare("SELECT * FROM com_customer_dl2_test LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $pageLength, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    // Display records
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $records = $stmt->fetchAll();
    $start = $offset + 1;
    $end = min($offset + count($records), $totalRecords);

    foreach (new TableRows(new RecursiveArrayIterator($records)) as $k => $v) {
        echo $v;
    }

    echo "</table>";

    // Display summary and pagination links
    echo "<div class='pagination'>";
    echo "<span>Showing $start to $end of $totalRecords entries</span>";

    echo "<div>";
    if ($page > 1) {
        echo "<a href='?page=" . ($page - 1) . "'>Previous</a>";
    }
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $page) {
            echo "<span class='active'>$i</span>";
        } else {
            echo "<a href='?page=$i'>$i</a>";
        }
    }
    if ($page < $totalPages) {
        echo "<a href='?page=" . ($page + 1) . "'>Next</a>";
    }
    echo "</div>";

    echo "</div>";

    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
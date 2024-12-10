<?php
    echo "<style>
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .pagination { display: flex; justify-content: space-between; align-items: center; margin-top: 10px; }
        .pagination a, .pagination span { padding: 5px 10px; margin: 0 2px; text-decoration: none; border: 1px solid #ddd; border-radius: 5px; }
        .pagination a:hover { background-color: #f0f0f0; }
        .pagination span.active { background-color: #1F2226; color: white; border: 1px solid #007bff; }
    </style>";

    echo "<table>";
    echo "<tr><th>Number 0-9</th><th>Count</th><th>Total</th></tr>";

    class TableRows extends RecursiveIteratorIterator {
        // function __construct($it) {
        //     parent::__construct($it, self::LEAVES_ONLY);
        // }

        function current() {
            return "<td>" . parent::current() . "</td>";
        }

        function beginChildren() {
            echo "<tr>";
        }

        function endChildren() {
            echo "</tr>" . "\n";
        }
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $myDB = "laravel_product_master";

    $pageLength = 5; // Number of records per page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page, default is 1
    $page = max(1, $page); // Ensure page is at least 1
    $offset = ($page - 1) * $pageLength; // Calculate offset

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$myDB", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT 
                                            CONCAT(BRAND, ' = ', LEFT(product, 1)) AS `Number 0-9`, 
                                            COUNT(*) AS `Count`, 
                                            COUNT(*) AS `Total`
                                        FROM product1s_all
                                        WHERE product REGEXP '^[0-9]' 
                                        AND BRAND = 'op'
                                        GROUP BY BRAND, LEFT(product, 1)
                                        LIMIT :limit OFFSET :offset
                                    ");
        $stmt->bindValue(':limit', $pageLength, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $countStmt = $conn->prepare("SELECT COUNT(*) 
                                            FROM (SELECT LEFT(product, 1) 
                                                FROM product1s_all 
                                                WHERE product REGEXP '^[0-9]' AND BRAND = 'op' 
                                                GROUP BY LEFT(product, 1)) as subquery
                                        ");
        $countStmt->execute();
        $totalRecords = $countStmt->fetchColumn();
        $totalPages = ceil($totalRecords / $pageLength);

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach (new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k => $v) {
            echo $v;
        }
        echo "</table>";

        echo "<div class='pagination'>";
        echo "<span>Page $page of $totalPages</span>";
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
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
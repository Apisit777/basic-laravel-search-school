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



<!-- Code ของ Warehouse หน้า index(javascript) -->
<!-- Start ตัวที่ใช้งาน API Test filter-cards(Code อยู่ที่ public/conn.php(Route ต้องเปิด comment(Route::get('/filter-cards'))) -->
<!-- $(document).ready(function () {
            let currentPage = 1;
            const cardsPerPage = 8;
            let allData = [];
            const cardContainer = $('#cards-container');

            // Fetch data and initialize cards
            function fetchData(type = '') {
                const apiUrl = type
                    ? '{{ route('warehouse.filter.cards') }}' // Backend API with filter
                    : 'https://ins.schicher.com/api/users'; // Default API

                const requestOptions = type
                    ? {
                        method: 'GET',
                        data: { type },
                    }
                    : {
                        method: 'GET',
                        headers: {
                            'X-RapidAPI-Key': '7115427d56mshfff5805283a13cep190338jsn4bc3f4689eb8',
                            'X-RapidAPI-Host': 'ott-details.p.rapidapi.com',
                        },
                    };

                $.ajax(apiUrl, requestOptions)
                    .done((data) => {
                        // console.log("🚀 ~ fetchData ~ requestOptions:", requestOptions)
                        allData = data;
                        renderCards(currentPage);
                        renderPagination();
                    })
                    .fail(() => alert('Error fetching data'));
            }

            // Render cards for the current page
            function renderCards(page) {
                // console.log("🚀 Rendering cards with data:", allData);
                // cardContainer.empty();
                $('#cards-container').empty();
                const start = (page - 1) * cardsPerPage;
                const end = start + cardsPerPage;
                const pageData = allData.slice(start, end);

                pageData.forEach((item) => {
                    // console.log("Item:", item); // Debugging to see item structure
                    const name = item.name || 'Unknown Name';
                    const role = item.role || 'Unknown Role';
                    const imageUrl = item.imageurl || item.image || 'default-image-url.jpg'; // Replace with a fallback image if needed

                    const card = `
                        <div class="max-w-sm p-1 bg-[#eaeaea] dark:bg-[#292929] cursor-pointer rounded shadow-sm hover:shadow-lg hover:shadow-gray-400 dark:hover:shadow-lg dark:hover:shadow-gray-400 transition-shadow duration-300 ease-in-out">
                            <img src="${imageUrl}" alt="${name}" class="w-full h-32 object-cover">
                            <div class="p-4">
                                <h2 class="text-lg font-semibold mb-1 text-gray-900 dark:text-gray-100">${name}</h2>
                                <p class="text-sm text-gray-400 dark:text-gray-400 uppercase">${role}</p>
                            </div>
                            <div class="px-4 pb-4 flex items-center space-x-4 text-gray-500 dark:text-gray-300 base:text-xl sm:text-sm">
                                <div class="flex items-center space-x-1">
                                    <span>🔒</span>
                                    <span>CORS</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <span>🔒</span>
                                    <span>HTTPS</span>
                                </div>
                            </div>
                        </div>
                    `;
                    cardContainer.append(card);
                });

                updatePaginationControls();
            }

            // Render pagination
            function renderPagination() {
                $('#pagination-numbers').empty();
                const totalPages = Math.ceil(allData.length / cardsPerPage);
                const maxVisiblePages = 5; // You can adjust this value

                function addPageButton(page, isActive = false) {
                    const pageButton = `<button class="px-4 py-1 mb-2 sm:mb-0 ${isActive ? 'bg-[#303030] text-white' : 'bg-white text-gray-800 border border-gray-300'} rounded hover:bg-[#505050]" data-page="${page}">${page}</button>`;
                    $('#pagination-numbers').append(pageButton);
                }

                if (totalPages <= maxVisiblePages) {
                    // If total pages are less than max visible pages, show all
                    for (let i = 1; i <= totalPages; i++) {
                        addPageButton(i, i === currentPage);
                    }
                } else {
                    // Show first page
                    addPageButton(1, currentPage === 1);

                    // Show an ellipsis if currentPage is far from the first page
                    if (currentPage > 3) {
                        $('#pagination-numbers').append('<span class="px-2 text-black dark:text-white">...</span>');
                    }

                    // Show pages around the current page
                    let startPage = Math.max(2, currentPage - 1);
                    let endPage = Math.min(currentPage + 1, totalPages - 1);

                    for (let i = startPage; i <= endPage; i++) {
                        addPageButton(i, i === currentPage);
                    }

                    // Show an ellipsis if currentPage is far from the last page
                    if (currentPage < totalPages - 2) {
                        $('#pagination-numbers').append('<span class="px-2 text-black dark:text-white">...</span>');
                    }

                    // Show last page
                    addPageButton(totalPages, currentPage === totalPages);
                }

                // Add event listeners to page buttons
                $('#pagination-numbers button').click(function () {
                    const page = $(this).data('page');
                    currentPage = page;
                    renderCards(currentPage);
                    renderPagination();
                });
            }

            // Update pagination controls
            function updatePaginationControls() {
                const totalPages = Math.ceil(allData.length / cardsPerPage);
                $('#prev-btn').prop('disabled', currentPage === 1);
                $('#next-btn').prop('disabled', currentPage === totalPages);
            }

            // Pagination navigation buttons
            $('#prev-btn').click(function () {
                if (currentPage > 1) {
                    currentPage--;
                    renderCards(currentPage);
                    renderPagination();
                }
            });

            $('#next-btn').click(function () {
                const totalPages = Math.ceil(allData.length / cardsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderCards(currentPage);
                    renderPagination();
                }
            });

            // Filter cards by type
            $('#filter-select').on('change', function () {
                const type = $(this).val();
                fetchData(type);
            });

            // Initial fetch
            fetchData();
        }); -->
<!-- End ตัวที่ใช้งาน -->
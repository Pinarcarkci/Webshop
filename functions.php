<?php
//  Database Connection
$dbConnection = mysqli_connect("localhost", "root", "", "gameworld_db");

if (!$dbConnection) {
    die("Connection failed: " . mysqli_connect_error());
}



function HTMLhead($title = "Default Title") {
    echo "<!DOCTYPE html>\n<html lang='en'>\n<head>\n";
    echo "<meta charset='UTF-8'>\n";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
    echo "<meta name='' content=''>\n";
    echo "<title>" . (isset($title) ? $title : "Default Title") . "</title>\n";
    echo "<link rel='stylesheet' href='style.css'>\n";
    echo "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'> \n";
    echo "<link rel='preconnect' href='https://fonts.googleapis.com'>\n";
    echo "<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>\n";
    echo "<link href='https://fonts.googleapis.com/css2?family=Silkscreen:wght@400;700&display=swap' rel='stylesheet'>\n";
    echo "</head>\n<body>";
}




function displayNavbar($dbConnection) {
    $currentPage = basename($_SERVER['PHP_SELF']);
    $ids = [1, 2, 3, 4, 5, 8]; //deze kan je altijd zien

    if (isset($_SESSION["user"])) {
   
        $ids[] = 10; 
        $ids[] = 11; // als je bent ingelogd zie je deze
    } else {
        $ids[] = 9; // als je niet bent ingelogd zie je dit
    }

    $idList = implode(',', $ids);
    $query = "SELECT id, name, url FROM navbar WHERE status = 1 AND id IN ($idList) ORDER BY FIELD(id, $idList)";
    $result = mysqli_query($dbConnection, $query);

    if (!$result) {
        die("Database query failed: " . mysqli_error($dbConnection));
    }

    echo '<img src="logo.png" alt="Logo" class="logo">
        <div class="navbar-container">
        <nav>
            <ul class="nav-links">';

    while ($item = mysqli_fetch_assoc($result)) { 
        //loopt over alle rijen in $result, die je eerder kreeg via een query
        $activeClass = ($currentPage === basename($item['url'])) ? 'active' : '';
        //Controleert of het menu-item de pagina is waarop je nu bent
        $displayName = htmlspecialchars($item['name']);

        switch ($item['id']) {
            case 8:
                $displayName = '<i class="fa-solid fa-cart-shopping"></i>';
                break;
            case 9:
                $displayName = '<i class="fa-solid fa-user"></i>';
                break;
            case 10:
                $displayName = '<i class="fa-solid fa-heart"></i>';
                break;
            case 11:
                $displayName = '<i class="fa-solid fa-right-from-bracket"></i>';
                break;
        }

        echo '<li class="nav-item">
                <a href="' . htmlspecialchars($item['url']) . '" class="' . $activeClass . '">' . $displayName . '</a>
              </li>';
    }
    echo '    </ul>
            </nav>
        </div>';



        { echo "<div class='shooting-stars'>";
            echo "<div></div>";
            echo "<div></div>";
            echo "<div></div>";
            echo "<div></div>";
            echo "<div></div>";
            echo "<div></div>";
            echo "<div></div>";
            echo "<div></div>";
            echo "<div></div>";
            echo "<div></div>";
            echo "<div></div>";
            echo "<div></div>";
            echo "<div></div>";
            echo "<div></div>";
            echo "</div>"; 
        }
}




//  Get All Categories (for index.php)
function getCategories() {
    global $dbConnection;
    $sql = "SELECT * FROM categories";
    $result = $dbConnection->query($sql);
    return $result;
}



//  Get Products by Category (for products.php)
function getProductsByCategory($categoryId) {
    global $dbConnection;
    $sql = "SELECT * FROM products WHERE categoryId = ?";
    $stmt = $dbConnection->prepare($sql);

    if (!$stmt) {
        die("MySQL Prepare error: " . $dbConnection->error);
    }

    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        die("MySQL Query error: " . $stmt->error);
    }

    return $result;
}


//  Get All Products (for cases where no category filtering is required)
function getAllProducts() {
    global $dbConnection;
    $sql = "SELECT * FROM products";
    return $dbConnection->query($sql);
}


//  Get Category by ID (for Category Detail Page)
function getProductById($productId) {
    global $dbConnection;
    $stmt = $dbConnection->prepare("SELECT * FROM products WHERE productID = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result; 
}





// blog 

//get all blog categories
function getBlogCategories($conn) {
    $sql = "SELECT * FROM blogcategories";
    $result = mysqli_query($conn, $sql);
    $categories = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
    }
    return $categories;
}


// Get blog posts (optionally filtered by category)
function getBlogPosts($conn, $category_id = null) {
    $sql = "SELECT * FROM blog_posts";
    if ($category_id) {
        $sql .= " WHERE category_id = " . intval($category_id);
    }
    $sql .= " ORDER BY date DESC";

    $result = $conn->query($sql);
    $posts = [];
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
    return $posts;
}



function addBlogPost($db, $title, $author, $date, $category_id, $content) {
    $stmt = $db->prepare("INSERT INTO blog_posts (title, author, date, category_id, content) VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        return false;
    }

    $stmt->bind_param("sssds", $title, $author, $date, $category_id, $content);
    return $stmt->execute();
}

function getSinglePost($db, $id) {
    $stmt = $db->prepare("SELECT * FROM blog_posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}



// Footer Section
function HTMLfooter() {
    echo "<footer>";
    
   
   
    echo "<p class='p-made'>&copy; Game World - All Rights Reserved.</p>";
    
    // Check if the MySQL connection exists and close it
    if (isset($GLOBALS['dbConnection'])) {
        $GLOBALS['dbConnection']->close();
    }

    echo "</footer>";
}


?>




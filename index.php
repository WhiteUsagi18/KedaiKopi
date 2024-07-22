<?php
require('function.php');
session_start();

$userId = null;
$username = null;

// if(isset($_SESSION['idUser'])) {
//     $userId = $_SESSION['idUser'];

// }

if(isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $username = $_SESSION['username'];
    echo "<script>console.log('$username');</script>";
}
//Menu
function fetchMenu($conn) {
    $sql = "SELECT * FROM menu";
    $result = $conn->query($sql);
    return $result;
}

//Product
function fetchProduct($conn, $sql, $params = []) {
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        // Bind parameters if provided
        $types = str_repeat('s', count($params)); // Assuming all params are strings ('s')
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    
    return $result;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KedaiKopi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header class="header-main">
        <p class="navbar-logo">kedai<span>kopi</span>.</p>

        <div class="navbar-nav">
            <a href="#home">Home</a>
            <a href="#about">About</a>
            <a href="#ourMenu">Menu</a>
            <a href="#product">Product</a>
            <a href="#contact">Contact</a>
        </div>

        <div class="navbar-extra">
            <a href="#" id="search"><i data-feather="search"></i></a>
            <a href="#" id="cart">
                <i data-feather="shopping-cart"></i>
                <span class="quantity-badge">10</span>
            </a>
            <a href="#" id="user"><i data-feather="user"></i></a>
            <a href="#" id="menu"><i data-feather="menu"></i></a>
        </div>

        <!-- Search -->
        <form action="#product" class="search-form" id="search-form" method="GET">
            <input type="search" id="search-box" placeholder="Search" name="searchBox">
            <input type="submit" id="submit" style="display: none;">
            <label for="submit"><i data-feather="search"></i></label>
        </form>

        <!-- user profile -->
        <div class="profile">
            <?php 
            if(!$username) :
            ?>
            <div class="notLogin">
                <a href="login.php"><i data-feather="log-in" class="login-icon"></i><span>Go to Login</span></a>
            </div>
            <?php
            else :
            ?>
            <div class="haveLogin">
                <a href=""><i data-feather="user" class="login-icon"></i><span><?php echo $username; ?></span></a>
            </div>
            <div class="haveLogin">
                <a href="logout.php" ><i data-feather="log-out" class="login-icon"></i><span>Logout</span></a>
            </div>
            <?php
            endif;
            ?>
        </div>

        <!-- Shopping cart -->
        <div class="cart-form" id="cart-form">

        </div>
    </header>

    <section class="hero" id="home">
        <main class="content">
            <h1>Mari Menikmati Secawan <span>Kopi</span></h1>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloremque, voluptatibus?
            </p>
            <a href="#product" class="buy-btn">Buy Now</a>
        </main>
    </section>

    <section class="about" id="about">
        <h1><span>About</span> Us</h1>
        <main class="content">
            <img src="material/mike-kenneally-zlwDJoKTuA8-unsplash.jpg" alt="">
            <div class="text">
                <h3>Why must choose our coffee?</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis mollitia unde repellat dolores quo dolorum aut fuga nesciunt iure nulla distinctio iusto, porro eaque labore ipsum dolor aspernatur, nobis officia nemo incidunt ad iste rem laudantium provident! Pariatur alias in praesentium mollitia quam illo, sit fuga maiores rerum voluptas dolores.</p>
            </div>
        </main>
    </section>
    
    <section class="menu" id="ourMenu">
        <h1><span>Our</span> Menu</h1>
        <p class="desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda libero sed saepe quidem consequuntur odit nostrum quod dignissimos suscipit aspernatur?</p>
        <main class="content">
            <?php
            $menu = fetchMenu($conn);
                if($menu->num_rows > 0) :
                    while($row = $menu->fetch_assoc()) : ?>
            <div class="card-menu">
                <img src="<?php echo $row['image']; ?>" alt="">
                <h3>- <?php echo $row['name']; ?> -</h3>
            </div>
            <?php 
                endwhile;
            endif;
             ?>
            <!-- <div class="card-menu">
                <img src="material/jason-w-kSlL887znkE-unsplash.jpg" alt="">
                <h3>- Espresso -</h3>
            </div>
            <div class="card-menu">
                <img src="material/jason-w-kSlL887znkE-unsplash.jpg" alt="">
                <h3>- Espresso -</h3>
            </div>
            <div class="card-menu">
                <img src="material/jason-w-kSlL887znkE-unsplash.jpg" alt="">
                <h3>- Espresso -</h3>
            </div>
            <div class="card-menu">
                <img src="material/jason-w-kSlL887znkE-unsplash.jpg" alt="">
                <h3>- Espresso -</h3>
            </div> -->
        </main>
    </section>

    <section class="product" id="product">
        <h1><span>All</span> Products</h1>
        <p class="desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda libero sed saepe quidem consequuntur odit nostrum quod dignissimos suscipit aspernatur?</p>
        <main class="content">
        <?php 
        $limitPage = 5;
        $currentPage = isset($_GET['nr-page']) ? (int)$_GET['nr-page'] : 1;
        $startPage = ($currentPage - 1) * $limitPage;

        if(isset($_GET['searchBox']) && $_SERVER['REQUEST_METHOD'] == 'GET') :
            $name = $conn->real_escape_string($_GET['searchBox']);

            $sqlAll = "SELECT * FROM product WHERE name LIKE ?";
            $productsAll = fetchProduct($conn, $sqlAll, ["%$name%"]);
            $num_of_rows = $productsAll->num_rows;

            
            $sql = "SELECT * FROM product WHERE name LIKE ? LIMIT $startPage, $limitPage";
            $products = fetchProduct($conn, $sql, ["%$name%"]);
        else :
            $sqlAll = "SELECT * FROM product";
            $productsAll = $conn->query($sqlAll);
            $num_of_rows = $productsAll->num_rows;

            $sql = "SELECT * FROM product LIMIT $startPage, $limitPage";
            $products = fetchProduct($conn, $sql);
        endif;

        $pages = ceil($num_of_rows / $limitPage);

        if($products->num_rows > 0) :
            while($row = $products->fetch_assoc()) : ?>
        <div class="card-product">
            <div class="product-icons">
                <?php if($username) :
                ?>
                <a href="#" onclick="cart(<?php echo $row['id']; ?>, event)" id="shopping-cart"><i data-feather="shopping-cart"></i></a>
                <?php 
                else : 
                    ?>
                <a href="#" onclick="hideCart(event)" id="shopping-cart"><i data-feather="shopping-cart"></i></a>
                <?php
                endif; ?>
                <a href="#" onclick="viewItemDetails(<?php echo $row['id']; ?>, event)" id="view"><i data-feather="eye"></i></a>
            </div>
            <img src="<?php echo $row['image']; ?>" alt="">
            <h3><?php echo $row['name']; ?></h3>
            <div class="product-star">
                <?php 
                $total = 5;
                $rate = $row['rating'];
                $balance = $total - $rate;

                for($i=0; $i<$rate; $i++) :
                ?>
                <i data-feather="star" class="full-star"></i>
                <?php endfor;
                for($i=0; $i<$balance; $i++) :
                ?>
                <i data-feather="star" class="star"></i>
                <?php endfor; ?>
            </div>
            <p class="price">RM<?php echo $row['price']; ?></p>
        </div>
        <?php 
            endwhile;
        else :
            echo "No result found";
        endif;
            ?>

        </main>
        <div class="pagination">
            <?php if($currentPage > 1) { ?>
                <a href="?nr-page=<?php echo ($currentPage - 1); ?>#product"><i data-feather="chevron-left" class="che-left"></i></a>
            <?php } else { ?>
                <a><i data-feather="chevron-left" class="che-left-last"></i></a>
            <?php } ?>

            <p><?php echo $currentPage ?></p>
            
            <?php if($currentPage < $pages) { ?>
                <a href="?nr-page=<?php echo ($currentPage + 1); ?>#product"><i data-feather="chevron-right" class="che-right"></i></a>
            <?php } else { ?>
                <a><i data-feather="chevron-right" class="che-right-last"></i></a>
            <?php } ?>
        </div>
    </section>

    <section class="contact" id="contact">
        <h1><span>Contact</span> Us</h1>
        <p class="desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda libero sed saepe quidem consequuntur odit nostrum quod dignissimos suscipit aspernatur?</p>
        <main class="content">
            <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d254976.8946141435!2d101.35169559945031!3d3.0909375568210704!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4d8b932abdc7%3A0x6e65e085abb091c5!2sShah%20Alam%2C%20Selangor!5e0!3m2!1sen!2smy!4v1718014845354!5m2!1sen!2smy"
            width="600" height="450" style="border:0;" allowfullscreen=""
            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <div class="info">
                <h3><span>Shah Alam,</span>
                    <br>Selangor
                </h3>

                <div class="icon-info">
                    <div class="name">
                        <i data-feather="user"></i>
                        <p>Steward</p>
                    </div>
                    <div class="mail">
                        <i data-feather="mail"></i>
                        <p>kedaikopi@gmail.com</p>
                    </div>
                    <div class="tel">
                        <i data-feather="phone"></i>
                        <p>019-7326 364</p>
                </div>
                </div>
            </div>
        </main>
    </section>

    <footer>
        <i data-feather="twitter" class="sosmed"></i>
        <i data-feather="instagram" class="sosmed"></i>
        <i data-feather="facebook" class="sosmed"></i>
        <h3>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestias, amet.</h3>
        <h3>Created By Deli</h3>
    </footer>
    <!-- Complete Main -->

    <div class="modal" id="item-detail-modal">
        <div class="modal-container">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>

    <div class="bg-payment">
        <div class="container-payment">
            <h1>Payment Gateway Integration</h1>
            <form id="payment-form">
                <label for="card-number">Card Number:</label>
                <input type="text" id="card-number" placeholder="Enter your card number" required>
                
                <label for="expiry-date">Expiry Date:</label>
                <input type="text" id="expiry-date" placeholder="MM/YY" required>
                
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" placeholder="CVV" required>

                <button type="submit">Pay Now</button>
            </form>
            <div id="payment-status"></div>
        </div>
    </div>

    
    <script>
      feather.replace();
    </script>

    <script src="script.js"></script>
    
</body>
</html>
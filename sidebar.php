<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hamro Karobar Online System</title>
    <link rel="icon" type="image/png" href="Img/Logo1.jpg"/>
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>
<body>
    <div class="menu-btn">
        <i class="fas fa-bars"></i>
    </div>
    <div class="side-bar">
        <div class="logo">
            <img src="Img/Main.png" alt="Logo" srcset="">
        </div>
        <div class="close-btn">
            <i class="fas fa-times"></i>
        </div>
        <div class="menu">
            <div class="item"><a href="dashboard.php"><i class="fas fa-desktop"></i>Dashboard</a></div>
            <div class="item">
                <a class="sub-btn"><i class="fa-solid fa-cart-shopping"></i></i>Purchase<i class="fas fa-angle-right dropdown"></i></a>
                <div class="sub-menu">
                    <a href="add_purchase.php" class="sub-item"><i class="fa-solid fa-circle-plus"></i>Add</a>
                    <a href="return_purchase.php" class="sub-item"><i class="fa-solid fa-backward"></i>Return</a>
                </div>
            </div>
            <div class="item">
                <a class="sub-btn"><i class="fa-solid fa-gavel"></i></i>Sales<i class="fas fa-angle-right dropdown"></i></a>
                <div class="sub-menu">
                    <a href="add_sales.php" class="sub-item"><i class="fa-solid fa-circle-plus"></i>Add</a>
                    <!--<a id="s_return" class="sub-item"><i class="fa-solid fa-backward"></i>Return</a>-->
                </div>
            </div>
            <div class="item"><a href="stocks.php"><i class="fa-solid fa-database"></i>Stocks</a></div>
            <div class="item"><a href="expences.php"><i class="fa-solid fa-wallet"></i></i>Expanses</a></div>
            <div class="item"><a href="vender.php"><i class="fa-solid fa-store"></i>Vender</a></div>
            <div class="item"><a href="customer.php"><i class="fa-solid fa-users"></i>Customer</a></div>
        </div>
    </div>

    <section>
        <div class="nav-bar">
            <div class="name">
                <h1>Karobar Online</h1>
            </div>
            <div class="profile">
                <a class="sub-btn" id="user"><i class="fa-solid fa-user"></i> <?php echo $_SESSION['new']; ?></a>
                <div class="sub-menu">
                    <a href="profile.php" id="profile" class="sub-item"><i class="fa-solid fa-user"></i> Change Password</a><hr>
                    <a href="logout.php"class="sub-item"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a>
                </div>
            </div>
        </div>
    </section>

    <script>
        $('.sub-btn').click(function(){
                $(this).next('.sub-menu').slideToggle();
                $(this).find('.dropdown').toggleClass('rotate');
            });
        $('.menu-btn').click(function(){
                $('.side-bar').addClass('active');
                $('.menu-btn').css("visibility","hidden");
            });

        $('.close-btn').click(function(){
                $('.side-bar').removeClass('active');
                $('.menu-btn').css("visibility","visible");
            });
    </script>

</body>
</html>
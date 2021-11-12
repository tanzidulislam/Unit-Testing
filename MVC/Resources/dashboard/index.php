<?php

session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("location: ../index.php");
}
$name = $_SESSION['name'];
include "../config.php";
error_reporting(0);
$status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>   Welcome </strong> ' . $name . ' 
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>';

// add to session
if (isset($_POST['id']) && $_POST['id'] != "") {
    $code = $_POST['code'];
    $id = $_POST['id'];
    $sql3 = "SELECT * FROM products WHERE id ='$id'";
    $result3 = mysqli_query($conn, $sql3);
    $row = $result3->fetch_assoc();
    $name = $row['name'];
    $price = $row['price'];
    $quantity = $row['quantity'];
    $image = base64_encode($row['image']);

    $cartArray = array(
        $code => array(

            'id' => $id,
            'name' => $name,
            'code' => $code,
            'price' => $price,
            'quantity' => 1,
            'image' => $image
        )
    );
    if ($quantity > 0) {
        if (empty($_SESSION["shopping_cart"])) {
            $_SESSION["shopping_cart"] = $cartArray;
            $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>   Product is added to your cart! </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
        } else {
            $array_keys = array_keys($_SESSION["shopping_cart"]);
            if (in_array($code, $array_keys)) {

                $status = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>   Product is already added to your cart! </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
            } else {
                $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $cartArray);
                $status = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>   Product is added to your cart! </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
            }
        }
    } else {
        $status = '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>   Out Of Stock! </strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-book</title>
    <!-- icon -->
    <link rel="icon" href="../img/cart.png">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- zoom in animantion css -->
    <link href="../css/aos.min.css" rel="stylesheet">
    <!-- google font css-->
    <link href="../css/poppinsfont.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/exofont.min.css">
    <!-- iconfont css -->
    <link rel="stylesheet" href="../css/icofont/icofont.min.css">
    <!-- icons css css-->
    <link rel="stylesheet" href="../css/all.min.css">

    <!-- carousel css -->
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/owl.theme.default.min.css">
    <!-- magnatic popup -->
    <link rel="stylesheet" href="../Magnific-Popup/dist/magnific-popup.min.css">
    <!-- variable css -->
    <link rel="stylesheet" href="../css/variable1.min.css">

    <!-- sidebar css -->
    <link rel="stylesheet" href="../css/sidebar1.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="../css/style.min.css">
    <!-- resposive css -->
    <link rel="stylesheet" href="../css/responsive.min.css">
</head>

<body>

    <!-- side bar -->

    <section>
        <div class="container d-flex align-items-center justify-content-around">

            <nav class="nav-menu d-none d-lg-block">
                <div class="logo text-center">
                    <img src="../img/cart.png" alt="" class="img-fluid"><span>e-book</span>
                </div>
                <hr>
                <?php
                include "./sidebar.php";
                ?>

            </nav>

        </div>


        <?php
        $id = $_SESSION['id'];

        $sql = "SELECT * FROM user WHERE id ='$id'";
        $result = mysqli_query($conn, $sql);
        while ($row = $result->fetch_assoc()) {

        ?>

            <!-- main body -->
            <main class="site-main main">
                <!-- incharge info area -->
                <div class="container info text-right">
                    <div>
                        <p>
                            <?php
                            if ($row['pic'] == '') {
                                echo '<a class="test-popup-link" href="../img/person.png"><img src="../img/person.png"/></a>';
                            } else {
                                echo '<a class="test-popup-link" href="data:image/jpeg;base64,' . base64_encode($row['pic']) . '"><img src="data:image/jpeg;base64,' . base64_encode($row['pic']) . '"/></a>';
                            }

                            ?>
                            <?php echo "Welcome " . $_SESSION['name'] ?>
                        </p>

                        <hr>
                    </div>
                </div>
            <?php

        }
            ?>

            <!-- cart -->



    </section>
    <section class="main">

        <div class="container">
            <!-- <div style="clear:both;"></div> -->
            <!-- mesaage box -->
            <div class="message_box">
                <?php echo $status; ?>
            </div>
            <!-- cout at cart -->
            <?php
            $cart_count = 0;
            if (!empty($_SESSION["shopping_cart"])) {

                $cart_count = count(array_keys($_SESSION["shopping_cart"]));
            }
            ?>
            <div class="row my-2">
                <div class="col-lg-12 col-md-12">
                    <div class="cart_div">
                        <a href="./cart.php"><img src="../img/cart-icon.png" /> Cart
                            <span><?php echo $cart_count; ?></span></a>
                    </div>
                </div>

            </div>


            <!-- show product -->
            <div class="row">
                <?php
                $sql2 = "SELECT * FROM products";
                $result2 = mysqli_query($conn, $sql2);
                while ($row = $result2->fetch_assoc()) {
                    echo '<div class="col-lg-2 col-md-2 text-center product_wrapper mr-lg-3 mr-md-3 my-1">
                <form method="post" action="">
                <input type="hidden" name="code" value="' . $row['code'] . '" />
                <input type="hidden" name="id" value="' . $row['id'] . '" />
                <div class="image"><img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '"
                        class="img-fluid" />
                    <div class="name text-capitalize">' . $row['name'] . '</div>
                    <div class="price">&#2547;' . $row['price'] . '</div>
                    <div class="price"><span class="name">Quantity - </span>' . $row['quantity'] . '</div>
                    <button type="submit" class="buy btn btn-warning text-capitalize">add to cart</button>
                </div>
            </form>
        </div>';
                }
                mysqli_close($con);
                ?>
            </div>

        </div>
    </section>

    </main>
    <?php
    include './footer.php';
    ?>

    <!-- gotop -->
    <div class="container-fluid"><a class="gotop" href="#"><i class="fas fa-level-up-alt"></i></a></div>

    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.easing.min.js"></script>
    <script type="text/javascript">
        windo
        w.addEventListener("scroll", function() {
            // var header = document.querySelector("section");
            // header.classList.toggle("sticky", window.scrollY > 0);
            var gotop = document.querySelector(".gotop");
            gotop.classList.toggle("gotopbutton", window.scrollY > 0);
        });
        $(function() {

            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
    <script src="../js/aos.min.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../Magnific-Popup/dist/jquery.magnific-popup.min.js"></script>
    <script src="../js/header.min.js"></script>
    <script src="../js/alert.min.js"></script>
    <script src="../js/index.js"></script>
</body>

</html>
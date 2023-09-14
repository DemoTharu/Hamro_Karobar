<?php
    session_start();
    if (!isset($_SESSION['new'])) {
        header("Location: index.php");
    }
    else {
    include "sidebar.php";
    require "database/database.php";
        $vender = "SELECT COUNT(V_Name) As Vendor FROM vender";
        $vens = $con->query($vender);
        $customer = "SELECT COUNT(C_Name) As Customer FROM customer";
        $cuss = $con->query($customer);
        $purchase = "SELECT SUM(P_Qty*P_Rate) As Total, COUNT(V_Name) As Stock FROM purchase WHERE P_Return = 0";
        $purs = $con->query($purchase);
        $sale = "SELECT SUM(S_Qty*S_Rate) As STotal FROM sales";
        $sas = $con->query($sale);
        $expense = "SELECT SUM(E_Amt) As Amt FROM expense";
        $exps = $con->query($expense);

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <section>
            <div class="maind">
                <div class="maind-content" id="main-content">
                    <h4>Dashboard</h4>
                    <div class="dash-box">
                        <div class="itemsd purchased">
                            <div class="icond">
                                <img src="Img/purchase.png" alt="Purchase">
                            </div>
                            <div class="purd">
                            <?php
                                    while($rowe = mysqli_fetch_array($purs)){
                                    ?>
                                    <h4><?php echo $rowe['Total']; ?></h4>
                                    <p>Purchases</p>
                            </div>
                        </div>
                        <div class="itemsd saled">
                            <div class="icond">
                                <img src="Img/Sale.png" alt="Sales">
                            </div>
                            <div class="purd">
                            <?php
                                    while($rows = mysqli_fetch_array($sas)){
                                    ?>
                                    <h4><?php echo $rows['STotal']; ?></h4>
                                    <p>Services and Sales</p>
                            </div>
                        </div>
                        <div class="itemsd venderd">
                            <div class="icond">
                                <img src="Img/Saller.png" alt="Sales">
                            </div>
                            <div class="purd">
                            <?php
                                while($row = mysqli_fetch_array($vens)){
                            ?>
                                <h4><?php echo $row['Vendor']; ?></h4>
                            <?php
                                }
                            ?>
                            <p>Vendors</p>
                            </div>
                        </div>
                        <div class="itemsd customerd">
                            <div class="icond">
                                <img src="Img/Customer.png" alt="Sales">
                            </div>
                            <div class="purd">
                            <?php
                                    while($row = mysqli_fetch_array($cuss)){
                                    ?>
                                    <h4><?php echo $row['Customer']; ?></h4>
                                    <?php
                                    }
                                    ?>
                                    <p>Customers</p>
                            </div>
                        </div>
                        <div class="itemsd totald">
                            <div class="icond">
                                <img src="Img/Profit.png" alt="Sales">
                            </div>
                            <div class="purd">
                                <h4><?php echo $rows['STotal']-$rowe['Total']; ?></h4>
                                <p>Total</p>
                            </div>
                        </div>
                        <div class="itemsd expd">
                            <div class="icond">
                                <img src="Img/spending.png" alt="Sales">
                            </div>
                            <div class="purd">
                            <?php
                                    while($row = mysqli_fetch_array($exps)){
                                    ?>
                                    <h4><?php echo $row['Amt']; ?></h4>
                                    <?php
                                    }
                                    ?>
                                <p>Expenses</p>
                            </div>
                        </div>
                        <div class="itemsd stockd">
                            <div class="icon">
                                <img src="Img/warehouse.png" alt="Sales">
                            </div>
                            <div class="purd">
                                <h4><?php echo $rowe['Stock']; ?></h4>
                                <p>Stocks</p>
                            </div>
                        </div>
                        <?php
                                    }
                             }
                            ?>
                    </div>
                </div>
            </div>
        </section>
    </section>
</body>
</html>
<?php
    session_start();
    if (!isset($_SESSION['new'])) {
        header("Location: index.php");
    }
    else {
    require "sidebar.php";
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
<div id="toastBox"></div>
        <div class="main">
            <div class="main-content" id="main-content">
            <h4>Purchase Return</h4>
                <div class="boxes">
                <div class="btn">
                            <h5>Details</h5>
                        </div>
                    <div class="tbl" id="tbl">
                        <table>
                            <thead>
                                <tr class="cen">
                                    <td class="bichma">S.N</td>
                                    <td>Purchase Date</td>
                                    <td>Return Date</td>
                                    <td>Return To</td>
                                    <td>Product Name</td>
                                    <td>Qty</td>
                                    <td>Rate</td>
                                    <td>Total</td>
                                    <td>Reason of Return</td>
                                </tr>
                            </thead>
                            <tbody id="response">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function(){
            /*Data Retrival*/
            function showdata(){
                output = "";
                $.ajax({
                    url: "purchase/p_form.php",
                    method: "POST",
                    dataType: "json",
                    success: function(data){
                        //console.log(data.Total);
                       let count = 1;
                       let total2 = 0;
                        for(i=0;i<data.length;i++){
                           total = data[i].P_Qty*data[i].P_Rate - data[i].P_Dis;
                            output += "<tr><td style='text-align:center;'>" + count + "</td><td>" + data[i].Date + "</td><td>" + data[i].Return_Date + "</td><td>" + data[i].V_Name + "</td><td>" + data[i].P_Name + "</td><td style='text-align:center;'>" + data[i].P_Qty + "</td><td style='text-align:right;'>" + data[i].P_Rate + "</td><td style='text-align:right;'>" + total + "</td><td>" + data[i].Reason + "</td></tr>";
                        count++;
                        total2 += total;
                        }
                        $("#response").html(output);
                        $("#response").append("<tr><td colspan='7' style='text-align: right;'><strong>Total Return : </strong></td><td style='text-align:right'><strong>" + total2 + "</strong></td><td></td></tr>");
                    }
                })
            }
            showdata();
        });
    </script>
</body>
</html>
<?php
    session_start();
    if (!isset($_SESSION['new'])) {
        header("Location: index.php");
    }
    else {
    require "sidebar.php";
    require "database/database.php";
    $select = "SELECT * FROM customer";
    $result = $con->query($select);
    $select = "SELECT * FROM customer";
    $results = $con->query($select);
    $select = "SELECT * FROM customer";
    $res = $con->query($select);
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
                <h4>Sales Information</h4>
                <div class="boxes">
                    <div class="btn">
                            <h5>Details</h5>
                            <button class="add-more-form" onclick="toggle()"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    <div class="s_details" id="s_details">
                        <form id="customerdata" action="" method="post">
                                <div class="insert">
                                    <div class="sale">
                                        <div class="sales-info" id="info">
                                            <div class="names">
                                                <label for="">Customer Name</label>
                                                <select name="C_Name[]" id="Customer" required><option value="">---- Select Option ----</option><?php while($rows = $results->fetch_object()){ ?><option value="<?php echo $rows->C_Name; ?>"><?php echo $rows->C_Name; ?></option><?php } ?></select>
                                            </div>
                                            <div class="add">
                                                <label for="">Particular</label>
                                                <input type="text" name="S_Name[]" required>
                                            </div>
                                            <div class="qty">
                                                <label for="">Quantity</label>
                                                <input type="text" name="S_Qty[]" required>
                                            </div>
                                            <div class="rate">
                                                <label for="">Rate</label>
                                                <input type="text" name="S_Rate[]" required>
                                            </div>
                                            <div class="discount">
                                                <label for="">Discount</label>
                                                <input type="text" name="S_Dis[]" required>
                                            </div>
                                            <div class="status">
                                                <label for="">Status</label>
                                                <select name="S_Stats[]" required>
                                                    <option value="">--Status--</option>
                                                    <option value="Paid">Paid</option>
                                                    <option value="Pending">Pending</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="s_btns bt">
                                        <input type="submit" class="btn1" value="Submit" name="submit">
                                    </div>
                                </div>
                        </form>  
                        <form id="customerdatas" action="" method="post">
                              <div class="edits">
                                    <div class="sales">
                                        <div class="sales-info sa" id="info">
                                            <input type="text" id="cusid" style="display:none;">
                                            <div class="date">
                                                <label for="">Date</label>
                                                <input type="date" name="Date" required id="Date">
                                            </div>    
                                            <div class="names">
                                                <label for="">Customer Name</label>
                                                <select name="C_Name" id="C_Name" required><option value="">---- Select Option ----</option><?php while($row = $res->fetch_object()){ ?><option value="<?php echo $row->C_Name; ?>"><?php echo $row->C_Name; ?></option><?php } ?></select>
                                            </div>
                                            <div class="add">
                                                <label for="">Particular</label>
                                                <input type="text" name="S_Name" required id="S_Name">
                                            </div>
                                            <div class="qty">
                                                <label for="" class="bichma">Qty</label>
                                                <input type="text" name="S_Qty" required id="S_Qty">
                                            </div>
                                            <div class="rate">
                                                <label for="" class="bichma">Rate</label>
                                                <input type="text" name="S_Rate" required id="S_Rate">
                                            </div>
                                            <div class="discount">
                                                <label for="" class="bichma">Dis</label>
                                                <input type="text" name="S_Dis" required id="S_Dis">
                                            </div>
                                            <div class="status">
                                                <label for="">Status</label>
                                                <select name="S_Stats" required id="S_Stats">
                                                    <option value="">--Status--</option>
                                                    <option value="Paid">Paid</option>
                                                    <option value="Pending">Pending</option>
                                                </select>
                                            </div>
                                            <div class="s_btnas">
                                                <input type="button" class="btn2" value="Cancel" name="cancel">
                                            </div>
                                            <div class="s_btns bu">
                                                <input type="submit" class="btn1" value="Submit" name="submit" id="update">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                    <div class="s_sear" id="sear">
                        <div class="search">
                            <input type="search" id="txt" style="width:250px;">
                            <input type="button" value="Search" id="search" style="background-color: lightblue;color: black;">
                        </div>
                    </div>
                    <div class="tbl" id="tbl">
                        <table>
                            <thead>
                                <tr class="cen">
                                    <td>S.N</td>
                                    <td>Date</td>
                                    <td>Customer Name</td>
                                    <td>Particular</td>
                                    <td>Qty</td>
                                    <td>Rate</td>
                                    <td>Dis</td>
                                    <td>Total</td>
                                    <td>Status</td>
                                    <td colspan="3" style="text-align: center;">Action</td>
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
            showdata();
            function showdata(){
                output = "";
                $.ajax({
                    url: "sale/sale_retrive.php",
                    method: "POST",
                    dataType: "json",
                    success: function(data){
                        //console.log(data.Total);
                       let count = 1;
                       let total2 = 0;
                        for(i=0;i<data.length;i++){
                           total = data[i].S_Qty*data[i].S_Rate - data[i].S_Dis;
                            output += "<tr><td style='text-align:center;'>" + count + "</td><td>" + data[i].Date + "</td><td>" + data[i].C_Name + "</td><td>" + data[i].S_Name + "</td><td style='text-align:center;'>" + data[i].S_Qty + "</td><td style='text-align:right;'>" + data[i].S_Rate + "</td><td style='text-align:right;'>" + data[i].S_Dis + "</td><td style='text-align:right;'>" + total + "</td><td class='dan'>" + data[i].S_Status + "</td><td style='text-align:center;'><a class='ed' title='Edit' data-id=" + data[i].SN + "><img src='Img/edit.png' alt='Edit'></a></td><td style='text-align:center;'><a class='del' title='Delete' data-id=" + data[i].SN + "><img src='Img/bin.png' alt='Delete'></a></td></tr>";
                        count++;
                        total2 += total;
                        }
                        $("#response").html(output);
                        $("#response").append("<tr><td colspan='7' style='text-align: right;'><strong>Total Purchase : </strong></td><td style='text-align:right'><strong>" + total2 + "</strong></td><td></td><td></td><td></td></tr>");
                    }
                })
            }


            //Insert Data
            $(document).on('click','.add-more-form', function(){
                $('.sale').append('<div class="sales-info append-item" id="info">\
                    <input type="text" id="cusid" style="display:none;">\
                        <div class="names">\
                            <label for="">Customer Name</label>\
                            <select name="C_Name[]" id="Customer" required><option value="">---- Select Option ----</option><?php while($rows = $result->fetch_object()){ ?><option value="<?php echo $rows->C_Name; ?>"><?php echo $rows->C_Name; ?></option><?php } ?></select>\
                        </div>\
                        <div class="add">\
                            <label for="">Particular</label>\
                            <input type="text" name="S_Name[]" required>\
                        </div>\
                        <div class="qty">\
                            <label for="">Quantity</label>\
                            <input type="text" name="S_Qty[]" required>\
                        </div>\
                        <div class="rate">\
                            <label for="">Rate</label>\
                            <input type="text" name="S_Rate[]" required>\
                        </div>\
                        <div class="discount">\
                            <label for="">Discount</label>\
                            <input type="text" name="S_Dis[]" required>\
                        </div>\
                        <div class="status">\
                            <label for="">Status</label>\
                            <select name="S_Stats[]" required>\
                                <option value="">--Status--</option>\
                                <option value="Paid">Paid</option>\
                                <option value="Pending">Pending</option>\
                            </select>\
                        </div>\
                        <div class="ss_btns">\
                            <img class="remove" src="Img/bin.png" alt="delete" srcset="" title="Remove">\
                         </div>\
                    </div>');
                    $('.sales-info').css("grid-template-columns","1fr 1fr 0.3fr 0.3fr 0.3fr 0.5fr 0.1fr");
                });
                $(document).on('click','.remove',function(){
                    $("#customerdata")[0].reset();
                    $(this).closest('.sales-info').remove();
                });
                $("#customerdata").submit(function(e){
                    e.preventDefault();
                    $.ajax({
                        url: "sale/sale_insert.php",
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(msg){
                            console.log(msg);
                            let toastBox = document.getElementById('toastBox');
                            let toast = document.createElement('div');
                            toast.classList.add('toast');
                            toast.innerHTML = msg;
                            toastBox.appendChild(toast);

                            if (msg.includes('error')) {
                                toast.classList.add('error');
                            }
                            if (msg.includes('Empty')) {
                                toast.classList.add('invalid');
                            }

                            setTimeout(()=>{
                                toast.remove();
                            },3000);

                            $("#customerdata")[0].reset();
                            $(".append-item").remove();
                            showdata();
                                }
                    });
                });
                $(document).on('click','.btn2',function(){
                    $('.bt').css("display","");
                    $('.s_btns').css("grid-column","");
                    $('.sale').css("display","grid");
                    $('.edits').css("display","none");
                    $("#customerdata")[0].reset();
                    
                });

                //Update Data

                $("#update").click(function(e){
            e.preventDefault();
            console.log('Update Button Clicked');
            let id = $("#cusid").val();
            let date = $("#Date").val();
            let cname = $("#C_Name").val();
            let sname = $("#S_Name").val();
            let qty = $("#S_Qty").val();
            let rate = $("#S_Rate").val();
            let dis = $("#S_Dis").val();
            let stats = $("#S_Stats").val();
            mydata = {id:id,date:date,cname:cname,sname:sname,qty:qty,rate:rate,dis:dis,stats:stats};
            $.ajax({
                url:"sale/s_update.php",
                method: "POST",
                data: JSON.stringify(mydata),
                success: function(msg){
                    console.log(msg);
                    let toastBox = document.getElementById('toastBox');
                    let toast = document.createElement('div');
                    toast.classList.add('toast');
                    toast.innerHTML = msg;
                    toastBox.appendChild(toast);

                    if (msg.includes('error')) {
                        toast.classList.add('error');
                    }
                    if (msg.includes('Empty')) {
                        toast.classList.add('invalid');
                    }

                    setTimeout(()=>{
                        toast.remove();
                    },3000);
                    $('.bt').css("display","");
                    $('.s_btns').css("grid-column","");
                    $('.sale').css("display","grid");
                    $('.edits').css("display","none");
                    $("#customerdatas")[0].reset();
                    showdata();
                },
            })
        });

                 //Editng Data
        $("tbody").on("click", ".ed", function(){
            console.log("Edit button");
            $('.bt').css("display","none");
            $('.s_btns').css("grid-column","7/8");
            $('.sale').css("display","none");
            $('.edits').css("display","grid");
            $('.sa').css("grid-template-columns","0.1fr 0.6fr 0.6fr 0.2fr 0.2fr 0.2fr 0.3fr")
            let id = $(this).attr("data-id");
            console.log(id);
            mydata = {id:id};
            console.log(mydata);
            $.ajax({
                url: "sale/s_edit.php",
                method: "POST",
                dataType: "json",
                data: JSON.stringify(mydata),
                success: function(data){
                    console.log(data);
                    $("#cusid").val(data.SN);
                    $("#Date").val(data.Date);
                    $("#C_Name").val(data.C_Name);
                    $("#S_Name").val(data.S_Name);
                    $("#S_Qty").val(data.S_Qty);
                    $("#S_Rate").val(data.S_Rate);
                    $("#S_Dis").val(data.S_Dis);
                    $("#S_Stats").val(data.S_Status); 
                },
            });
        });

        //For Search
        $("#search").click(function(){
            outputs = "";
            let input = $("#txt").val();
            mydata = {input:input};
            console.log(mydata)
            if(input != ""){
                $.ajax({
                    url: "sale/s_search.php",
                    method: "POST",
                    dataType: "json",
                    data: mydata,
                    success: function(data){
                        console.log(data);
                        let count = 1;
                        let total2 = 0;
                        for(i=0;i<data.length;i++){
                            total = data[i].S_Qty*data[i].S_Rate - data[i].S_Dis;
                            outputs += "<tr><td style='text-align:center;'>" + count + "</td><td>" + data[i].Date + "</td><td>" + data[i].C_Name + "</td><td>" + data[i].S_Name + "</td><td style='text-align:center;'>" + data[i].S_Qty + "</td><td style='text-align:right;'>" + data[i].S_Rate + "</td><td style='text-align:right;'>" + data[i].S_Dis + "</td><td style='text-align:right;'>" + total + "</td><td class='dan'>" + data[i].S_Status + "</td><td style='text-align:center;'><a class='ed' title='Edit' data-id=" + data[i].SN + "><img src='Img/edit.png' alt='Edit'></a></td><td style='text-align:center;'><a class='del' title='Delete' data-id=" + data[i].SN + "><img src='Img/bin.png' alt='Delete'></a></td></tr>";
                        count++;
                        total2 += total;
                        }
                        $("#response").html(outputs);
                        $("#response").append("<tr><td colspan='7' style='text-align: right;'><strong>Total Purchase : </strong></td><td style='text-align:right'><strong>" + total2 + "</strong></td><td></td><td></td><td></td></tr>");
                    }
                });
            }
            else{
                $.ajax({
                    url: "vender/v_search.php",
                    method: "POST",
                    success: function(data){
                        let toastBox = document.getElementById('toastBox');
                    let toast = document.createElement('div');
                    toast.classList.add('toast');
                    msg = "<i class='fa-solid fa-circle-xmark'></i> Fill the Search Input";
                    toast.innerHTML = msg;
                    toastBox.appendChild(toast);

                    if (msg.includes('error')) {
                        toast.classList.add('error');
                    }
                    if (msg.includes('Search')) {
                        toast.classList.add('invalid');
                    }

                    setTimeout(()=>{
                        toast.remove();
                    },3000);
                showdata();
                    }
                });
            }
        });
        //For Delete
        $("tbody").on("click", ".del", function(){
            console.log("Delete button");
            let id = $(this).attr("data-id");
            mydata = {id:id};
            mythis = this;
            $.ajax({
                url: "sale/s_delete.php",
                method: "POST",
                data: JSON.stringify(mydata),
                success: function(data){
                    let toastBox = document.getElementById('toastBox');
                    let toast = document.createElement('div');
                    toast.classList.add('toast');
                    if(data == 1){
                        msg = "<i class='fa-solid fa-circle-check'></i> Delete Successfully";
                        toast.innerHTML = msg;
                        toastBox.appendChild(toast);

                        setTimeout(()=>{
                            toast.remove();
                        },3000);
                        showdata();
                    }
                    else if(data == 0){
                        msg = "<i class='fa-solid fa-circle-exclamation'></i> Unable to Delete";
                        toast.innerHTML = msg;
                        toastBox.appendChild(toast);
                        if (msg.includes('Unable')) {
				        toast.classList.add('error');
                        }
                        setTimeout(()=>{
                            toast.remove();
                        },3000);
                    }
                },
            });
        })
    });

    </script>
</body>
</html>
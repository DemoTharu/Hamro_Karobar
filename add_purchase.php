<?php
    session_start();
    if (!isset($_SESSION['new'])) {
        header("Location: index.php");
    }
    else {
    require "sidebar.php";
    require "database/database.php";
    $select = "SELECT * FROM vender";
    $result = $con->query($select);
    $select = "SELECT * FROM vender";
    $results = $con->query($select);
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
                <h4>Purchase Information</h4>
                <div class="boxes">
                    <div class="btn">
                            <h5>Details</h5>
                            <button class="add-more-form" onclick="toggle()"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    <div class="p_details" id="p_details">
                        <form id="customerdata" action="p_insert.php" method="post">
                            <div class="venders-main" id="info">
                                
                            </div>
                            <div class="butns">
                                <div class="but1">
                                    <input type="button" class="btn2" value="Cancel" onclick="closes()">
                                </div>
                                <div class="but">
                                    <input type="submit"  id="submit" class="btn1" value="Submit" name="submit">
                                </div>
                                <div class="but2">
                                    <input type="submit"  id="return" class="btn1" value="Return" name="return">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="sear" id="sear">
                        <div class="search">
                            <input type="search" id="txt" style="width:250px;">
                            <input type="button" value="Search" id="search" style="background-color: lightblue;color: black;">
                        </div>
                    </div>
                    <div class="tbl" id="tbl">
                        <table>
                            <thead>
                                <tr>
                                    <td>S.N</td>
                                    <td>Date</td>
                                    <td>Vender Name</td>
                                    <td>Buying Product</td>
                                    <td style="text-align:center">Qty</td>
                                    <td style="text-align:center">Rate</td>
                                    <td style="text-align:center">Dis</td>
                                    <td style="text-align:center">Total</td>
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
            function showdata(){
                output = "";
                $.ajax({
                    url: "purchase/p_retrive.php",
                    method: "POST",
                    dataType: "json",
                    success: function(data){
                        //console.log(data.Total);
                       let count = 1;
                       let total2 = 0;
                        for(i=0;i<data.length;i++){
                           total = data[i].P_Qty*data[i].P_Rate - data[i].P_Dis;
                            output += "<tr><td style='text-align:center;'>" + count + "</td><td>" + data[i].Date + "</td><td>" + data[i].V_Name + "</td><td>" + data[i].P_Name + "</td><td style='text-align:center;'>" + data[i].P_Qty + "</td><td style='text-align:right;'>" + data[i].P_Rate + "</td><td style='text-align:right;'>" + data[i].P_Dis + "</td><td style='text-align:right;'>" + total + "</td><td style='text-align:center;'><a class='ed' title='Edit' data-id=" + data[i].SN + "><img src='Img/edit.png' alt='Edit'></a></td><td style='text-align:center;'><a class='return' title='Return' data-id=" + data[i].SN + "><img src='Img/return.png' alt='Return'></a></td><td style='text-align:center;'><a class='del' title='Delete' data-id=" + data[i].SN + "><img src='Img/bin.png' alt='Delete'></a></td></tr>";
                        count++;
                        total2 += total;
                        }
                        $("#response").html(output);
                        $("#response").append("<tr><td colspan='7' style='text-align: right;'><strong>Total Purchase : </strong></td><td style='text-align:right'><strong>" + total2 + "</strong></td><td></td><td></td><td></td></tr>");
                    }
                })
            }
            showdata();

//On click Submit button
            $("#submit").click(function(e){
            e.preventDefault();
            console.log('Submit Button Clicked');
            let id = $("#cusid").val();
            let vender = $("#Vender").val();
            let dates = $("#Dates").val();
            let name = $("#P_Name").val();
            let qty = $("#P_Qty").val();
            let rate = $("#P_Rate").val();
            let dis = $("#P_Dis").val();
            console.log(id);
            mydata = {id:id,dates:dates,vender:vender,name:name,qty:qty,rate:rate,dis:dis};
            $.ajax({
                url:"purchase/p_insert.php",
                method: "POST",
                data: JSON.stringify(mydata),
                success: function(msg){
                    console.log(msg);
                    closes();
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
                    showdata()
                },
            })
        });


        //For Delete
        $("tbody").on("click", ".del", function(){
            console.log("Delete button");
            let id = $(this).attr("data-id");
            mydata = {id:id};
            mythis = this;
            $.ajax({
                url: "purchase/p_delete.php",
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

        //For Return9807413047
       /$("tbody").on("click", ".return", function(){
            console.log("Return button");
            let id = $(this).attr("data-id");
            mydata = {id:id};
            console.log(mydata);
            $.ajax({
                url: "purchase/p_return.php",
                method: "POST",
                dataType: "json",
                data: JSON.stringify(mydata),
                success: function(data){
                    console.log(data);
                    console.log(data.V_Name);
                    $("#cusid").val(data.SN);
                    $("#Dates").val(data.Date);
                    $("#Venders").val(data.V_Name);
                    $("#P_Name").val(data.P_Name);
                    $("#P_Qty").val(data.P_Qty);
                    $("#P_Rate").val(data.P_Rate);
                    $("#P_Dis").val(data.P_Dis);
                    boxes.classList.add('open');
                    
                },
            });
            $('.butns').css("display","flex");
            $('.venders-main').append('<div class="venders-info" id="info">\
                <div class="names">\
                    <label for="">Return To</label>\
                    <input type="text" name="c_name" disabled value="" id="Venders">\
                </div>\
                <div class="parti">\
                    <label for="">Product Name</label>\
                    <input type="text" name="P_Name" disabled value="" id="P_Name">\
                </div>\
                <div class="qty">\
                    <label for="">Quantity</label>\
                    <input type="text" name="P_Qty" disabled value="" id="P_Qty">\
                </div>\
                <div class="rate">\
                    <label for="">Rate</label>\
                    <input type="text" name="P_Rate" disabled value="" id="P_Rate">\
                </div>\
                <div class="rate">\
                    <label for="">Reason of Return</label>\
                    <textarea id="Return" name="w3review" rows="3" cols="40" required></textarea>\
                </div>\
            </div>')
            $('.venders-info').css("grid-template-columns","1fr 1fr 1fr");
            $('.but').css("display","none");
            $('.but2').css("display","grid");

            //On click Return Button
        $("#return").click(function(e){
            e.preventDefault();
            console.log('Return Button Clicked');
            let returns = $("#Return").val();
            console.log(returns);
            console.log(id);
            mydata = {id:id,returns:returns};
            $.ajax({
                url:"purchase/p_return_insert.php",
                method: "POST",
                data: JSON.stringify(mydata),
                success: function(data){
                    let toastBox = document.getElementById('toastBox');
                    let toast = document.createElement('div');
                    toast.classList.add('toast');
                    if(data == 1){
                        msg = "<i class='fa-solid fa-circle-check'></i> Item Return Success";
                        toast.innerHTML = msg;
                        toastBox.appendChild(toast);
                        setTimeout(()=>{
                            toast.remove();
                        },3000);
                        $('.venders-info').css("display","none");
                        $("#customerdata")[0].reset();
                        showdata()
                    }
                    else if(data == 0){
                        msg = "<i class='fa-solid fa-circle-exclamation'></i> Unable to Return";
                        toast.innerHTML = msg;
                        toastBox.appendChild(toast);
                        if (msg.includes('Unable')) {
				        toast.classList.add('error');
                        }
                        setTimeout(()=>{
                            toast.remove();
                        },3000);
                        $(this).closest('.venders-info').remove();
                        $("#customerdata")[0].reset();
                    showdata()
                    }
                },
            })
        });

        })

        //Editng Data
        $("tbody").on("click", ".ed", function(){
            var boxes = document.getElementById('p_details');
            console.log("Edit button");
            let id = $(this).attr("data-id");
            console.log(id);
            mydata = {id:id};
            console.log(mydata);
            $.ajax({
                url: "purchase/p_edit.php",
                method: "POST",
                dataType: "json",
                data: JSON.stringify(mydata),
                success: function(data){
                    console.log(data);
                    $("#cusid").val(data.SN);
                    $("#Dates").val(data.Date);
                    $("#Vender").val(data.V_Name);
                    $("#P_Name").val(data.P_Name);
                    $("#P_Qty").val(data.P_Qty);
                    $("#P_Rate").val(data.P_Rate);
                    $("#P_Dis").val(data.P_Dis);
                    boxes.classList.add('open');
                    
                },
            });
            $('.butns').css("display","flex");
            $('.venders-main').append('<div class="venders-info"><input type="text" id="cusid" style="display:none;">\
                                <div class="add">\
                                    <label for="">Date</label>\
                                    <input type="date" name="Dates" id="Dates">\
                                </div>\
                                <div class="names">\
                                     <label for="">Vendor Name</label>\
                                    <select name="V_Name" id="Vender"><option value="">---- Select Option ----</option><?php while($row = $result->fetch_object()){ ?><option value="<?php echo $row->V_Name; ?>"><?php echo $row->V_Name; ?></option><?php } ?></select>\
                                </div>\
                                <div class="add">\
                                    <label for="">Buying Product</label>\
                                    <input type="text" name="P_Name" id="P_Name">\
                                </div>\
                                <div class="qty">\
                                    <label for="">Quantity</label>\
                                    <input type="text" name="P_Qty" id="P_Qty">\
                                </div>\
                                <div class="rate">\
                                    <label for="">Rate</label>\
                                    <input type="text" name="P_Rate" id="P_Rate">\
                                </div>\
                                <div class="discount">\
                                    <label for="">Discount</label>\
                                    <input type="text" name="P_Dis" id="P_Dis">\
                                </div>\
                                <div class="discounts">\
                                    <input type="button" class="btn2" value="Remove">\
                                </div></div>')
                                $('.venders-info').css("grid-template-columns","0fr 0.7fr 1fr 0.3fr 0.2fr 0.2fr 0.1fr");
        });
        //For clear
        $("#clear").click(function(e){
            e.preventDefault();
            $("#customerdata")[0].reset();
        });
        //For Search
        $("#search").click(function(){
            outputs = "";
            let input = $("#txt").val();
            mydata = {input:input};
            if(input != ""){
                $.ajax({
                    url: "purchase/p_search.php",
                    method: "POST",
                    dataType: "json",
                    data: mydata,
                    success: function(data){
                        console.log(data);
                        let count = 1;
                        let total2 = 0;
                        for(i=0;i<data.length;i++){
                            total = data[i].P_Qty*data[i].P_Rate - data[i].P_Dis;
                            outputs += "<tr><td style='text-align:center;'>" + count + "</td><td>" + data[i].Date + "</td><td>" + data[i].V_Name + "</td><td>" + data[i].P_Name + "</td><td style='text-align:center;'>" + data[i].P_Qty + "</td><td style='text-align:right;'>" + data[i].P_Rate + "</td><td style='text-align:right;'>" + data[i].P_Dis + "</td><td style='text-align:right;'>" + total + "</td><td><a class='ed' title='Edit' data-id=" + data[i].SN + "><img src='Img/edit.png' alt='Edit'></a></td><td><a class='return' title='Return' data-id=" + data[i].SN + "><img src='Img/return.png' alt='Return'></a></td><td><a class='del' title='Delete' data-id=" + data[i].SN + "><img src='Img/bin.png' alt='Delete'></a></td></tr>";
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
    });
        $(document).on('click','.btn2',function(){
            $('.but2').css("display","none");
            $('.but').css("display","grid");
            $("#customerdata")[0].reset();
            $(this).closest('.venders-info').remove();
            
        });
        $(document).on('click','.add-more-form', function(){
            $('.butns').css("display","flex");
            $('.venders-main').append('<div class="venders-info"><input type="text" id="cusid" style="display:none;">\
                                <div class="add" style="display:none">\
                                    <label for="">Date</label>\
                                    <input type="hidden" name="Dates" id="Dates">\
                                </div>\
                                <div class="names">\
                                     <label for="">Vendor Name</label>\
                                    <select name="V_Name" id="Vender"><option value="">---- Select Option ----</option><?php while($rows = $results->fetch_object()){ ?><option value="<?php echo $rows->V_Name; ?>"><?php echo $rows->V_Name; ?></option><?php } ?></select>\
                                </div>\
                                <div class="add">\
                                    <label for="">Buying Product</label>\
                                    <input type="text" name="P_Name" id="P_Name">\
                                </div>\
                                <div class="qty">\
                                    <label for="">Quantity</label>\
                                    <input type="text" name="P_Qty" id="P_Qty">\
                                </div>\
                                <div class="rate">\
                                    <label for="">Rate</label>\
                                    <input type="text" name="P_Rate" id="P_Rate">\
                                </div>\
                                <div class="discount">\
                                    <label for="">Discount</label>\
                                    <input type="text" name="P_Dis" id="P_Dis">\
                                </div>\
                                <div class="discounts">\
                                    <input type="button" class="btn2" value="Remove">\
                                </div></div>');
                });
    </script>
 <script>
        var sear = document.getElementById('sear');
        var tbl = document.getElementById('tbl');
        var boxes = document.getElementById('p_details');
        function toggle() {
            tbl.classList.add('close-tbl');
            boxes.classList.add('open');
            sear.classList.add('close-tbl');
        }
        function closes() {
            tbl.classList.remove('close-tbl');
            boxes.classList.remove('open');
            sear.classList.remove('close-tbl');
            $('.venders-info').remove();
            $("#customerdata")[0].reset();
        }
    </script>

</body>
</html>
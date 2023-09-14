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
                <h4>Stocks Information</h4>
                <div class="boxes">
                    <div class="btn">
                            <h5>Details</h5>
                        </div>
                    <div class="sear" id="sear">
                        <div class="search">
                            <input type="search" id="txt" style="width:250px;">
                            <input type="button" value="Search" id="search" style="background-color: lightblue;color: black;">
                        </div>
                        <form id="custo" action="" method="post">
                            <div class="uid" style="display:none;">
                                <input type="text" id="cusid">
                            </div>
                            <div class="parti">
                                <label for="">Stock Name</label>
                                <input type="text" name="P_Name" disabled value="" id="P_Name">
                            </div>
                            <div class="qtyi">
                                <label for="">Stocks</label>
                                <input type="text" name="P_Qty" value="" id="P_Qty">
                            </div>
                            <div class="butns">
                                    <div class="but">
                                        <input type="submit"  id="submit" class="btn1" value="Submit" name="submit">
                                    </div>
                                    <div class="but1">
                                        <input type="button" class="btn2" value="Cancel">
                                    </div>
                                </div>
                        </form>
                    </div>
                    <div class="tbl" id="tbl">
                        <table>
                            <thead>
                                <tr>
                                    <td class="bichma">SN</td>
                                    <td style="width:80%;">Stock Name</td>
                                    <td class="sidema">Qty</td>
                                    <td class="sidema">Rate</td>
                                    <td class="bichma">Action</td>
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
                        for(i=0;i<data.length;i++){
                            output += "<tr><td style='text-align:center;'>" + count + "</td><td>" + data[i].P_Name + "</td><td class='sidema'>" + data[i].P_Qty + "</td><td class='sidema'>" + data[i].P_Rate + "</td><td style='text-align:center;'><a class='ed' title='Edit' data-id=" + data[i].SN + "><img src='Img/edit.png' alt='Edit'></a></td></tr>";
                        count++;
                        }
                        $("#response").html(output);
                    }
                })
            }
            showdata();

//On click Submit button
            $("#submit").click(function(e){
            e.preventDefault();
            console.log('Submit Button Clicked');
            let id = $("#cusid").val();
            console.log(id);
            let qty = $("#P_Qty").val();
            console.log(qty);
            mydata = {id:id,qty:qty};
            $.ajax({
                url:"stocks/s_update.php",
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
                    $("#custo")[0].reset();
                    $('.butns').css("display","none");
                    $('.parti').css("display","none");
                    $('.qtyi').css("display","none");
                    showdata();
                },
            })
        });

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
                    $("#P_Name").val(data.P_Name);
                    $("#P_Qty").val(data.P_Qty);
                    $("#P_Rate").val(data.P_Rate);
                    
                },
            });
            $('.butns').css("display","flex");
            $('.parti').css("display","grid");
            $('.qtyi').css("display","grid");
            
        });
        //For Search
        $("#search").click(function(){
            outputs = "";
            let input = $("#txt").val();
            mydata = {input:input};
            if(input != ""){
                $.ajax({
                    url: "stocks/s_search.php",
                    method: "POST",
                    dataType: "json",
                    data: mydata,
                    success: function(data){
                        console.log(data);
                        let count = 1;
                        for(i=0;i<data.length;i++){
                            outputs += "<tr><td style='text-align:center;'>" + count + "</td><td>" + data[i].P_Name + "</td><td style='text-align:center;'>" + data[i].P_Qty + "</td><td style='text-align:right;'>" + data[i].P_Rate + "</td><td style='text-align:center;'><a class='ed' title='Edit' data-id=" + data[i].SN + "><img src='Img/edit.png' alt='Edit'></a></td></tr>";
                        count++;
                        }
                        $("#response").html(outputs);
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
            $('.butns').css("display","none");
            $('.parti').css("display","none");
            $('.qtyi').css("display","none");
            $('.but2').css("display","none");
            $('.but').css("display","grid");
            $(this).closest('.venders-info').remove();
            $(this).closest('.venders-info').remove();
            
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
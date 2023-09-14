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
                <h4>Expensses Information</h4>
                <div class="boxes">
                    <div class="btn">
                            <h5>Details</h5>
                            <button id="add"><i class="fa-solid fa-plus"></i></button>
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
                                <label for="">Particular Name</label>
                                <input type="text" name="E_Name" value="" id="E_Name">
                            </div>
                            <div class="qtyi">
                                <label for="">Amount</label>
                                <input type="text" name="E_Amt" value="" id="E_Amt">
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
                                    <td>Date</td>
                                    <td style="width:70%;">Particular Name</td>
                                    <td class="bichma">Amount</td>
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
                    url: "expense/e_retrive.php",
                    method: "POST",
                    dataType: "json",
                    success: function(data){
                        //console.log(data.Total);
                       let count = 1;
                       let total2 = 0;
                        for(i=0;i<data.length;i++){
                            total = data[i].E_Amt*1;
                            output += "<tr><td style='text-align:center;'>" + count + "</td><td>" + data[i].Date + "</td><td>" + data[i].E_Name + "</td><td class='bichma'>" + data[i].E_Amt + "</td></tr>";
                        count++;
                        total2 += total;
                        }
                        $("#response").html(output);
                        $("#response").append("<tr><td colspan='3' style='text-align: right;'><strong>Total Expenses : </strong></td><td class='bichma'><strong>" + total2 + "</strong></td></tr>");
                    }
                })
            }
            showdata();

//On click Submit button
            $("#submit").click(function(e){
            e.preventDefault();
            console.log('Submit Button Clicked');
            let id = $("#cusid").val();
            let ename = $("#E_Name").val();
            console.log(id);
            let amt = $("#E_Amt").val();
            mydata = {id:id,ename:ename,amt:amt};
            $.ajax({
                url:"expense/e_insert.php",
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

        //Add Form
        $("#add").click(function(){
            console.log("My name is Add");
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
</body>
</html>
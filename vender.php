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
                <h4>Venders Information</h4>
                <div class="boxes">
                    <div class="btn">
                            <h5>Details</h5>
                            <button id="toggle"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    <div class="p_details" id="p_details">
                        <form id="customerdata" action="vender/v_insert.php" method="post">
                            <div class="vender-info" id="info">
                                <input type="text" id="cusid" style="display:none;">
                                <div class="name">
                                    <label for="" style="color:black;">Vendor Name</label>
                                    <input type="text" required name="Vendor_Name" id="V_Name">
                                </div>
                                <div class="pan">
                                    <label for="">Vendor Pan No</label>
                                    <input type="text" required name="Pan_Number" id="V_Pan">
                                </div>
                                <div class="add">
                                    <label for="">Vendor Address</label>
                                    <input type="text" required name="Vendor_Address" id="V_Add">
                                </div>
                                <div class="email">
                                    <label for="">Vendor Email</label>
                                    <input type="text" required name="Vendor_Email" id="V_Email">
                                </div>
                                <div class="phone">
                                    <label for="">Vendor Phone</label>
                                    <input type="text" required name="Vendor_Mobile" id="V_Mobile">
                                </div>
                                <div class="btns">
                                    <input type="button" class="btn2" value="Cancel">
                                    <input type="submit"  id="submit" class="btn1" value="Submit" name="submit">
                                </div>
                            </div>
                        </form>
                    </div>
                    <input type="search" id="txt" style="width:250px;margin-left:20px;">
                    <input type="button" value="Search" id="search" style="background-color: lightblue;color: black;">
                    <div class="tbl" id="tbl">
                        <table>
                            <thead>
                                <tr>
                                    <td>S.N</td>
                                    <td>Vender Name</td>
                                    <td>Pan Number</td>
                                    <td>Vender Address</td>
                                    <td>Vender Email Address</td>
                                    <td>Vender Mobile No</td>
                                    <td colspan="2">Action</td>
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
                    url: "vender/v_retrive.php",
                    method: "POST",
                    dataType: "json",
                    success: function(data){
                        //console.log(data);
                       let count = 1;
                        for(i=0;i<data.length;i++){
                           
                            output += "<tr><td>" + count + "</td><td>" + data[i].V_Name + "</td><td>" + data[i].V_Pan + "</td><td>" + data[i].V_Add + "</td><td>" + data[i].V_Email + "</td><td>" + data[i].V_Mobile + "</td><td><a class='ed' title='Edit' data-id=" + data[i].SN + "><img src='Img/edit.png' alt='Edit'></a></td><td><a class='del' title='Delete' data-id=" + data[i].SN + "><img src='Img/bin.png' alt='Delete'></a></td></tr>";
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
            let name = $("#V_Name").val();
            let pan = $("#V_Pan").val();
            let add = $("#V_Add").val();
            let email = $("#V_Email").val();
            let mobi = $("#V_Mobile").val();
            console.log(id);
            mydata = {id:id,name:name,pan:pan,add:add,email:email,mobi:mobi};
            $.ajax({
                url:"vender/v_insert.php",
                method: "POST",
                data: JSON.stringify(mydata),
                success: function(msg){
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
                    },6000);
                    $('.p_details').css("display","none");
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
                url: "vender/v_delete.php",
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
                        },6000);
                        showdata()
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
                        },6000);
                    }
                },
            });
        })
        //Editng Data
        $("tbody").on("click", ".ed", function(){
            console.log("Edit button");
            let id = $(this).attr("data-id");
            //console.log(id);
            mydata = {id:id};
            $.ajax({
                url: "vender/v_edit.php",
                method: "POST",
                dataType: "json",
                data: JSON.stringify(mydata),
                success: function(data){
                    console.log(data);
                    $("#cusid").val(data.SN);
                    $("#V_Name").val(data.V_Name);
                    $("#V_Pan").val(data.V_Pan);
                    $("#V_Add").val(data.V_Add);
                    $("#V_Email").val(data.V_Email);
                    $("#V_Mobile").val(data.V_Mobile);
                    $('.p_details').css("display","grid");
                },
            });
        });

        $(document).on('click','.btn2',function(){
            $('.p_details').css("display","none");
            $("#customerdata")[0].reset();   
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
                    url: "vender/v_search.php",
                    method: "POST",
                    dataType: "json",
                    data: mydata,
                    success: function(data){
                        let count = 1;
                        for(i=0;i<data.length;i++){
                           
                            outputs += "<tr><td>" + count + "</td><td>" + data[i].V_Name + "</td><td>" + data[i].V_Pan + "</td><td>" + data[i].V_Add + "</td><td>" + data[i].V_Email + "</td><td>" + data[i].V_Mobile + "</td><td><a class='ed' title='Edit' data-id=" + data[i].SN + "><img src='Img/edit.png' alt='Edit'></a></td><td><a class='del' title='Delete' data-id=" + data[i].SN + "><img src='Img/bin.png' alt='Delete'></a></td></tr>";
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
                    },6000);
                $("#response").html(output);
                    }
                });
            }
        });

        $("#toggle").click(function(e){
            $('.p_details').css("display","grid");
        });
    });
    </script>

</body>
</html>
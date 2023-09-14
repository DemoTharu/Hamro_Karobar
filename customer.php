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
                <h4>Customers Information</h4>
                <div class="boxes">
                    <div class="btn">
                            <h5>Details</h5>
                            <button onclick="toggle()"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    <div class="p_details" id="p_details">
                        <form id="customerdata" action="c_insert.php" method="post">
                            <div class="vender-info" id="info">
                                <input type="text" id="cusid" style="display:none;">
                                <div class="names">
                                    <label for="">Customer Name</label>
                                    <input type="text" name="C_Name" id="C_Name">
                                </div>
                                <div class="add">
                                    <label for="">Customer Address</label>
                                    <input type="text" name="C_Add" id="C_Add">
                                </div>
                                <div class="email">
                                   <label for="">Customer Email Address</label>
                                   <input type="text" name="C_Email" id="C_Email">
                                </div>
                                <div class="phone">
                                    <label for="">Customer Mobile No.</label>
                                    <input type="text" name="C_Num" id="C_Mobile">
                                </div>
                                <div class="btns">
                                    <input type="button" class="btn2" value="Cancel" onclick="closes()">
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
                                    <td>Customer Name</td>
                                    <td>Customer Address</td>
                                    <td>Customer Email Address</td>
                                    <td>Customer Mobile No.</td>
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
                    url: "customer/c_retrive.php",
                    method: "POST",
                    dataType: "json",
                    success: function(data){
                        //console.log(data);
                       let count = 1;
                        for(i=0;i<data.length;i++){
                           
                            output += "<tr><td>" + count + "</td><td>" + data[i].C_Name + "</td><td>" + data[i].C_Add + "</td><td>" + data[i].C_Email + "</td><td>" + data[i].C_Mobile + "</td><td><a class='ed' title='Edit' data-id=" + data[i].SN + "><img src='Img/edit.png' alt='Edit'></a></td><td><a class='del' title='Delete' data-id=" + data[i].SN + "><img src='Img/bin.png' alt='Delete'></a></td></tr>";
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
            let name = $("#C_Name").val();
            let add = $("#C_Add").val();
            let email = $("#C_Email").val();
            let mobi = $("#C_Mobile").val();
            console.log(id);
            mydata = {id:id,name:name,add:add,email:email,mobi:mobi};
            $.ajax({
                url:"customer/c_insert.php",
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
                url: "customer/c_delete.php",
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
                        $(mythis).closest("tr").fadeOut();
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
            var boxes = document.getElementById('p_details');
            console.log("Edit button");
            let id = $(this).attr("data-id");
            //console.log(id);
            mydata = {id:id};
            $.ajax({
                url: "customer/c_edit.php",
                method: "POST",
                dataType: "json",
                data: JSON.stringify(mydata),
                success: function(data){
                    //console.log(data);
                    $("#cusid").val(data.SN);
                    $("#C_Name").val(data.C_Name);
                    $("#C_Add").val(data.C_Add);
                    $("#C_Email").val(data.C_Email);
                    $("#C_Mobile").val(data.C_Mobile);
                    boxes.classList.add('open');
                },
            });
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
                    url: "customer/c_search.php",
                    method: "POST",
                    dataType: "json",
                    data: mydata,
                    success: function(data){
                        let count = 1;
                        for(i=0;i<data.length;i++){
                           
                            outputs += "<tr><td>" + count + "</td><td>" + data[i].C_Name + "</td><td>" + data[i].C_Add + "</td><td>" + data[i].C_Email + "</td><td>" + data[i].C_Mobile + "</td><td><a class='ed' title='Edit' data-id=" + data[i].SN + "><img src='Img/edit.png' alt='Edit'></a></td><td><a class='del' title='Delete' data-id=" + data[i].SN + "><img src='Img/bin.png' alt='Delete'></a></td></tr>";
                        count++;
                        }
                      
                        $("#response").html(outputs);
                    }
                });
            }
            else{
                $.ajax({
                    url: "customer/c_search.php",
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
                $("#response").html(output);
                    }
                });
            }
        });
    });
    </script>
    <script>
        var boxes = document.getElementById('p_details');
        function toggle() {
            boxes.classList.add('open');
        }
        function closes() {
            boxes.classList.remove('open');
            $("#customerdata")[0].reset();
        }
    </script>

</body>
</html>
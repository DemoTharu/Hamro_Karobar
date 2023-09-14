<?php
    session_start();
    if (!isset($_SESSION['new'])) {
        header("Location: index.php");
    }
    else {
    require "sidebar.php";
    if (isset($_POST['submit'])) {
        $npass = $_POST['npass'];
        $rpass = $_POST['rpass'];
        $pass = $_POST['pass'];
        if($_SESSION['new'] == $pass){
            if ($npass == $rpass) {
                
            }
        }
    }
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
                <h4>Change Your Password</h4>
                <div class="boxes">
                    <div class="password-container">
                        <form id="customerdata" method="post">
                            <div class="password">
                                <label for="">Old Password</label>
                                <input type="password" name="pass" id="pass" required>
                            </div>
                            <div class="password">
                                <label for="">New Password</label>
                                <input type="password" name="npass" id="npass" required>
                            </div>
                            <div class="password">
                                <label for="">Re-Write Password</label>
                                <input type="password" name="rpass" id="rpass" required>
                            </div>
                            <div class="pass-submit">
                                <input type="submit" value="Submit" class="btn1" id="submit" name="submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function(){
            $("#submit").click(function(e){
            e.preventDefault();
            console.log('Submit Button Clicked');
            let pass = $("#pass").val();
            let npass = $("#npass").val();
            let rpass = $("#rpass").val();
            mydata = {pass:pass,npass:npass,rpass:rpass};
            $.ajax({
                url:"profile/profile_insert.php",
                method: "POST",
                data: JSON.stringify(mydata),
                success: function(msg){
                    console.log(msg);
                    let toastBox = document.getElementById('toastBox');
                    let toast = document.createElement('div');
                    toast.classList.add('toast');
                    toast.innerHTML = msg;
                    toastBox.appendChild(toast);

                    if (msg.includes('Not')) {
                        toast.classList.add('error');
                    }
                    if (msg.includes('Empty')) {
                        toast.classList.add('invalid');
                    }

                    setTimeout(()=>{
                        toast.remove();
                    },3000);
                    $("#customerdata")[0].reset();
                },
            })
        });

        });
    </script>
</body>
</html>
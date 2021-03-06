<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title> AfterCarrey Admin System</title>


    <?php
    include('./header.php');
    include('./db_connect.php');

    session_start();
    if (isset($_SESSION['login_id'])) {
        header("location:index.php?page=home");
    }
    ?>

</head>
<style>
    body {
        width: 100%;
        height: calc(100%);
    }

    main#main {
        width: 100%;
        height: calc(100%);
        background: white;
    }

    #login-right {
        position: absolute;
        right: 0;
        width: 40%;
        height: calc(100%);
        background: white;
        display: flex;
        align-items: center;
    }

    #login-left {
        position: absolute;
        left: 0;
        width: 60%;
        height: calc(100%);
        background: #4169e1;
        display: flex;
        align-items: center;
        background: url(../assets/img/aftercare_service.jpg);
        background-repeat: no-repeat;
        background-size: cover;
    }

    #login-right .card {
        margin: auto
    }


</style>

<body>


<main id="main" class=" bg-dark">
    <div id="login-left">
        iv>
    </div>

    <div id="login-right">
        <div class="card col-md-8">
            <div class="card-body">
                <form id="login-form">

                    <div class="form-group">
                        <label for="username" class="control-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control">
                        <input type="checkbox" onclick="showPassword()">Show Password
                    </div


                    <div style="text-align: center;">
                        <button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</main>

<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>


<script>
    function showPassword() {
        const ps = document.getElementById("password");
        if (ps.type === "password") {
            ps.type = "text";
        } else {
            ps.type = "password";
        }
    }

    $('#login-form').submit(function (e) {
        e.preventDefault();
        $('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');

        if ($(this).find('.alert-danger').length > 0)
            $(this).find('.alert-danger').remove();

        $.ajax({
            url: 'ajax.php?action=login',
            method: 'POST',
            data: $(this).serialize(),
            error: err => {
                console.log(err)
                $('#login-form button[type="button"]').removeAttr('disabled').html('Login');

            },
            success: function (resp) {
                if (resp == 1) {
                    location.href = 'index.php?page=home';
                } else if (resp == 2) {
                    location.href = 'test.php';
                } else {
                    $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
                    $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
                }
            }
        });
    });
</script>
</html>
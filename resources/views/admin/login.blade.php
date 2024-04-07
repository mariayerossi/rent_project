<!DOCTYPE html>
<html>
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Central Hiace Rent Jatim</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
      <!-- Responsive-->
      <link rel="stylesheet" href="{{asset('css/responsive.css')}}">
      <!-- fevicon -->
      <link rel="icon" href="{{asset('images/fevicon.png')}}" type="image/gif" />
      <!-- font css -->
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Raleway:wght@400;500;600;700;800&display=swap" rel="stylesheet">
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="{{asset('css/jquery.mCustomScrollbar.min.css')}}">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <link href= 
'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'> 
  
    <script src= 
'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'> 
    </script> 
  
    <script src= 
'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'> 
    </script>
   </head>
   <body>
    <!-- header section start -->
    <div class="header_section mb-4">
        <div class="container">
           <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <a href="/" class="logo d-flex align-items-center">
                   <h1 style="font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;color:white">Central Hiace Rent Jatim</h1>
               </a>
           </nav>
        </div>
     </div>
     

     <style>
        body {
        font-family: 'Roboto', sans-serif;
    }
    
    .login-box {
        margin-bottom: 30px;
        height: auto;
        background: rgb(239, 239, 239);
        text-align: center;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    }
    
    .login-key {
        height: 100px;
        font-size: 80px;
        line-height: 100px;
        background: -webkit-linear-gradient(#27EF9F, #0DB8DE);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .login-title {
        margin-top: 15px;
        text-align: center;
        font-size: 30px;
        letter-spacing: 2px;
        margin-top: 15px;
        font-weight: bold;
        color: #000000;
    }
    
    .login-form {
        margin-top: 25px;
        text-align: left;
    }
    
    input[type=text] {
        background-color: rgb(239, 239, 239);
        border: none;
        border-bottom: 2px solid #0DB8DE;
        border-top: 0px;
        border-radius: 0px;
        font-weight: bold;
        outline: 0;
        margin-bottom: 20px;
        padding-left: 0px;
        color: #000000;
    }
    
    input[type=password] {
        background-color: rgb(239, 239, 239);
        border: none;
        border-bottom: 2px solid #0DB8DE;
        border-top: 0px;
        border-radius: 0px;
        font-weight: bold;
        outline: 0;
        padding-left: 0px;
        margin-bottom: 20px;
        color: rgb(0, 0, 0);
    }
    
    .form-group {
        margin-bottom: 40px;
        outline: 0px;
    }
    
    .form-control:focus {
        border-color: inherit;
        -webkit-box-shadow: none;
        box-shadow: none;
        border-bottom: 2px solid #0DB8DE;
        outline: 0;
        background-color: rgb(239, 239, 239);
        color: #000000;
    }
    
    input:focus {
        outline: none;
        box-shadow: 0 0 0;
    }
    
    label {
        margin-bottom: 0px;
    }
    
    .form-control-label {
        font-size: 10px;
        color: #6C6C6C;
        font-weight: bold;
        letter-spacing: 1px;
    }
    
    .btn-outline-primary {
        border-color: #0DB8DE;
        color: #0DB8DE;
        border-radius: 0px;
        font-weight: bold;
        letter-spacing: 1px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    }
    
    .btn-outline-primary:hover {
        background-color: #0DB8DE;
        right: 0px;
    }
    
    .login-btm {
        float: left;
    }
    
    .login-button {
        padding-right: 0px;
        text-align: right;
        margin-bottom: 25px;
    }
    
    .login-text {
        text-align: left;
        padding-left: 0px;
        color: #A2A4A4;
    }
    
    .loginbttm {
        padding: 0px;
    }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box">
                <div class="col-lg-12 login-key">
                    <i class="fa fa-key" aria-hidden="true"></i>
                </div>
                <div class="col-lg-12 login-title">
                    LOGIN ADMIN
                </div>
    
                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">
                        <form method="POST" action="/admin/login" id="loginForm">
                            @csrf
                            <div class="form-group">
                                <label class="form-control-label">USERNAME</label>
                                <input type="text" class="form-control" name="username">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">PASSWORD</label>
                                <input type="password" class="form-control" name="password" i>
                            </div>
    
                            <div class="col-lg-12 loginbttm">
                                <div class="col-lg-6 login-btm login-text">
                                    <!-- Error Message -->
                                </div>
                                <div class="col-lg-6 login-btm login-button">
                                    <button type="submit" class="btn btn-outline-primary" id="login">LOGIN</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2"></div>
            </div>
        </div>
        <script>
            $("#login").click(function(event) {
                event.preventDefault(); // Mencegah perilaku default form
    
                var formData = $("#loginForm").serialize(); // Mengambil data dari form
        
                $.ajax({
                    url: "/admin/login",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            window.location.href = "/admin/beranda"
                        }
                        else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Ada masalah saat mengirim data. Silahkan coba lagi.');
                    }
                });
    
                return false; // Mengembalikan false untuk mencegah submission form
            });
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      
      <script src="{{asset('js/jquery.min.js')}}"></script>
      <script src="{{asset('js/popper.min.js')}}"></script>
      <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
      <script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
      <script src="{{asset('js/plugin.js')}}"></script>
      <!-- sidebar -->
      <script src="{{asset('js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
      <script src="{{asset('js/custom.js')}}"></script>
   </body>
</html>
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
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

      <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />

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
      <style>
         .floating {
 position: fixed;
 width: 60px;
 height: 60px;
 bottom: 40px;
 right: 40px;
 background-color: #25d366;
 color: #fff;
 border-radius: 50px;
 text-align: center;
 font-size: 30px;
 box-shadow: 2px 2px 3px #999;
 z-index: 100;
}

.fab-icon {
 margin-top: 16px;
}
      </style>
    <!-- header section start -->
    <div class="header_section">
        <div class="container">
           <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <a href="/" class="logo d-flex align-items-center">
                   <h1 style="font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;color:white">Central Hiace Rent Jatim</h1>
               </a>
           </nav>
        </div>
     </div>
     <!-- header section end -->
     <div class="call_text_main mb-4">
        <div class="container">
           <div class="call_taital">
              <div class="call_text"><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i><span class="padding_left_15">Location</span></a></div>
              <div class="call_text"><a href="https://wa.me/+628118000071"><i class="fa fa-phone" aria-hidden="true"></i><span class="padding_left_15">(+62) 811-8000-071</span></a></div>
           </div>
        </div>
     </div>

      @yield('content')

      <!-- render the button and direct it to wa.me -->
      <a href="https://wa.me/628118000071" class="floating" target="_blank">
         <i class="fab fa-whatsapp fab-icon"></i>
      </a>
      
      <div class="footer_section layout_padding" id="contact">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="footeer_logo"><a href="/">
                     <h1 style="font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;color:white">Central Hiace Rent Jatim</h1>
                 </a></div>
               </div>
            </div>
            <div class="footer_section_2">
               <div class="row">
                  <div class="col">
                     <h4 class="footer_taital">Information</h4>
                     <div class="location_text"><a href="/"><span class="padding_left_15">Home</span></a></div>
                     <div class="location_text"><a href="/#about"><span class="padding_left_15">About</span></a></div>
                     <div class="location_text"><a href="/#gallery"><span class="padding_left_15">Vehicles</span></a></div>
                     <div class="location_text"><a href="/#client"><span class="padding_left_15">Client</span></a></div>
                  </div>
                  <div class="col">
                     <h4 class="footer_taital">Contact Us</h4>
                     <div class="location_text"><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i><span class="padding_left_15">Location</span></a></div>
                     <div class="location_text"><a href="https://wa.me/+628118000071"><i class="fa fa-phone" aria-hidden="true"></i><span class="padding_left_15">(+62) 811-8000-071</span></a></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- footer section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <p class="copyright_text">2024 All Rights Reserved</a></p>
               </div>
            </div>
         </div>
      </div>
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
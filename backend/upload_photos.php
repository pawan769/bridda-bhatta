   <?php
    $ids = $_GET["id"];
    ?>


   <!DOCTYPE html>
   <html>

   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <title>upload document</title>
       <!-- bootstrap css -->
       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
       <style>
           body {
               margin: 0;
               padding: 0;
               
           }
           .bichko{
              display: flex;
               flex-direction: column;
               align-items: center;
               justify-content: space-between;
               background: white;
               color: #140407;
               font-family: 'Lato', sans-serif;

           }

           h2 {
               margin: 50px 0;
               text-align: center;
               text-transform: uppercase;
           }

           .file-drop-area {
               position: relative;
               display: flex;
               align-items: center;
               width: 450px;
               max-width: 100%;
               padding: 25px;
               border: 1px dashed black;
               border-radius: 3px;
               transition: 0.2s;
           }

           .choose-file-button {
               flex-shrink: 0;
               background-color: rgba(255, 255, 255, 0.04);
               border: 1px solid rgba(255, 255, 255, 0.1);
               border-radius: 3px;
               padding: 8px 15px;
               margin-right: 10px;
               font-size: 12px;
               text-transform: uppercase;
           }

           .file-message {
               font-size: small;
               font-weight: 300;
               line-height: 1.4;
               white-space: nowrap;
               overflow: hidden;
               text-overflow: ellipsis;
           }

           .file-input {
               position: absolute;
               left: 0;
               top: 0;
               height: 100%;
               width: 100%;
               cursor: pointer;
               opacity: 0;

           }

           .mt-100 {
               margin-top: 10px;
           }

           #upl {
               float: right;
               margin-top: 10vh;
               width: 200px;
               height: 60px;
               text-transform: uppercase;
           }
 nav {
  display: flex;
  padding: 1% 6%;
  justify-content: space-between;
  align-items: center;
  background-color: blue;
  
}
nav img {
  width: 150px;
}
.nav-links {
  flex: 1;
  text-align: left;
}
.nav-links ul li {
  list-style: none;
  display: inline-block;
  padding: 8px 12px;
  position: relative;
}
.nav-links ul li a {
  color: #fff;
  text-decoration: none;
  font-size: 16px;
}
.nav-links ul li::after {
  content: "";
  width: 0%;
  height: 2px;
  background: #f44336;
  display: block;
  margin: auto;
  transition: 0.5s;
}
.nav-links ul li:hover::after {
  width: 100%;
}

@media (max-width: 700px) {
  .text-box h1 {
    font-size: 20px;
  }
  .nav-links ul li {
    display: block;
  }
  .nav-links {
    position: absolute;
    background: #f44336;
    height: 100vh;
    width: 200px;
    top: 0;
    right: -200px;
    text-align: left;
    z-index: 2;
    transition: 1s;
  }
  nav .fa-solid {
    display: block;
    color: #fff;
    margin: 10px;
    font-size: 22px;
    cursor: pointer;
  }
  .nav-links ul {
    padding: 30px;
  }
}
.head_imgs {
  display: flex;
  justify-content: space-between;
  background-color: white;
  
}
.head_imgs > img {
  height: 6rem;
  width: 6rem;
  margin: 0rem 2rem;
}
.middleText {
  text-align: center;
  margin: 1rem 0rem;
}

</style>
   </head>

   <body>
       <!-- Include jQuery -->
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
       <!-- Include Bootstrap JavaScript with jQuery dependency -->
       <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    
       <div class="head_imgs">
      <img src="../images/coatOfArms.png" />
      <div class="middleText">
        <h4 style="color: red">Government of Nepal</h4>
        <h2>Senior Allowance Scheme</h2>
      </div>
      <img src="../images/nepal_flag.gif" />
    </div>

    <nav>
      <div class="nav-links" id="navLinks">
        <i class="fa-solid fa-xmark" onclick="hideMenu()"></i>
        <ul>
          <li><a href="../index.html">Home</a></li>
          <li><a href="#abt">About</a></li>
          <li><a href="about.pdf" target="_blank">Policy</a></li>
          <li><a href="#ftr">Contact</a></li>
          <li><a href="./login.html">LOGIN</a></li>
        </ul>
      </div>
      <i class="fa-solid fa-bars" onclick="showMenu()"></i>
    </nav>

       <!-- Upload section -->
       <div class="container d-flex justify-content-center mt-100 bichko">
           <div class="row">
               <div class="col-md-12">
                   <h2>Upload Here</h2>

                   <form method="POST" action="save_photo.php" enctype="multipart/form-data">
                       <!-- Upload Photo -->
                       <label for="pp" class="lab">Upload Photo:</label>
                       <div class="file-drop-area">
                           <span class="choose-file-button">Choose files</span>
                           <span class="file-message">or drag and drop files here</span>
                           <input type="file" name="personal_photo" id="pp" class="file-input" />
                       </div>
                       <br><br>
                       <!-- Upload Citizenship -->
                       <label for="cc" class="lab">Upload Citizenship:</label>
                       <div class="file-drop-area">
                           <span class="choose-file-button">Choose files</span>
                           <span class="file-message">or drag and drop files here</span>
                           <input type="file" id="cc" name="cit_photo" class="file-input" />
                       </div>
                       <div>
                           <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                           <input type="submit" class="btn btn-primary" name="submit" value="upload File" id="upl" onclick="return doValidateFile()">
                       </div>
                   </form>
               </div>
           </div>
       </div>
       <script>
           $(document).on('change', '.file-input', function() {
               var filesCount = $(this)[0].files.length;

               var textbox = $(this).prev();

               if (filesCount === 1) {
                   var fileName = $(this).val().split('\\').pop();
                   textbox.text(fileName);
               } else {
                   textbox.text(filesCount + ' files selected');
               }
           });

           //    Validation for file upload
           function doValidateFile() {
               var pp = document.getElementById("pp");
               var cc = document.getElementById("cc");

               if (pp.value == "") {
                   alert("Please upload your photo");
                   return false;
               }
               if (cc.value == "") {
                   alert("Please upload your citizenship");
                   return false;
               }
               return true;
           }
       </script>
   </body>

   </html>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />


	<title>Sign In</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style type="text/css">
    	body {
		    background-size: cover;
		    background-position: center;
		}
		.card {
			background-color: rgba(0,0,0,.3);
 			
		}
		
    </style>

</head>

<body style="background-image: url('CLinicImage.webp');" >
    <main class="d-flex justify-content-center align-items-center vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg rounded-3 animate__animated animate__fadeInDown">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <img src="logoz.jpg" alt="Logo" style="height: 120px;">
                                <h1 class="h2 mt-3 text-dark">Welcome back!</h1>
                                <p class="lead text-dark">Sign in to your account to continue</p>
                            </div>
                            <form>
                                <div class="mb-3">
                                    <label for="email" class="form-label text-dark">Email</label>
                                    <input class="form-control" type="email" id="email" placeholder="Enter your email" style="border-radius: 25px;">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label text-dark">Password</label>
                                    <div class="input-group">
                                        <input class="form-control" type="password" id="password" placeholder="Enter your password" style="border-radius: 25px 0 0 25px;">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border-radius: 0 25px 25px 0;">
                                            <i class="fas fa-eye text-dark"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="button" id="sign-in" class="btn btn-lg btn-primary" style="border-radius: 25px;">Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

	<script src="js/app.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script type="text/javascript">

	$(document).on("click", "#togglePassword", function() {
		    const passwordField = $("#password");
		    const passwordFieldType = passwordField.attr('type');

		    if (passwordFieldType === 'password') {
		        passwordField.attr('type', 'text');
		        $(this).html('<i class="fas fa-eye-slash"></i>');
		    } else {
		        passwordField.attr('type', 'password');
		        $(this).html('<i class="fas fa-eye"></i>');
		    }
		});	

	    $(document).on("keypress", "#password", function(e) {
		    if (e.which === 13) {
		        $("#sign-in").click(); 
		    }
		});

	$(document).on("click", "#sign-in", ()=>{



		$.ajax({
		  url:"adminapi/users-login",
		  type: "POST",
		  data: {
		      email: $("#email").val(),
		      password: $("#password").val()
		  },
		  dataType: "json",
		  beforeSend: (e) => {
		  Swal.fire({
		    html: 'Loading...',
		    didOpen: () => {
		      Swal.showLoading()
		    }
		  })
		  },
		  success: (data) => {
		  	Swal.close();

		  	if (data.status == 1) {
			    Swal.fire({
			        icon: 'success',
			        title: data.response,
			        confirmButtonColor: '#3085d6',
			        cancelButtonColor: '#d33',
			        confirmButtonText: 'Ok'
			    }).then((result) => {
			        if (result.isConfirmed) {
						window.location.href = "http://localhost/apcs/admin/?users";
			        }
			    });
		  	}else{
		    Swal.fire({
		        icon: 'error',
		        title: data.response,
		        confirmButtonColor: '#3085d6',
		        cancelButtonColor: '#d33',
		        confirmButtonText: 'Ok'
		    }).then((result) => {
		        if (result.isConfirmed) {
		         	
		        }	
		    });
		  	}

		  },
		  error: (xhr, ajaxOptions, thrownError) => {

		      Swal.close(); 
		    
		      Swal.fire({
		        icon: 'error',
		        title: xhr.status,
		        text: thrownError,
		        confirmButtonColor: '#3085d6',
		        cancelButtonColor: '#d33',
		        confirmButtonText: 'Ok'
		      }).then((result) => {
		        if (result.isConfirmed) {
		         
		        }
		      });

		  }
		 });

	});	

	</script>
</body>

</html>

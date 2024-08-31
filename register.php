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

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-up.html" />

	<title>Sign Up</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

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

<body style="background-image: url('signup2.png');">
	<main class="d-flex w-100">
		<div class="container d-flex flex-column" >
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2 ">Get started</h1>
							<p class="lead">
								<b>Start creating an Account </b>
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form>
										<div class="mb-3">
											<label class="form-label text-light"><span>Account Type</span></label>
											<select class="form-control" id="accounttype">
												<option selected="" hidden="">Select Account Type</option>		
												<option value="Student">Student</option>
												<option value="Teacher">Teacher</option>
											</select>
										</div>
										<div class="mb-3">
											<label class="form-labe text-light">Full name</label>
											<input class="form-control form-control-lg" type="text" id="name" placeholder="Enter your name" />
										</div>
										<div class="mb-3">
											<label class="form-label text-light">Email</label>
											<input class="form-control form-control-lg" type="email" id="email" placeholder="Enter your email" />
										</div>
										<div class="mb-3">
											<label class="form-label text-light">Password</label>
											<input class="form-control form-control-lg" type="password" id="password" placeholder="Enter password" />
										</div>
										<div class="d-grid gap-2 mt-3">
											<button type="button" id="sign-up" class="btn btn-lg btn-primary">Sign up </button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="text-center mb-3">
							 <p class="text-light">Already have an account? <a href="index.php" class="text-primary"><Strong>Log In</Strong></a></p>
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
			
	$(document).on("click", "#sign-up", ()=>{

		if ($("#accounttype").val() == "Student") { 

		$.ajax({
		  url:"studentapi/user-register",
		  type: "POST",
		  data: {
		      email: $("#email").val(),
		      username: $("#name").val(),
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
		        title: 'A confirmation email has been sent to your email!',
		        confirmButtonColor: '#3085d6',
		        cancelButtonColor: '#d33',
		        confirmButtonText: 'Ok'
		    }).then((result) => {
		        if (result.isConfirmed) {
		         	
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

		}else if ($("#accounttype").val() == "Teacher") {

		$.ajax({
		  url:"teacherapi/user-register",
		  type: "POST",
		  data: {
		      email: $("#email").val(),
		      username: $("#name").val(),
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
		        title: 'A confirmation email has been sent to your email!',
		        confirmButtonColor: '#3085d6',
		        cancelButtonColor: '#d33',
		        confirmButtonText: 'Ok'
		    }).then((result) => {
		        if (result.isConfirmed) {
		         	
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

		}


	});	

	</script>
</body>

</html>
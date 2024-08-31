<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";


if (!isset($_SESSION['auth_user_id'])) {
	header("location: https://admintalkspace.negroscodeworks.com/");
}


?>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="../img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Admin</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" >
	<link href="../css/light.css" rel="stylesheet">
	<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">.
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.1.1/css/buttons.dataTables.css">


<style>

    .sidebar-brand {
        display: flex; 
        justify-content: center; 
        align-items: center; 
    }

    .sidebar-brand img {
        max-width: 135px; 
        height: auto; 
     }

      /* Custom sidebar colors */
	 #sidebar {
        background-color: linear-gradient(to right, #80c1ff  0%, #cce6ff 100%); /* Dark background */
    }

    .sidebar-brand {
        display: flex; /* Use flexbox */
        justify-content: center; /* Center content horizontally */
        align-items: center; /* Center content vertically */
        background: linear-gradient(to right, #80c1ff  0%, #cce6ff 100%); /* Header background */

    }

    .sidebar-brand img {
        max-width: 135px; /* Adjust the maximum width of the logo */
        height: auto; /* Maintain aspect ratio */
    }

    .sidebar-nav {
		background: linear-gradient(to right, #80c1ff  0%, #cce6ff 100%); /* Sidebar navigation background */

    }

    .sidebar-item {
        border-bottom: 1px linear-gradient(to right, #80c1ff  0%, #cce6ff 100%); /* Separator between sidebar items */
	}

    .sidebar-item:last-child {
        border-bottom: none; /* Remove separator from last sidebar item */
    }

    .sidebar-link {
        color: #f5f7fb; /* Sidebar link text color */
    }

    .sidebar-link Strong:hover{
        color: #0052cc; /* Sidebar link text color on hover */
        background-color: linear-gradient(to right, #80c1ff 0%, #cce6ff 100%); /* Background color on hover */
		
    }

    .sidebar-header {
        color: #ffffff; /* Sidebar header text color */
    }

    .sidebar-header:before {
        background-color: #2c376f; /* Sidebar header separator color */
    }

	.sidebar-item.active .sidebar-link:hover, .sidebar-item.active>.sidebar-link {
    background: white,transparent;
    border-left-color: black;
	color: #ffff;
	}
	.sidebar-link, a.sidebar-link {
    background:linear-gradient(to right, #80c1ff 0%, #cce6ff 100%);';
	border-left: 3px solid transparent;
    cursor: pointer;
    display: block;
    font-weight: 400;
    padding: .625rem 1.625rem;
    position: relative;
    text-decoration: none;
	transition: background .1s ease-in-out;
	}

	.sidebar-link, a.sidebar-link:hover{
		background: none;
	}



</style>

</head>

<body id="wrapper">

<div class="wrapper">
<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.php?class">
            <img src="../img.png" class="img-fluid" alt="Logo">
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header"></li>

            <li class="sidebar-item <?php if (isset($_GET['users'])) { echo 'active'; } ?>">
                <a class="sidebar-link" href="http://localhost/apcs/admin/index.php?users">
                    <i class="fas fa-chalkboard-teacher"  style='color:#002966;'></i> <span style='font-size:18px;color:	#002966;'>Users</span>
                </a>
            </li>
            <li class="sidebar-item <?php if (isset($_GET['patients'])) { echo 'active'; } ?>">
                <a class="sidebar-link" href="http://localhost/apcs/admin/index.php?patients">
                    <i class="fas fa-procedures" style='color:#002966;'></i>
                    <span style='font-size:18px;color:#002966;'>Patients</span>
                </a>
            </li>
        </ul>
    </div>
</nav>



		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>



				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
				                <i class="align-middle" data-feather="settings"></i>
				              </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
              <!-- <img src="<?= $_SESSION['system'][0]['img'] ?>" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> -->

              <span class="text-dark">  <?= $_SESSION['auth_username'] ?> </span>

              				</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="?profile"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" style="cursor: pointer;" id="sign-out">Log out</a>
							</div>

						</li>
					</ul>
				</div>






	   	</nav>

			<main class="content">
				<div class="container-fluid p-0">

					
                <?php
                if (isset($_GET['users'])) {
                    include 'pages/users.php';
                }
                if (isset($_GET['patients'])) {
                    include 'pages/patients.php';
                }
                ?>


				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="" target="_blank"><strong>LearnIT</strong></a> - <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong><?= date("Y"); ?></strong></a>								&copy;
							</p>
						</div>
						<div class="col-6 text-end">

						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>


	<script src="../js/app.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-tooltip@3.1.1/index.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!--   <script src="./assets/extensions/filepond/filepond.js"></script> -->
    <script type="text/javascript" src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.min.js"></script> 
    <script type="text/javascript" src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.min.js"></script> 
    <script type="text/javascript" src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <!-- DataTables Buttons JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.print.min.js"></script>




        <?php
        if (isset($_GET['users'])) {
            echo '<script src="js/users.js"></script>';
        }
        if (isset($_GET['patients'])) {
            echo '<script src="js/patients.js"></script>';
        }
        ?>
 
    <script type="text/javascript">
       

        $(document).on("click", "#sign-out", ()=>{


        $.ajax({
            url:"../adminapi/user-logout",
            type: "POST",
            dataType: "json",
            data: {
                id: '<?= $_SESSION['auth_user_id'] ?>'
            },
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

 
                Swal.fire({
                  icon: 'success',
                  title: 'Logout succesfully.',
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Ok'
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = "https://admintalkspace.negroscodeworks.com/talkspace/index.php";
                  }
                })


          }

         }); 

         });

    </script>
</body>

</html>
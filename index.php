<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Log Viewer">
    <meta name="author" content="Cristiano Silva @mcloide">

    <title>Log Viewer</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <!-- Custom styles for this template -->
    <style>
	.card {
	    margin-right: 10px;
	    margin-top: 10px;
	    min-height: 25rem;
	}

    .table tr td {
        max-width: 500px;
        text-wrap: wrap;
        overflow-wrap: break-word;
    }

    footer {
        background: #eee;
        min-height: 3rem;
        padding: 1rem;
    }

    .spacer {
        min-height: 800px;
    }

    </style>
  </head>

  <body>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0">
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
                    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
                        <span class="fs-4">Menu</span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="access.php" class="nav-link link-dark">
                            <i class="bi bi-calendar3"></i>
                            Access Logs
                            </a>
                        </li>
                        <li>
                            <a href="error.php" class="nav-link link-dark">
                            <i class="bi bi-bug"></i>
                            Error Logs
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col py-3">
                <main role="main">
                    <div class="container">
                        <!-- Example row of columns -->
                       
                            <h1>Log Viewer</h1>
                            <p>Please select one of the options on the side.</p>

                            <div class="spacer">&nbsp;</div>

                        <hr>

                    </div> <!-- /container -->

                </main>
            </div>

        </div>

        <footer>
            <hr>
            <p>&copy; Diniz Engineering Solutions 2024</p>
        </footer>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

  </body>
</html>

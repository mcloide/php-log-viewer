<?php

function cleanup($str) {
    trim($str);
    $str = str_replace(['[',']'],'',$str);
    return $str;
}

function readLastLines($filename, $num, $reverse = false)
{
    $file = new \SplFileObject($filename, 'r');
    $file->seek($file->getSize());
    $last_line = $file->key();
    
    $offset = $last_line - $num;
    if ($offset < 0) {
        $offset = 0;
    }

    $lines = new \LimitIterator($file, $offset, $last_line);
    $arr = iterator_to_array($lines);

    if($reverse) 
        $arr = array_reverse($arr);

    $return = [];
    foreach ($arr as $index => $line) {
        if (empty($line)) {
            continue;
        }

	$original = trim($line);
	$line = explode(']',trim($line));

        switch (count($line)) {
            case 1:
                $date = '';
                $type = '';
		$pid = '';
		$tid = '';
                $client = '';
                $error = $original;
            break;
            case 2:
		$date = '';
                $type = '';
		$pid = '';
		$tid = '';
                $client = '';
                $error = $original;
            break;
            case 4:
                $date = cleanup($line[0]);
		$type = cleanup($line[1]);
		$pidTid = explode(':',$line[2]);
		$pid = cleanup($pidTid[0]);
		$tid = cleanup($pidTid[1]);
                $client = '';
                $error = $original;
            break;
            case 5:
                $date = cleanup($line[0]);
		$type = cleanup($line[1]);
		$pidTid = explode(':',$line[2]);
                $pid = cleanup($pidTid[0]);
                $tid = cleanup($pidTid[1]);
                $client = cleanup($line[3]);
                $error = $original;
            break;
            default:
                $date = cleanup($line[0]);
		$type = cleanup($line[1]);
		$pidTid = explode(':',$line[2]);
                $pid = cleanup($pidTid[0]);
                $tid = cleanup($pidTid[1]);
                $client = '';
                $error = $original;
            break;
        }

        $return[] = [
            $date,
            $type,
	    $pid,
	    $tid,
            $client,
            $error
        ];
    }

    return $return;
}

// use it by
$lines = readLastLines("error.log", 1000, true);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Development Environment Logs</title>

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
	overflow: scroll;
	max-height: 100px;
    }

    footer {
        background: #eee;
        min-height: 3rem;
        padding: 1rem;
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
                            <a href="error.php" class="nav-link active" aria-current="page">
                            <i class="bi bi-bug"></i>
                            Error Logs
                            </a>
                        </li>
                        <li>
                            <a href="deploy.php" class="nav-link link-dark">
                            <i class="bi bi-code-slash"></i>
                            Deploy Scripts Logs
                            </a>
                        </li>
                        <li>
                            <hr>
                        </li>
                        <li>
                            <a href="http://deploy.dev.intakedesk.net" class="nav-link" target="__blank">
                            <i class="bi bi-cloud-check"></i>
                            Deploy Scripts
                            </a>
                        </li>
                        <li>
                            <a href="http://dev.intakedesk.net/update.php" class="nav-link" target="__blank">
                            <i class="bi bi-ui-checks"></i>
                            Enable Environment
                            </a>
                        </li>
                        <!-- li>
                            <a href="mysql.php" class="nav-link link-dark">
                            <i class="bi bi-hdd"></i>
                            MySQL Logs
                            </a>
                        </li -->
                    </ul>
                </div>
            </div>

            <div class="col py-3">
                <main role="main">
                    <div class="">
                        <!-- Example row of columns -->
                        <div class="row env-list" id="env-list">
                            <h2>Access Log</h2>
                            <table id="log" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
					    <th>Pid</th>
					    <th>Tid</th>
                                            <th>Client</th>
                                            <th>Error</th>
                                        </tr>
                                    </thead>

                            </table>
                        </div>

                        <hr>

                    </div> <!-- /container -->

                </main>
            </div>

        </div>

        <footer>
            <hr>
            <p>&copy; IntakeDesk 2024</p>
        </footer>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            var dataSet = <?php echo json_encode($lines); ?>

            $('#log').DataTable({
                columns: [
                    {title: 'Date'},
                    {title: 'Type'},
	            {title: 'Pid'},
                    {title: 'Tid'},
                    {title: 'Client'},
                    {title: 'Error'},
                ],
                columnDefs: [
                    {width: '50%', target: 5}
                ],
                order: [
                    [0, 'desc']
                ],
                data: dataSet,
                pageLength: 50
            });
        } );
    </script>

  </body>
</html>

<?php

/**
 * Helper method to clean up the data coming in from the logs.
 *
 * @param string $str
 * @return string
 */
function cleanup(string $str) : string {
    trim($str);
    $str = str_replace(['[',']','pid'],'',$str);
    return $str;
}

/**
 * Parser method to read the file in reverse and fill up the log lines.
 * 
 * @param string $filename
 * @param int $num
 * @param bool $reverse
 * @return array
 */
function readLastLines(string $filename, int $num, bool $reverse = false) : array
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

        $log = explode('"', $line);
        $agentAndDate = explode('[', $log[0]);
        $codeAndLenght = explode(' ', $log[2]);
        $urlAndRest = explode(' ', $log[1]);

        $url_0 = isset($urlAndRest[0]) ? $urlAndRest[0] : '';
        $url_1 = isset($urlAndRest[1]) ? $urlAndRest[1] : '';
        $code_1 = isset($codeAndLenght[1]) ? $codeAndLenght[1] : '';
        $code_2 = isset($codeAndLenght[2]) ? $codeAndLenght[2] : 1;
        

        $return[] = [
            cleanup($agentAndDate[0]),
            cleanup($agentAndDate[1]),
            cleanup($url_0),
            cleanup($url_1),
            cleanup($code_1),
            round(($code_2/1000),1) . ' Kb',
        ];
    }

    return $return;
}

$lines = readLastLines("/var/www/html/logs/httpd-access.log", 1000, true);
?>
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
                            <a href="access.php" class="nav-link active" aria-current="page">
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
                    <div class="">
                        <!-- Example row of columns -->
                        <div class="row env-list" id="env-list">
                            <h2>Access Logs</h2>
                            <table id="log" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Agent</th>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>URL</th>
                                            <th>HTTP Response Code</th>
                                            <th>Size</th>
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

    <script>
        $(document).ready( function () {
            var dataSet = <?php echo json_encode($lines); ?>

            $('#log').DataTable({
                columns: [
                    {title: 'Agent'},
                    {title: 'Date'},
                    {title: 'Type'},
                    {title: 'Url'},
                    {title: 'HTTP Code'},
                    {title: 'Size'}
                ],
                columnDefs: [
                    {width: '60%', target: 3}
                ],
                order: [
                    [1, 'desc']
                ],
                data: dataSet,
                pageLength: 50
            });
        } );
    </script>

  </body>
</html>

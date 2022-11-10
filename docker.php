<?php function dockerise() {
    $id = shell_exec("docker run --network none --security-opt no-new-privileges --cap-drop ALL -dit python");
    $name = shell_exec("docker inspect --format '{{.Name}}' $id");
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $name = substr($name, 2, strlen($name) - 4);
    } else {
        $name = substr($name, 1, strlen($name) - 2);
    }
    $time_start = microtime(true);
    $output = shell_exec("docker exec -i $name timeout 4 python < pycode.py 2>&1");
    $time_end = microtime(true);
    $exec_time = $time_end - $time_start;
    if (strlen($output) > 500) {
        $output = substr($output, 0, 500);
        echo "<p class='text-danger fw-bold'>Output Limit Exceeded! Allowed output length: 500 characters</p>";
    }
    if ($exec_time > 5) {
        echo "<p class='text-danger fw-bold'>Execution Timed Out! Allowed execution time per run: 5 seconds</p>";
    }
    echo "Execution time: $exec_time secs<pre class='h6 overflow-auto mt-3' style='height: 200px;'>$output</pre>";
    shell_exec("docker rm -f $name");
}

if (!empty($_GET["pycode"])) {
    file_put_contents("pycode.py", $_GET["pycode"]);
    dockerise();
    unlink("pycode.py");
}?>

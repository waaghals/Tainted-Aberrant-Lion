<?php

$repo_url = "https://github.com/waaghals/Tainted-Aberrant-Lion.git";
$virtual_host_dir = "/var/www/tal/";
$valid_branches = array("master", "dev");

ignore_user_abort(true);

function syscall($cmd, $cwd) {
    $descriptorspec = array(
        1 => array('pipe', 'w'), // stdout is a pipe that the child will write to
        2 => array('pipe', 'w') // stderr
    );
    $resource = proc_open($cmd, $descriptorspec, $pipes, $cwd);
    if (is_resource($resource)) {
        $output = stream_get_contents($pipes[2]);
        $output .= PHP_EOL;
        $output .= stream_get_contents($pipes[1]);
        $output .= PHP_EOL;
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($resource);
        return $output;
    }
}

function git_current_branch($cwd) {
    $result = syscall('git branch', $cwd);
    if (preg_match('/\\* (.*)/', $result, $matches)) {
        return $matches[1];
    }
}

$request_body = @file_get_contents('php://input');
$payload_exists = !empty($request_body);
echo "Checking if payload exists: " . $payload_exists . "\n";
if ($payload_exists) {
    echo "Decoding JSON\n";
    $payload = json_decode($request_body);

    // which branch was committed?
    $branch = substr($payload->ref, strrpos($payload->ref, '/') + 1);
    echo "Receiving post_receive for: " . $branch . "\n";

    if (!in_array($branch, $valid_branches)) {
        die("Ignoring " + $branch + " because it is not master nor dev.\n");
    }

    $virtual_host = $branch;
    if ($branch == "master") {
        $virtual_host = "stable";
    }

    $virtual_host_folder = $virtual_host_dir . $virtual_host;
    echo "Virtual host folder for branch \"" . $branch . "\" is " . $virtual_host_folder . "\n";
    $exists = is_dir($virtual_host_folder);
    echo "Checking if repository destination exists: " . $exists . "\n";

    if (!$exists) {
        // repo does not exitst
        $clone_cmd = sprintf("sudo git clone %s %s", $repo_url, $virtual_host);

        echo syscall($clone_cmd, $virtual_host_dir);
    }

    // switch to the correct branch
    $correct_branch = ($branch == git_current_branch($virtual_host_folder));
    echo "Checking correct branch: " . $correct_branch . "\n";
    if (!$correct_branch) {
        $cmd = sprintf("sudo git checkout %s", $branch);
        echo syscall($cmd, $virtual_host_folder);
    }

    // Reset any made changed on the server, this isn't the place for development
    echo "Forcing repository reset\n";
    echo syscall("sudo git reset --hard", $virtual_host_folder);

    // pull from $branch
    echo "Pulling repository\n";
    $cmd = sprintf('sudo git pull origin %s', $branch);
    echo syscall($cmd, $virtual_host_folder);
}

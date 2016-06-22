<?php
$servername = "DESKTOP-05D9CV7";
$username = "kingsman142";
$password = "abcd";
$dbname = "skillsset";
$tablename = "skills";

$conn = new mysqli($servername, $username, $password, $dbname);

$functionCall = null;;
$skill = null;
$job = null;

if(isset($_GET['function'])){
    $functionCall = filter_input(INPUT_GET, 'function');
}

switch($functionCall){
    case 'updateDatabase':
        updateDatabase();
        break;
    default:
        break;
}

function updateDatabase(){
    global $tablename, $conn, $skill, $job;
    $skill = filter_input(INPUT_GET, 'skill');
    $job = filter_input(INPUT_GET, 'job');

    $sql = "SELECT 1 FROM $tablename
            WHERE skill = '$skill' 
            AND job = '$job'";

    echo "<br/>Count: " . $conn->query($sql)->num_rows;

    if($conn->query($sql)->num_rows > 0){
        echo "<br/>Updating skill.";
        $sql = "UPDATE $tablename
                SET count = count+1
                WHERE skill = '$skill'
                AND job = '$job'";
        $conn->query($sql);
    } else if($conn->query($sql)->num_rows == 0){
        echo "<br/>Adding skill.";
        $sql = "INSERT INTO $tablename (skill, job, count)
                VALUES ('$skill', '$job', 1)";
        $conn->query($sql);
    }
}

function topFiveJobs(){
    global $tablename, $conn;
    $sql = "SELECT job, SUM(count) AS total FROM $tablename
            GROUP BY job
            ORDER BY total DESC, job DESC
            LIMIT 5";
    $jobs = mysql_fetch_assoc($conn->query($sql));
    foreach($jobs as $value){
        echo "Job: " . $value;
    }
}

$conn->close();
?>
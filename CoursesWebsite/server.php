<?php
$servername = "DESKTOP-05D9CV7";
$username = "kingsman142";
$password = "abcd";
$dbname = "skillsset";
$tablename = "skills";

$conn = new mysqli($servername, $username, $password, $dbname);

$functionCall = isset($_GET['function']) ? filter_input(INPUT_GET, 'function') : null;
$skill = isset($_GET['skill']) ? filter_input(INPUT_GET, 'skill') : null;
$job = isset($_GET['job']) ? filter_input(INPUT_GET, 'job') : null;

switch($functionCall){
    case 'updateDatabase':
        updateDatabase();
        break;
    case 'topFiveJobs':
        topFiveJobs();
        break;
    case 'topFiveSkills':
        topFiveSkills();
        break;
    case 'associatedJobs':
        getAssociatedJobs($skill);
        break;
    case 'associatedSkills':
        getAssociatedSkills($job);
        break;
    case 'searchForSkill':
        searchForSkill();
        break;
    case 'searchForJob':
        searchForJob();
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
            LIMIT 10";
    $jobs = $conn->query($sql);
    $returnString = "";
    foreach($jobs as $row){
        $returnString .= $row['job'] . ":" . $row['total'] . ",";
    }
    echo $returnString;
}

function topFiveSkills(){
    global $tablename, $conn;
    $sql = "SELECT skill, SUM(count) as total FROM $tablename
            GROUP BY skill
            ORDER BY total DESC, skill DESC
            LIMIT 10";
    $skills = $conn->query($sql);
    $returnString = "";
    foreach($skills as $row){
        $returnString .= $row['skill'] . ":" . $row['total'] . ",";
    }

    echo $returnString;
}

function getAssociatedJobs(){
    global $tablename, $conn, $skill;
    $sql = "SELECT job FROM $tablename
            WHERE skill = '$skill'";
    $associatedJobs = $conn->query($sql);
    $returnString = "";
    foreach($associatedJobs as $row){
        $returnString .= $row['job'] . ",";
    }

    echo $returnString;
}

function getAssociatedSkills(){
    global $tablename, $conn, $job;

    $sql = "SELECT skill FROM $tablename
            WHERE job = '$job'";
    $associatedSkills = $conn->query($sql);
    $returnString = "";
    foreach($associatedSkills as $row){
        $returnString .= $row['skill'] . ",";
    }

    echo $returnString;
}

function searchForJob(){
    global $tablename, $conn, $job;

    $sql = "SELECT COUNT(*) AS numResults FROM $tablename
            WHERE job = '$job'";
    $results = $conn->query($sql);
    $returnRow = mysqli_fetch_row($results);
    $numResults = $returnRow[0];
    echo $numResults;

}

function searchForSkill(){
    global $tablename, $conn, $skill;

    $sql = "SELECT COUNT(*) AS numResults FROM $tablename
            WHERE skill = '$skill'";
    $results = $conn->query($sql);
    $returnRow = mysqli_fetch_row($results);
    $numResults = $returnRow[0];
    echo $numResults;
}

$conn->close();
?>
<?php
$servername = "DESKTOP-05D9CV7";
$username = "kingsman142";
$password = "abcd";
$dbname = "skillsset";
$dataTable = "job_skill_data";
$jobIndexTable = "job_index";
$skillIndexTable = "skill_index";

$conn = new mysqli($servername, $username, $password, $dbname);

$functionCall = isset($_GET['function']) ? filter_input(INPUT_GET, 'function') : null;
$skill = isset($_GET['skill']) ? filter_input(INPUT_GET, 'skill') : null;
$job = isset($_GET['job']) ? filter_input(INPUT_GET, 'job') : null;
$salary = isset($_GET['salary']) ? filter_input(INPUT_GET, 'salary') : null;

switch($functionCall){
    case 'UpdateDatabase':
        updateDatabase();
        break;
    case 'GetTopFiveJobs':
        GetTopFiveJobs();
        break;
    case 'GetTopFiveSkills':
        GetTopFiveSkills();
        break;
    case 'GetAssociatedJobs':
        GetAssociatedJobs($skill);
        break;
    case 'GetAssociatedSkills':
        GetAssociatedSkills($job);
        break;
    case 'SearchForSkill':
        SearchForSkill();
        break;
    case 'SearchForJob':
        SearchForJob();
        break;
    case 'GetAverageSalary':
        GetAverageSalary();
        break;
    default:
        break;
}

function UpdateDatabase(){
    global $dataTable, $jobIndexTable, $skillIndexTable, $conn, $skill, $job, $salary;

    if(empty($salary)) $salary = 0;

    $sql = "INSERT INTO $jobIndexTable (job)
            SELECT '$job'
            WHERE NOT EXISTS (SELECT '$job' FROM $jobIndexTable
                              WHERE job = '$job')";
    $conn->query($sql);

    $sql = "INSERT INTO $skillIndexTable (skill)
            SELECT '$skill'
            WHERE NOT EXISTS (SELECT '$skill' FROM $skillIndexTable
                              WHERE job = '$skill')";
    $conn->query($sql);

    $sql = "INSERT INTO $dataTable (job_id, skill_id, salary)
            VALUES ((SELECT job_id FROM $jobIndexTable WHERE job = '$job'),
		            (SELECT skill_id FROM $skillIndexTable WHERE skill = '$skill'),
                    $salary)";
    $conn->query($sql);
}

function GetTopFiveJobs(){
    global $dataTable, $conn;
    $sql = "SELECT job, SUM(count) AS total FROM $dataTable
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

function GetTopFiveSkills(){
    global $dataTable, $conn;
    $sql = "SELECT skill, SUM(count) as total FROM $dataTable
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

function GetAssociatedJobs(){
    global $dataTable, $conn, $skill;

    $sql = "SELECT SUM(count) AS total_entries
            FROM skills
            WHERE skill='$skill'";
    $total_entries = mysqli_fetch_row($conn->query($sql))[0];

    $sql = "SELECT job, count FROM $dataTable
            WHERE skill = '$skill'
            ORDER BY count DESC";
    $associatedJobs = $conn->query($sql);
    $returnString = "";
    foreach($associatedJobs as $row){
        $returnString .= $row['job'] . " (" . round($row['count']/$total_entries, 2)*100 . "%),";
    }

    echo $returnString;
}

function GetAssociatedSkills(){
    global $dataTable, $conn, $job;

    $sql = "SELECT SUM(count) AS total_entries
            FROM skills
            WHERE job='$job'";
    $total_entries = mysqli_fetch_row($conn->query($sql))[0];

    $sql = "SELECT skill, count FROM $dataTable
            WHERE job = '$job'
            ORDER BY count DESC";
    $associatedSkills = $conn->query($sql);
    $returnString = "";
    foreach($associatedSkills as $row){
        $returnString .= $row['skill'] . " (" . round($row['count']/$total_entries, 2)*100 . "%),";
    }

    echo $returnString;
}

function GetAverageSalary(){
    global $dataTable, $conn, $job, $skill;

    $sql = null;

    if(!empty($skill)){
        $sql = "SELECT ROUND(SUM((average_salary)*salary_entries)/SUM(salary_entries), 2) AS average_salary
                FROM skills
                WHERE skill='$skill'";
    } else if(!empty($job)){
        $sql = "SELECT ROUND(SUM((average_salary)*salary_entries)/SUM(salary_entries), 2) AS average_salary
                FROM skills
                WHERE job='$job'";
    }

    if($sql != null){
        $avg_salary = mysqli_fetch_row($conn->query($sql))[0];

        if($avg_salary > 0) echo "$avg_salary";
        else echo "No salary data available";
    } else{
        echo 5;
        echo "No salary data available";
    }
}

function SearchForJob(){
    global $dataTable, $conn, $job;

    $sql = "SELECT COUNT(*) AS numResults FROM $dataTable
            WHERE job = '$job'";
    $results = $conn->query($sql);
    $returnRow = mysqli_fetch_row($results);
    $numResults = $returnRow[0];
    echo $numResults;

}

function SearchForSkill(){
    global $dataTable, $conn, $skill;

    $sql = "SELECT COUNT(*) AS numResults FROM $dataTable
            WHERE skill = '$skill'";
    $results = $conn->query($sql);
    $returnRow = mysqli_fetch_row($results);
    $numResults = $returnRow[0];
    echo $numResults;
}

$conn->close();
?>
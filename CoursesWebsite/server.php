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
$skill = isset($_GET['skill']) ? strip_tags(filter_input(INPUT_GET, 'skill')) : null;
$job = isset($_GET['job']) ? strip_tags(filter_input(INPUT_GET, 'job')) : null;
$salary = isset($_GET['salary']) ? strip_tags(filter_input(INPUT_GET, 'salary')) : null;

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
    case 'GetMinimumSalary':
        GetMinimumSalary();
        break;
    case 'GetMaximumSalary':
        GetMaximumSalary();
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
                              WHERE skill = '$skill')";
    $conn->query($sql);

    $sql = "INSERT INTO $dataTable (job_id, skill_id, salary)
            VALUES ((SELECT job_id FROM $jobIndexTable WHERE job = '$job'),
		            (SELECT skill_id FROM $skillIndexTable WHERE skill = '$skill'),
                    $salary)";
    $conn->query($sql);
}

function GetTopFiveJobs(){
    global $dataTable, $jobIndexTable, $conn;
    $sql = "SELECT job, COUNT(*) AS total FROM $dataTable
            JOIN $jobIndexTable ON $jobIndexTable.job_id = $dataTable.job_id
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
    global $dataTable, $skillIndexTable, $conn;
    $sql = "SELECT skill, COUNT(*) as total FROM $dataTable
            JOIN $skillIndexTable ON $skillIndexTable.skill_id = $dataTable.skill_id
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
    global $dataTable, $skillIndexTable, $jobIndexTable, $conn, $skill;

    $sql = "SELECT COUNT(*) AS total_entries FROM $dataTable
            JOIN $skillIndexTable ON $skillIndexTable.skill_id = $dataTable.skill_id
            WHERE skill='$skill'";
    $total_entries = mysqli_fetch_row($conn->query($sql))[0];

    $sql = "SELECT job, COUNT(*) AS count FROM $dataTable
            JOIN $jobIndexTable ON $jobIndexTable.job_id = $dataTable.job_id
            JOIN $skillIndexTable ON $skillIndexTable.skill_id = $dataTable.skill_id
            WHERE skill = '$skill'
            GROUP BY job
            ORDER BY count DESC";
    $associatedJobs = $conn->query($sql);
    $returnString = "";
    foreach($associatedJobs as $row){
        $returnString .= $row['job'] . " (" . round($row['count']/$total_entries, 2)*100 . "%),";
    }

    echo $returnString;
}

function GetAssociatedSkills(){
    global $dataTable, $jobIndexTable, $skillIndexTable, $conn, $job;

    $sql = "SELECT COUNT(*) AS total_entries FROM $dataTable
            JOIN $jobIndexTable ON $jobIndexTable.job_id = $dataTable.job_id
            WHERE job='$job'";
    $total_entries = mysqli_fetch_row($conn->query($sql))[0];

    $sql = "SELECT skill, COUNT(*) AS count FROM $dataTable
            JOIN $jobIndexTable ON $jobIndexTable.job_id = $dataTable.job_id
            JOIN $skillIndexTable ON $skillIndexTable.skill_id = $dataTable.skill_id
            WHERE job = '$job'
            GROUP BY skill
            ORDER BY count DESC";
    $associatedSkills = $conn->query($sql);
    $returnString = "";
    foreach($associatedSkills as $row){
        $returnString .= $row['skill'] . " (" . round($row['count']/$total_entries, 2)*100 . "%),";
    }

    echo $returnString;
}

function GetAverageSalary(){
    global $dataTable, $skillIndexTable, $jobIndexTable, $conn, $job, $skill;

    $sql = null;

    if(!empty($skill)){
        $sql = "SELECT ROUND(SUM(salary)/COUNT(*)) AS average_salary
                FROM $dataTable
                JOIN $skillIndexTable ON $skillIndexTable.skill_id = $dataTable.skill_id
                WHERE skill='$skill'
                AND salary > 0";
    } else if(!empty($job)){
        $sql = "SELECT ROUND(SUM(salary)/COUNT(*)) AS average_salary
                FROM $dataTable
                JOIN $jobIndexTable ON $jobIndexTable.job_id = $dataTable.job_id
                WHERE job='$job'
                AND salary > 0";
    }

    if($sql != null){
        $avg_salary = mysqli_fetch_row($conn->query($sql))[0];

        if($avg_salary > 0) echo "$avg_salary";
        else echo "No salary data available";
    } else{
        echo "No salary data available";
    }
}

function GetMinimumSalary(){
    global $dataTable, $skillIndexTable, $jobIndexTable, $conn, $job, $skill;

    $sql = null;

    if(!empty($skill)){
        $sql = "SELECT MIN(salary) AS min_salary
                FROM $dataTable
                JOIN $skillIndexTable ON $skillIndexTable.skill_id = $dataTable.skill_id
                WHERE skill='$skill'
                AND salary > 0";
    } else if(!empty($job)){
        $sql = "SELECT MIN(salary) AS min_salary
                FROM $dataTable
                JOIN $jobIndexTable ON $jobIndexTable.job_id = $dataTable.job_id
                WHERE job='$job'
                AND salary > 0";
    }

    if($sql != null){
        $min_salary = mysqli_fetch_row($conn->query($sql))[0];

        if(!empty($min_salary)) echo "$min_salary";
        else echo "No salary data available";
    }
}

function GetMaximumSalary(){
    global $dataTable, $skillIndexTable, $jobIndexTable, $conn, $job, $skill;

    $sql = null;

    if(!empty($skill)){
        $sql = "SELECT MAX(salary) AS max_salary
                FROM $dataTable
                JOIN $skillIndexTable ON $skillIndexTable.skill_id = $dataTable.skill_id
                WHERE skill='$skill'";
    } else if(!empty($job)){
        $sql = "SELECT MAX(salary) AS max_salary
                FROM $dataTable
                JOIN $jobIndexTable ON $jobIndexTable.job_id = $dataTable.job_id
                WHERE job='$job'";
    }

    if($sql != null){
        $max_salary = mysqli_fetch_row($conn->query($sql))[0];

        if(!empty($max_salary)) echo "$max_salary";
        else echo "No salary data available";
    }
}

function SearchForJob(){
    global $dataTable, $jobIndexTable, $conn, $job;

    $sql = "SELECT COUNT(*) FROM $dataTable
            JOIN $jobIndexTable ON $jobIndexTable.job_id = $dataTable.job_id
            WHERE job = '$job'
            LIMIT 1";
    $results = $conn->query($sql);
    $returnRow = mysqli_fetch_row($results);
    $numResults = $returnRow[0];
    echo $numResults;

}

function SearchForSkill(){
    global $dataTable, $skillIndexTable, $conn, $skill;

    $sql = "SELECT COUNT(*) AS numResults FROM $dataTable
            JOIN $skillIndexTable ON $skillIndexTable.skill_id = $dataTable.skill_id
            WHERE skill = '$skill'
            LIMIT 1";
    $results = $conn->query($sql);
    $returnRow = mysqli_fetch_row($results);
    $numResults = $returnRow[0];
    echo $numResults;
}

$conn->close();
?>
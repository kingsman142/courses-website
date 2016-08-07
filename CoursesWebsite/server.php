<?php
$servername = "DESKTOP-05D9CV7";
$username = "kingsman142";
$password = "abcd";
$dbname = "skillsset";
$dataTablename = "job_skill_data";
$jobIndexTablename = "job_index";
$skillIndexTablename = "skill_index";

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
    global $dataTablename, $conn, $skill, $job, $salary;

    $sql = "SELECT 1 FROM $dataTablename
            WHERE skill = '$skill'
            AND job = '$job'";

    $numRows = $conn->query($sql)->num_rows;

    echo "<br/>Count: " . $numRows;

    if($numRows == 1){
        echo "<br/>Updating entry.";
        $sql = "UPDATE $dataTablename
                SET count = count+1
                WHERE skill = '$skill'
                AND job = '$job';";
        $conn->query($sql);

        if(!empty($salary)){
            $sql = "UPDATE $dataTablename
                    SET average_salary=(salary_entries*average_salary + $salary)/(salary_entries+1)
                    WHERE skill = '$skill'
                    AND job = '$job';";
            $conn->query($sql);

            $sql = "UPDATE $dataTablename
                    SET salary_entries = salary_entries+1
                    WHERE skill = '$skill'
                    AND job = '$job'";
            $conn->query($sql);
        }
    } else{
        echo "<br/>Adding new entry.";
        if(empty($salary)) $salary = 0;

        $sql = "INSERT INTO $dataTablename (skill, job, count, average_salary, salary_entries)
                VALUES ('$skill', '$job', 1, $salary, 0)";
        $conn->query($sql);
    }
}

function GetTopFiveJobs(){
    global $dataTablename, $conn;
    $sql = "SELECT job, SUM(count) AS total FROM $dataTablename
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
    global $dataTablename, $conn;
    $sql = "SELECT skill, SUM(count) as total FROM $dataTablename
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
    global $dataTablename, $conn, $skill;

    $sql = "SELECT SUM(count) AS total_entries
            FROM skills
            WHERE skill='$skill'";
    $total_entries = mysqli_fetch_row($conn->query($sql))[0];

    $sql = "SELECT job, count FROM $dataTablename
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
    global $dataTablename, $conn, $job;

    $sql = "SELECT SUM(count) AS total_entries
            FROM skills
            WHERE job='$job'";
    $total_entries = mysqli_fetch_row($conn->query($sql))[0];

    $sql = "SELECT skill, count FROM $dataTablename
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
    global $dataTablename, $conn, $job, $skill;

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
    global $dataTablename, $conn, $job;

    $sql = "SELECT COUNT(*) AS numResults FROM $dataTablename
            WHERE job = '$job'";
    $results = $conn->query($sql);
    $returnRow = mysqli_fetch_row($results);
    $numResults = $returnRow[0];
    echo $numResults;

}

function SearchForSkill(){
    global $dataTablename, $conn, $skill;

    $sql = "SELECT COUNT(*) AS numResults FROM $dataTablename
            WHERE skill = '$skill'";
    $results = $conn->query($sql);
    $returnRow = mysqli_fetch_row($results);
    $numResults = $returnRow[0];
    echo $numResults;
}

$conn->close();
?>
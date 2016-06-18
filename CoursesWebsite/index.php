<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Site.css" />
    <title></title>
</head>
<body src="Site.css">
    <div class="column">
        Course
    </div>
    <div class="column">
        Department
    </div>
    <div class="column">
        Instructor
    </div>
    <?php
    $servername = "DESKTOP-05D9CV7";
    $username = "kingsman142";
    $password = "abcd";
    $dbname = "courses";
    $tablename = "coursedata";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql = "CREATE DATABASE Courses";
    $conn->query($sql);

    $sql = "CREATE TABLE $tablename(
                id INT(6) SIGNED AUTO_INCREMENT PRIMARY KEY,
                courseTitle VARCHAR(30) NOT NULL,
                department VARCHAR(30) NOT NULL,
                instructor VARCHAR(30) NOT NULL,
                currentEnrolled INT(6) NOT NULL,
                capacity INT(6) NOT NULL,
                status VARCHAR(30) NOT NULL
                )";
    $conn->query($sql);

    $sql = "INSERT INTO $tablename (coursetitle, department, instructor, currentenrolled, capacity, status)
                VALUES ('Government History', 'HIST', 'Greenberg, Janelle', 3, 10, 'Open')";
    $conn->query($sql);

    $conn->close();
    ?>
</body>
</html>
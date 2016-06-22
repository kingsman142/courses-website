<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Site.css" />
    <script src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <title>Job Explore</title>
</head>
<body src="Site.css">
    <div id="main">
        <center>
        <div class="title" id="jobTitle">Job</div>
        <div class="title" id="exploreTitle">Explore</div>
        </center>

        <div id="formsDiv">
            <div class="formText job">Occupation</div>
            <div class="formText skill">Skill</div></br>
            <input class="form job" placeholder="Occupation"/>
            <input class="form skill" placeholder="Skill"/><br/>
            <button type="submit" value="Update Database" id="updateDatabase" onclick="updateDatabase(); getTopFiveJobs();">Update Database</button>
        </div>
    </div>
</body>
</html>
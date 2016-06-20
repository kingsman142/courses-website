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
        <div id="title"><center>Job Explore</center></div>

        <div id="formsDiv">
            <div class="formText job">Occupation</div>
            <div class="formText skill">Skill</div></br>
            <input class="form job" value="Occupation"/>
            <input class="form skill" value="Skill"/><br/>
            <input type="submit" value="Update Database" id="updateDatabase" onclick="updateDatabase()" />
        </div>
        <!--<button id="next" onclick="location.href = 'index.php'">Next</button>-->
    </div>
</body>
</html>
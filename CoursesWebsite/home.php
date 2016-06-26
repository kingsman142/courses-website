<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Site.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="script.js"></script>
        <title>Job Explore</title>
    </head>
    <body src="Site.css">
        <div id="main">
            <center>
            <div class="title" id="jobTitle">Job</div>
            <div class="title" id="exploreTitle">Explore</div>
            </center>

            <div id="formsWrapper">
                <div class="formText job">Occupation</div>
                <div class="formText skill">Skill</div></br>
                <input class="form job" placeholder="Occupation"/>
                <input class="form skill" placeholder="Skill"/><br/>
                <button type="submit" value="Update Database" id="updateDatabase" onclick="updateDatabase()">Update Database</button>
            </div>

            <div id="tableWrapper">
                <table id="jobStatsTable"><caption align="center">Top Five Jobs</caption><tbody></tbody></table>
                <table id="skillStatsTable"><caption align="center">Top Five Skills</caption><tbody></tbody></table>
            </div>
        </div>
    </body>
</html>
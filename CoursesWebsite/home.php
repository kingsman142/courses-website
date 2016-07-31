<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Site.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="scripts/home.js"></script>
        <script src="scripts/common.js"></script>
        <title>Job Explore</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body src="Site.css">
        <center>
            <div class="title">
                <div id="jobTitle">Job<div id="exploreTitle">Explore</div></div>
            </div>
        </center>

        <div id="menuWrapper">
            <div class="menuItem"><img class="icon" src="images/searchJob.png" /><input type="text" class="searchForm" onkeydown="if(enterKey(event)){ searchForJob() }" placeholder="Search by job" /></div>
            <div class="menuItem"><img class="icon" src="images/searchSkill.png" /><input type="text" class="searchForm" onkeydown="if(enterKey(event)){ searchForSkill() }" placeholder="Search by skill" /></div>
        </div>

        <div id="homeContent">
            <div id="formsWrapper">
                <input class="form job" placeholder="Occupation" />
                <input class="form skill" placeholder="Skill" />
                <br />
                <input type="number" max="999999" class="form salary" placeholder="Salary (yearly)" />
                <br />
                <button type="submit" id="updateDatabase" onclick="updateDatabase()">Help others find a career path!</button>
            </div>
        </div>

        <div id="tableWrapper">
            <table id="jobStatsTable"><caption align="center">Top Five Jobs</caption><tbody></tbody></table>
            <table id="skillStatsTable"><caption align="center">Top Five Skills</caption><tbody></tbody></table>
        </div>
    </body>
</html>
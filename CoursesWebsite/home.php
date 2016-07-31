<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/common.css" />
        <link rel="stylesheet" type="text/css" href="css/home.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="scripts/home.js"></script>
        <script src="scripts/common.js"></script>
        <title>Job Explore</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="menu-wrapper">
            <div class="menu-item"><img class="menu-icon" src="images/searchJob.png" /><input type="text" class="search-input" onkeydown="if(enterKey(event)){ searchForJob() }" placeholder="Search by job" /></div>
            <div class="menu-item"><img class="menu-icon" src="images/searchSkill.png" /><input type="text" class="search-input" onkeydown="if(enterKey(event)){ searchForSkill() }" placeholder="Search by skill" /></div>
        </div>

        <div class="main">
            <div class="title">
                <div id="job-title">Job</div>
                <div id="explore-title">Explore</div>
            </div>

            <div id="forms-wrapper">
                <input class="new-entry-input job-input" placeholder="Occupation" />
                <input class="new-entry-input skill-input" placeholder="Skill" />
                <br />
                <input type="number" max="999999" min="0" class="new-entry-input salary-input" placeholder="Salary (yearly)" />
                <br />
                <button type="submit" id="update-database" onclick="updateDatabase()">Help others find a career path!</button>
            </div>
        </div>

        <div id="table-wrapper">
            <table id="job-stats-table"><caption align="center">Top Five Jobs</caption><tbody></tbody></table>
            <table id="skill-stats-table"><caption align="center">Top Five Skills</caption><tbody></tbody></table>
        </div>
    </body>
</html>
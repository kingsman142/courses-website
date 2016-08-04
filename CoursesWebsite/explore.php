<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/common.css" />
        <link rel="stylesheet" type="text/css" href="css/index.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="scripts/index.js"></script>
        <script src="scripts/common.js"></script>
        <title>Job Explore</title>
    </head>
    <body>
        <center>
            <div class="main">
                <div class="title">
                    <?php
                    $jobOrSkill = "";
                    $data = "";
                    if($_GET['job']){
                        $jobOrSkill = "Job";
                        $data = $_GET['job'];
                    } else{
                        $jobOrSkill ="Skill";
                        $data = $_GET['skill'];
                    }

                    echo '<div id="index-title"><span>' . $jobOrSkill . '</span>: <b>' . $data . '</b></div>';
                    ?>
                </div>

                <div class="column" id="left-column">
                    <div class="content-card green" id="associated-tags">
                        <div class="card-title">
                        <?php
                            $tagText = "";
                            if($jobOrSkill == "Job"){
                                $tagText = "skills";
                            } else if($jobOrSkill == "Skill"){
                                $tagText = "jobs";
                            } else{
                                $tagText = "tags";
                            }

                            echo "Most popular tagged " . $tagText;
                        ?>
                        </div>
                    </div>

                    <div class="content-card red" id="average-salary">
                        <div class="card-title">Average salary</div>
                    </div>
                </div>

                <div class="column" id="middle-column">
                    <div class="content-card purple" id="insert-new-entry">
                        <div class="card-title">Insert a new entry</div>
                        <div id="forms-wrapper">
                            <input class="new-entry-input job-input" placeholder="Occupation" />
                            <input class="new-entry-input skill-input" placeholder="Skill" />
                            <input type="number" max="999999" min="0" class="new-entry-input salary-input" placeholder="Salary (yearly)" />
                            <button type="submit" id="update-database" onclick="updateDatabase()">Help others find a career path!</button>
                        </div>
                    </div>
                </div>

                <div class="column" id="right-column">
                    <a class="twitter-timeline" href="https://twitter.com/CAREEREALISM" data-height="849px" data-chrome="noscrollbar noheader nofooter noborders" data-theme="light">Tweets by LaddersInc</a>
                    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
                </div>
            </div>
        </center>

        <div id="menu-wrapper">
            <div class="menu-item"><img class="menu-icon" src="images/searchJob.png" /><input type="text" class="search-input" onkeydown="if(enterKey(event)){ searchForJob() }" placeholder="Search by job" /></div>
            <div class="menu-item"><img class="menu-icon" src="images/searchSkill.png" /><input type="text" class="search-input" onkeydown="if(enterKey(event)){ searchForSkill() }" placeholder="Search by skill" /></div>
            <div class="menu-item"><img class="menu-icon" src="images/home.png" /><a type="submit" id="home-link" href="index.html">Home</a></div>
        </div>

        <div id="table-wrapper">
        
        </div>
    </body>
</html>

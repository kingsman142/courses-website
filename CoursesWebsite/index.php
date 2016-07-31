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
    <body src="Site.css">
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

                    echo '<div id="indexTitle"><span>' . $jobOrSkill . '</span>: <b>' . $data . '</b></div>';
                    ?>
                </div>

                <div class="column" id="leftColumn">
                    <div class="contentCard green" id="associatedTags">
                        <div class="cardTitle">
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

                    <div class="contentCard red" id="averageSalary">
                        <div class="cardTitle">Average salary</div>
                    </div>
                </div>

                <div class="column" id="middleColumn">
                    <div class="contentCard purple" id="insertNewEntry">
                        <div class="cardTitle">Insert a new entry</div>
                        <div id="formsWrapper">
                            <input class="form job" placeholder="Occupation" />
                            <input class="form skill" placeholder="Skill" />
                            <input type="number" max="999999" min="0" class="form salary" placeholder="Salary (yearly)" />
                            <button type="submit" id="updateDatabase" onclick="updateDatabase()">Help others find a career path!</button>
                        </div>
                    </div>
                </div>

                <div class="column" id="rightColumn">
                    <a class="twitter-timeline" href="https://twitter.com/CAREEREALISM" data-height="849px" data-chrome="noscrollbar noheader nofooter noborders" data-theme="light">Tweets by LaddersInc</a>
                    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
                </div>
            </div>
        </center>

        <div id="menuWrapper">
            <div class="menuItem"><img class="icon" src="images/searchJob.png" /><input type="text" class="searchForm" onkeydown="if(enterKey(event)){ searchForJob() }" placeholder="Search by job" /></div>
            <div class="menuItem"><img class="icon" src="images/searchSkill.png" /><input type="text" class="searchForm" onkeydown="if(enterKey(event)){ searchForSkill() }" placeholder="Search by skill" /></div>
            <div class="menuItem"><img class="icon" src="images/home.png" /><a type="submit" id="homeLink" href="home.php">Home</a></div>
        </div>

        <div id="tableWrapper">

        </div>
    </body>
</html>

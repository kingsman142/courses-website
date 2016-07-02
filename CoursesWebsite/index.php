<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Site.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="index.js"></script>
        <title>Job Explore</title>
    </head>
    <body src="Site.css">
            <center>
                <div id="main">
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

                        echo '<div id="indexTitle">' . $jobOrSkill . ': <b>' . $data . '</b></div>';
                        ?>
                    </div>

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
                </div>
            </center>

            <div id="menuWrapper">

            </div>

            <div id="tableWrapper">

            </div>
    </body>
</html>

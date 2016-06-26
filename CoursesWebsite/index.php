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
            <center><?php
                $jobOrSkill = "";
                if($_GET['job']){
                    $jobOrSkill = "Job";
                } else{
                    $jobOrSkill ="Skill";
                }

                echo '<div style="font-family: MyriadPro">' . $jobOrSkill . '</div>'; 
            ?></center>
        </div>
    </body>
</html>

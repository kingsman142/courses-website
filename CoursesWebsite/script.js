function updateDatabase() {
    var job = $('.form.job')[0].value;
    var skill = $('.form.skill')[0].value;
    document.getElementById("updateDatabase").disabled = "disabled";
    $.ajax({
        url: 'server.php?function=updateDatabase&skill=' + skill + '&job=' + job,
        type: 'GET',
        success: function (output) {
            console.log("Output: " + output);
            document.getElementById("updateDatabase").disabled = "enabled";
        }
    });
}

function getTopFiveJobs() {
    $.ajax({
        url: 'server.php?function=topFiveJobs',
        type: 'GET',
        contentType: 'application/json',
        success: function (output) {
            var jobsArr = output.split(',');
            console.log("Output: " + jobsArr[1]);
            //console.log("job: " + output.total);
        }
    });
}

function getTopFiveSkills() {

}
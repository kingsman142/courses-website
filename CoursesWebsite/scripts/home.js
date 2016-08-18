function getTopFiveJobs() {
    $.ajax({
        url: 'server.php?function=GetTopFiveJobs',
        type: 'GET',
        success: function (output) {
            var jobsArr = output.split(',');
            var jobRows = output.split(',');
            var jobStatsTable = $("#job-stats-table")[0];

            if (jobRows.length >= 2) {
                for (var i = 0; i < jobRows.length - 1; i++) {
                    var rowData = jobRows[i].split(':');
                    var rowJob = rowData[0];
                    var rowCount = rowData[1];
                    if (jobStatsTable.children.length >= 2) {
                        var newTableRow = jobStatsTable.children[1].insertRow(i);
                    }

                    var jobEntry = newTableRow.insertCell(0);
                    jobEntry.innerHTML = '<a href="explore.php?job=' + rowJob + '">' + rowJob + '</a>';

                    var countEntry = newTableRow.insertCell(1);
                    countEntry.innerHTML = rowCount;
                }
            }
        }
    });
}

function getTopFiveSkills() {
    $.ajax({
        url: 'server.php?function=GetTopFiveSkills',
        type: 'GET',
        success: function (output) {
            var skillsArr = output.split(',');
            var skillRows = output.split(',');
            var skillStatsTable = $("#skill-stats-table")[0];

            if (skillRows.length >= 2) {
                for (var i = 0; i < skillRows.length - 1; i++) {
                    var rowData = skillRows[i].split(':');
                    var rowSkill = rowData[0];
                    var rowCount = rowData[1];
                    if (skillStatsTable.children.length >= 2) {
                        var newTableRow = skillStatsTable.children[1].insertRow(i);
                    }

                    var skillEntry = newTableRow.insertCell(0);
                    skillEntry.innerHTML = '<a href="explore.php?skill=' + rowSkill + '">' + rowSkill + '</a>';

                    var countEntry = newTableRow.insertCell(1);
                    countEntry.innerHTML = rowCount;
                }
            }
        }
    })
}

$(function () {
    $(".new-entry-input").on("keyup", function () {
        if (this.value.trim().length) {
            if ($(this).hasClass("job-input")) $("#occupation-required-text")[0].style.visibility = "hidden";
            else if ($(this).hasClass("skill-input")) $("#skill-required-text")[0].style.visibility = "hidden";
        } else {
            if ($(this).hasClass("job-input")) $("#occupation-required-text")[0].style.visibility = "visible";
            else if ($(this).hasClass("skill-input")) $("#skill-required-text")[0].style.visibility = "visible";
        }
    });
});

$(document).ready(function () {
    getTopFiveJobs();
    getTopFiveSkills();
});
﻿function updateDatabase() {
    var job = $('.form.job')[0].value;
    var skill = $('.form.skill')[0].value;
    document.getElementById("updateDatabase").disabled = true;
    $.ajax({
        url: 'server.php?function=updateDatabase&skill=' + skill + '&job=' + job,
        type: 'GET',
        success: function (output) {
            document.getElementById("updateDatabase").disabled = false;
        }
    });
}

function getTopFiveJobs() {
    $.ajax({
        url: 'server.php?function=topFiveJobs',
        type: 'GET',
        success: function (output) {
            var jobsArr = output.split(',');
            var jobRows = output.split(',');
            var jobStatsTable = document.getElementById("jobStatsTable");

            for (var i = 0; i < jobRows.length-1; i++) {
                var rowData = jobRows[i].split(':');
                var rowJob = rowData[0];
                var rowCount = rowData[1];
                var newTableRow = jobStatsTable.children[1].insertRow(i);

                var jobEntry = newTableRow.insertCell(0);
                jobEntry.innerHTML = '<a href="index.php?job=' + rowJob + '">' + rowJob + '</a>';

                var countEntry = newTableRow.insertCell(1);
                countEntry.innerHTML = rowCount;
            }
        }
    });
}

function getTopFiveSkills() {
    $.ajax({
        url: 'server.php?function=topFiveSkills',
        type: 'GET',
        success: function (output) {
            var skillsArr = output.split(',');
            var skillRows = output.split(',');
            var skillStatsTable = document.getElementById("skillStatsTable");

            for (var i = 0; i < skillRows.length-1; i++) {
                var rowData = skillRows[i].split(':');
                var rowSkill = rowData[0];
                var rowCount = rowData[1];
                var newTableRow = skillStatsTable.children[1].insertRow(i);

                var skillEntry = newTableRow.insertCell(0);
                skillEntry.innerHTML = '<a href="index.php?skill=' + rowSkill + '">' + rowSkill + '</a>';

                var countEntry = newTableRow.insertCell(1);
                countEntry.innerHTML = rowCount;
            }
        }
    })
}

$(document).ready(function () {
    getTopFiveJobs();
    getTopFiveSkills();
});
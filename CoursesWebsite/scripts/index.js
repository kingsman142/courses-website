function getAssociatedJobs() {
    var skill = $("#index-title b")[0].innerHTML;

    $.ajax({
        url: 'server.php?function=GetAssociatedJobs&skill=' + skill,
        type: 'GET',
        success: function (output) {
            var associatedJobs = output.split(',');
            var contentCard = $("#associated-tags");

            for (var i = 0; i < associatedJobs.length - 1; i++) {
                if (associatedJobs[i] != "") {
                    var newTag = document.createElement("a");
                    newTag.href = "index.php?job=" + associatedJobs[i];
                    newTag.className = "content-tag dark-green";
                    newTag.innerHTML = associatedJobs[i];
                    contentCard.append(newTag);
                }
            }
        }
    });
}

function getAssociatedSkills() {
    var job = $("#index-title b")[0].innerHTML;

    $.ajax({
        url: "server.php?function=GetAssociatedSkills&job=" + job,
        type: 'GET',
        success: function (output) {
            var associatedSkills = output.split(',');
            var contentCard = $("#associated-tags");

            for (var i = 0; i < associatedSkills.length - 1; i++) {
                if (associatedSkills[i] != "") {
                    var newTag = document.createElement("a");
                    newTag.href = "index.php?skill=" + associatedSkills[i];
                    newTag.className = "content-tag dark-green";
                    newTag.innerHTML = associatedSkills[i];
                    contentCard.append(newTag);
                }
            }
        }
    });
}

function getAssociatedTags() {
    var queriesFromQueryString = window.location.search.split(/[?&=]/);
    queriesFromQueryString.shift();

    if (queriesFromQueryString.length >= 2) {
        if (queriesFromQueryString[0] == "job") {
            getAssociatedSkills();
        } else if (queriesFromQueryString[0] == "skill") {
            getAssociatedJobs();
        }
    }
}

function getAverageSalary() {
    var jobOrSkill = $("#index-title span")[0].innerHTML;
    var jobOrSkillValue = $("#index-title b")[0].innerHTML;

    $.ajax({
        url: "server.php?function=GetAverageSalary&" + jobOrSkill.toLowerCase() + "=" + jobOrSkillValue,
        type: "GET",
        success: function (output) {
            var salaryContentCard = $("#average-salary");
            output = parseInt(output);

            if (salaryContentCard) {
                var salaryDiv = document.createElement("div");
                salaryDiv.id = "salary-value";
                if (output > 0) salaryDiv.innerHTML = "$" + output.toLocaleString();
                else salaryDiv.innerHTML = output;
                salaryContentCard.append(salaryDiv);
            }
        }
    });
}

function setUpNewEntryForms() {
    var jobOrSkill = $("#index-title span")[0].innerHTML;

    var inputForm = $(".new-entry-input." + jobOrSkill.toLowerCase() +  "-input");

    if (inputForm.length > 0) {
        var jobOrSkillValue = $("#index-title b")[0].innerHTML;
        inputForm = inputForm[0];
        inputForm.value = jobOrSkillValue;
    }
}

$(document).ready(function () {
    getAssociatedTags();
    getAverageSalary();
    setUpNewEntryForms();
});
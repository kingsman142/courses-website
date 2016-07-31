function getAssociatedJobs() {
    var skill = $("#index-title b")[0].innerHTML;

    $.ajax({
        url: 'server.php?function=associatedJobs&skill=' + skill,
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
        url: "server.php?function=associatedSkills&job=" + job,
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
    setUpNewEntryForms();
});
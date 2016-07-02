function getAssociatedJobs() {
    var skill = $("#indexTitle").children()[0].innerHTML;

    $.ajax({
        url: 'server.php?function=associatedJobs&skill=' + skill,
        type: 'GET',
        success: function (output) {
            console.log("Output: " + output);
            var associatedJobs = output.split(',');
            var contentCard = $("#associatedTags");

            for (var i = 0; i < associatedJobs.length-1; i++){
                var newTag = document.createElement("a");
                newTag.href = "index.php?job=" + associatedJobs[i];
                newTag.className = "contentTag darkGreen";
                newTag.innerHTML = associatedJobs[i];
                contentCard.append(newTag);
            }
        }
    });
}

function getAssociatedSkills() {
    var job = $("#indexTitle").children()[0].innerHTML;

    $.ajax({
        url: "server.php?function=associatedSkills&job=" + job,
        type: 'GET',
        success: function (output) {
            var associatedSkills = output.split(',');
            var contentCard = $("#associatedTags");

            for (var i = 0; i < associatedSkills.length-1; i++) {
                var newTag = document.createElement("a");
                newTag.href = "index.php?skill=" + associatedSkills[i];
                newTag.className = "contentTag darkGreen";
                newTag.innerHTML = associatedSkills[i];
                contentCard.append(newTag);
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

$(document).ready(function () {
    getAssociatedTags();
});
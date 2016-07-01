function getAssociatedJobs() {
    var skill = $("#indexTitle").children()[0].innerHTML;

    $.ajax({
        url: 'server.php?function=associatedJobs&skill=' + skill,
        type: 'GET',
        success: function (output) {
            console.log("Output: " + output);
            var associatedJobs = output.split(',');
            var contentCard = $("#associatedJobs");

            for (var i = 0; i < associatedJobs.length-1; i++){
                var newTag = document.createElement("div");
                newTag.className = "contentTag darkGreen";
                newTag.innerHTML = associatedJobs[i];
                contentCard.append(newTag);
            }
        }
    });
}

$(document).ready(function () {
    getAssociatedJobs();
});
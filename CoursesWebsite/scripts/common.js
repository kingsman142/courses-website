function updateDatabase() {
    var job = $('.new-entry-input.job-input')[0].value;
    var skill = $('.new-entry-input.skill-input')[0].value;
    var salary = $('.new-entry-input.salary-input')[0].value;

    $("#update-database")[0].disabled = true;
    $.ajax({
        url: 'server.php?function=UpdateDatabase&skill=' + skill + '&job=' + job + '&salary=' + salary,
        type: 'GET',
        success: function (output) {
            setTimeout(
                function () {
                    $("#update-database")[0].disabled = false;
                },
            2000);
        }
    });
}

function searchForSkill() {
    var searchForms = $(".search-input");
    var searchTerm = "";

    for (var i = 0; i < searchForms.length; i++) {
        if (searchForms[i].placeholder == "Search by skill") {
            searchTerm = searchForms[i].value;
        }
    }

    $.ajax({
        url: "server.php?function=SearchForSkill&skill=" + searchTerm,
        type: 'GET',
        success: function (output) {
            if (output > 0) {
                window.location.href = "index.php?skill=" + searchTerm;
            }
        }
    })
}

function searchForJob() {
    var searchForms = $(".search-input");
    var searchTerm = "";

    for (var i = 0; i < searchForms.length; i++) {
        if (searchForms[i].placeholder == "Search by job") {
            searchTerm = searchForms[i].value;
        }
    }

    $.ajax({
        url: "server.php?function=SearchForJob&job=" + searchTerm,
        type: 'GET',
        success: function (output) {
            if (output > 0) {
                window.location.href = "index.php?job=" + searchTerm;
            }
        }
    })
}

function enterKey(event) {
    if (event.which == 13) {
        return true;
    } else {
        return false;
    }
}
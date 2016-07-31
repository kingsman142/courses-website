function updateDatabase() {
    var job = $('.form.job')[0].value;
    var skill = $('.form.skill')[0].value;
    document.getElementById("updateDatabase").disabled = true;
    $.ajax({
        url: 'server.php?function=updateDatabase&skill=' + skill + '&job=' + job,
        type: 'GET',
        success: function (output) {
            setTimeout(
                function () {
                    document.getElementById("updateDatabase").disabled = false;
                },
            2000);
        }
    });
}

function searchForSkill() {
    var searchForms = $(".searchForm");
    var searchTerm = "";

    for (var i = 0; i < searchForms.length; i++) {
        if (searchForms[i].placeholder == "Search by skill") {
            searchTerm = searchForms[i].value;
        }
    }

    $.ajax({
        url: "server.php?function=searchForSkill&skill=" + searchTerm,
        type: 'GET',
        success: function (output) {
            if (output > 0) {
                window.location.href = "index.php?skill=" + searchTerm;
            }
        }
    })
}

function searchForJob() {
    var searchForms = $(".searchForm");
    var searchTerm = "";

    for (var i = 0; i < searchForms.length; i++) {
        if (searchForms[i].placeholder == "Search by job") {
            searchTerm = searchForms[i].value;
        }
    }

    $.ajax({
        url: "server.php?function=searchForJob&job=" + searchTerm,
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
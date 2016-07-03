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
            console.log("output: " + output);
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
            console.log("output: " + output);
        }
    })
}

$.each($(".searchForm"), function () {
    console.log("wow");
    console.log("placeholder: " + this.placeholder);
})
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

                    var lastSpaceIndex = associatedJobs[i].lastIndexOf(" ");
                    newTag.href = "explore.php?job=" + associatedJobs[i].substring(0, lastSpaceIndex);
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

                    var lastSpaceIndex = associatedSkills[i].lastIndexOf(" ");
                    newTag.href = "explore.php?skill=" + associatedSkills[i].substring(0, lastSpaceIndex);
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
            var averageSalary = parseInt(output);

            if (salaryContentCard) {
                var salaryDiv = document.createElement("div");
                salaryDiv.className = "salary-value";
                if (averageSalary > 0) salaryDiv.innerHTML = "$" + averageSalary.toLocaleString();
                else salaryDiv.innerHTML = output;
                salaryContentCard.append(salaryDiv);
            }
        }
    });
}

function getMinMaxSalaries() {
    var jobOrSkill = $("#index-title span")[0].innerHTML;
    var jobOrSkillValue = $("#index-title b")[0].innerHTML;

    var minMaxSalaryContentCard = $("#min-max-salary");

    if (minMaxSalaryContentCard) {
        $.ajax({
            url: "server.php?function=GetMinimumSalary&" + jobOrSkill.toLowerCase() + "=" + jobOrSkillValue,
            type: "GET",
            success: function (minimumSalary) {
                var minimumSalaryValue = parseInt(minimumSalary);

                $.ajax({
                    url: "server.php?function=GetMaximumSalary&" + jobOrSkill.toLowerCase() + "=" + jobOrSkillValue,
                    type: "GET",
                    success: function (maximumSalary) {
                        var maximumSalaryValue = parseInt(maximumSalary);

                        if (minimumSalaryValue == maximumSalaryValue || (isNaN(minimumSalaryValue) && isNaN(maximumSalaryValue))) {
                            var salaryDiv = document.createElement("div");
                            salaryDiv.id = "matching-salaries";

                            if (isNaN(minimumSalaryValue)) salaryDiv.innerHTML = "<span class='salary-value'>" + minimumSalary + "</span>";
                            else salaryDiv.innerHTML = "Only salary: &emsp; <span class='salary-value'>$" + maximumSalaryValue.toLocaleString() + "</span>";

                            minMaxSalaryContentCard.append(salaryDiv);
                        } else {
                            var minimumSalaryDiv = document.createElement("div");
                            minimumSalaryDiv.id = "minimum-salary";
                            minimumSalaryDiv.innerHTML = "Min: &emsp; <span class='salary-value'>$" + minimumSalaryValue.toLocaleString() + "</span>";

                            var maximumSalaryDiv = document.createElement("div");
                            maximumSalaryDiv.id = "maximum-salary";
                            maximumSalaryDiv.innerHTML = "Max: &emsp; <span class='salary-value'>$" + maximumSalaryValue.toLocaleString() + "</span>";

                            minMaxSalaryContentCard.append(minimumSalaryDiv);
                            minMaxSalaryContentCard.append(maximumSalaryDiv);
                        }
                    }
                });
            }
        });
    }
}

function setUpNewEntryForms() {
    var jobOrSkill = $("#index-title span")[0].innerHTML;

    var inputForm = $(".new-entry-input." + jobOrSkill.toLowerCase() +  "-input");

    if (inputForm.length > 0) {
        var jobOrSkillValue = $("#index-title b")[0].innerHTML;
        inputForm = inputForm[0];
        inputForm.value = jobOrSkillValue;
        
        inputForm.style.transition = "all 0s";
        inputForm.style.borderColor = "white";

        $(inputForm).focus(function () {
            this.style.borderColor = "rgb(0, 208, 0)";
        });

        $(inputForm).focusout(function () {
            this.style.borderColor = "white";
        });
    }

    inputForm.style.transition = "0.5s";
}

$(function () {
    $(".new-entry-input").bind("keyup focusout", function () {
        if (this.type == "text") {
            var val = $(this).val();
            if (val.match(/[^a-zA-Z]/g)) {
                $(this).val(val.replace(/[^a-zA-Z]/g, ''));
            }
        } else if (this.type == "number") {
            var val = $(this).val();
            if (val.match(/[^0-9]/g)) {
                $(this).val(val.replace(/[^0-9]/g, ''));
            }
        }

        if (this.value.trim().length && ($(this).hasClass("job-input") || $(this).hasClass("skill-input"))) {
            this.style.borderColor = "rgb(0, 208, 0)";

            $(this).focus(function () {
                this.style.borderColor = "rgb(0, 208, 0)";
            });

            $(this).focusout(function () {
                this.style.borderColor = "white";
            });
        } else if(!this.value.trim().length && ($(this).hasClass("job-input") || $(this).hasClass("skill-input"))) {
            this.style.borderColor = "#D00000";

            $(this).focus(function () {
                this.style.borderColor = "#D00000";
            });

            $(this).focusout(function () {
                this.style.borderColor = "#D00000";
            });
        }
    });
});

$(document).ready(function () {
    getAssociatedTags();
    getAverageSalary();
    getMinMaxSalaries();
    setUpNewEntryForms();
});
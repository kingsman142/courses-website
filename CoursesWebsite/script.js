function updateDatabase() {
    var job = $('.form.job')[0].value;
    var skill = $('.form.skill')[0].value;
    $.ajax({
        url: 'server.php?function=updateDatabase&skill=' + skill + '&job=' + job,
        type: 'GET',
        success: function (output) {
            console.log("Output: " + output);
            //document.body.innerHTML += output;
        }
    });
}
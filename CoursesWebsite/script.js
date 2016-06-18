function updateDatabase() {
    $.ajax({
        url: 'executeDatabase.php',
        type: 'GET',
        success: function () {
            console.log("success");
        }
    });
}
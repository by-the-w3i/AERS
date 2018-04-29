
$("#randomuser").click(function (event) {
    event.preventDefault();
    $.ajax({
        url: "randomUser.php",
        method: "GET",
        success: function(data) {
            $("#showrandom").text(data).fadeIn(1000).show();
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
});


// $("body").submit(function(){
//     console.log("loading");
//     $(this).loading({
//         onStart: function(loading) {
//             loading.overlay.slideDown(400);
//         },
//         message: "Loading...It may take ~30s to load all the data for this user...",
//         theme: 'dark'
//     });
// });

$("form").submit(function(){
    console.log("loading");
    $(this).loading({
    });
});


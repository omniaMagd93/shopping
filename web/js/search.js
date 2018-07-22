$(function () {
    $("#searchProduct").autocomplete({
        source: "search.php",
        minLength: 2,
        select: function (event, ui) {
            console.log("okkkkkkkkkkk here")
            window.location = "viewproduct.php?id=" + ui.item.value;
        }
    });
});


   

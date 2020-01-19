$("#uploadData").click(function(){
    var formData = new FormData();
    var file = $("#gambar")[0].files[0];
    formData.append('gambar', file);

    $.ajax({
        url: 'server.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response){
            console.log(response);
        },
    });
});
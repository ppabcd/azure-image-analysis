// $("#uploadData").click(function(){
//     var formData = new FormData();
//     var file = $("#gambar")[0].files[0];
//     formData.append('gambar', file);

//     $.ajax({
//         url: 'server.php',
//         type: 'post',
//         data: formData,
//         contentType: false,
//         processData: false,
//         success: function(response){
//             console.log(response);
//         },
//     });
// });
const vue = new Vue({
    el: '#app',
    data: {
        file: '',
    },
    methods: {
        checkFileUpload(eventData){
            console.log(eventData.target.files[0]);
            this.file = eventData.target.files[0];
        },
        uploadFile(){
            let form = new FormData();
            form.append('gambar', this.file);

            axios.post(
                'server.php',
                form,
                {
                    header: {
                        'Content-type' : 'image/png'
                    }
                }
            ).then(function(response){
                console.log(response);
            });
        }
    }
});
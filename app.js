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
        image: 'placeholder.jpg',
        jsonData: '',
        dataCategories: '',
        dataDescription: '',
        isDisabled: false,
    },
    methods: {
        checkFileUpload(eventData){
            this.file = eventData.target.files[0];
        },
        async uploadFile() {
            Swal.fire('Please wait until button upload visible and data showed');
            this.isDisabled = true;
            if(this.file == ''){
                this.isDisabled = false;
                return;
            }
            let form = new FormData();
            form.append('file', this.file);

            let uploadImage = await axios.post(
                'test.php',
                form,
                {
                    header: {
                        'Content-type' : 'multipart/form-data'
                    }
                }
            );
            if(!uploadImage.data.name){
                this.isDisabled = false;
            }
            form = null;
            form = new FormData();
            form.append('filename', uploadImage.data.name);
            let uploadCloud = await axios.post(
                'server.php',
                form
            );
            if(uploadCloud.data.message != "success"){
                this.isDisabled = false;
            }
            this.image = uploadCloud.data.url;
            this.processImage();
        },
        serialize(obj){
            var str = [];
            for (var p in obj)
                if (obj.hasOwnProperty(p)) {
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                }
            return str.join("&");
        },
        async processImage(){
            let uriBase = endpoint+'vision/v2.0/analyze';
            let params = {
                "visualFeatures": "Categories,Description,Color",
                "details": "",
                "language": "en",
            };
            let postToAzure = await axios.post(
                uriBase+'?'+this.serialize(params),
                '{"url": ' + '"' + this.image + '"}',
                {
                    headers: {
                        'Content-type' : 'application/json',
                        "Ocp-Apim-Subscription-Key" : subscriptionKey,
                    }
                }
            );
            let azureData = postToAzure.data;
            console.log(azureData.categories);
            this.jsonData = JSON.stringify(postToAzure.data);
            this.dataCategories = '';
            for(category in azureData.categories){
                this.dataCategories += azureData.categories[category].name+"</br>";
            }
            this.dataDescription = '';
            
            console.log(azureData.description.tags.join(','));
            this.dataDescription += "<b>tags</b></br> "+azureData.description.tags.join('<br> ')+"</br>";
            this.dataDescription += "<b>captions</b></br> "+azureData.description.captions[0].text+"</br>";
            this.isDisabled = false;
        }
    }
});
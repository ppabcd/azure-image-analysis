<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Analisa Gambar</title>
    <style>
        *{
            margin: 0 auto;
            font-family: Helvetica, Arial, sans-serif;
            color: #3e3e3e;
        }
        html, body{
            width: 100%;
        }
        .container{
            width: 80%;
        }
        .header {
            padding : 20px;
            text-align: center;
            border-bottom: 2px solid rgba(0,0,0,0.1);
            line-height: 40px;;
        }
        .body{
            padding: 20px;
            background-color: #fafafa;
            line-height: 30px;
            box-sizing: border-box;
        }
        .body .col{
            display: block;
            width: 50%;
            float: left;
        }
        .clear{
            clear:both;
        }
        img{
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container" id="app">
        <div class="header">
            <h1>Analisa Gambar dengan Computer Vision</h1>
            <p>Analisa ini menggunakan Azure Computer Vision sehingga memudahkan dalam menganalisa gambar.</p>
        </div>
        <div class="body">
            <p>
                Masukkan Gambar yang ingin diupload.
            </p>
            <form method="post" action="" enctype="multipart/form-data" id="myform">
                <input type="file" accept="image/*" id="gambar" name="gambar" @change="checkFileUpload($event)"/>
                <input type="button" class="button" value="Upload" id="uploadData" @click="uploadFile()" v-if="!isDisabled">
            </form>
            <div class="seperate">
                <div class="col left">
                    <p>
                        Respon Json
                    </p>
                    <textarea name="" id="" style="width:90%; height: 100px;" disabled v-model="jsonData"></textarea>
                    <p>
                        Respon Data
                    </p>
                    <div v-if="jsonData != ''">
                        <b><small>Categories</small></b> <br>
                        <span v-html="dataCategories"></span>
                        <b><small>Description</small></b><br>
                        <span v-html="dataDescription"></span>
                    </div>

                </div>
                <div class="col right">
                    <p>
                        Respon Gambar
                    </p>
                    <img :src="image" alt="" id="image-result">
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript">
        <?php
            require('vendor/autoload.php');
            use Symfony\Component\Dotenv\Dotenv;
            $dotenv = new Dotenv();
            $dotenv->load(__DIR__.'/.env');
        ?>
        var subscriptionKey = '<?=$_ENV['VISION_KEY']?>';
        var endpoint='<?=$_ENV['VISION_ENDPOINT']?>';
    </script>
    <script src="app.js" type="text/javascript"></script>
</body>
</html>
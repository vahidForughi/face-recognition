<html>
<head>
    <title>How to Crop Image Before Uploading using Cropper Js?</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css"  />
</head>
<style type="text/css">
    img {
        display: block;
        max-width: 100%;
    }
    .preview {
        overflow: hidden;
        width: 300px;
        height: 300px;
        margin: 10px;
        border: 1px solid red;
    }

</style>
<body>
<div class="container">
    <h5>Upload Images</h5>
    <form method="post">
        <input type="file" name="image" class="image">
        <img id="show-image">
    </form>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Crop image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <!--  default image where we will set the src via jquery-->
                            <img id="image">
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
            </div>
        </div>
    </div>
</div>

</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>

    var bs_modal = $('#modal');
    var image = document.getElementById('image');
    var cropper,reader,file;


    $("body").on("change", ".image", function(e) {
        var files = e.target.files;
        var done = function(url) {
            image.src = url;
            bs_modal.modal('show');
        };


        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    bs_modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300,
        });

        // console.log(canvas.toDataURL("image/jpeg",1))
        bs_modal.modal('hide');
        $('#show-image')[0].src = canvas.toDataURL("image/jpeg",0.8)

        // canvas.toBlob(function(blob) {
        //     url = URL.createObjectURL(blob);
        //     var reader = new FileReader();
        //     reader.readAsDataURL(blob);
        //     reader.onloadend = function() {
        //         var base64data = reader.result;
        //         //alert(base64data);
        //         bs_modal.modal('hide');
        //         console.log(url)
        //         $('#show-image')[0].src = canvas.toDataURL("image/jpeg",1)
        //         // $.ajax({
        //         //     type: "POST",
        //         //     dataType: "json",
        //         //     url: "crop_image_upload.php",
        //         //     data: {image: base64data},
        //         //     success: function(data) {
        //         //         bs_modal.modal('hide');
        //         //         alert("success upload image");
        //         //     }
        //         // });
        //     };
        // });
    });

</script>
</body>
</html>

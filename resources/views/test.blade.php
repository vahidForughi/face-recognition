<!DOCTYPE html>

<!--
/* This file is part of Nokia HEIF library
 *
 * Copyright (c) 2015-2021 Nokia Corporation and/or its subsidiary(-ies). All rights reserved.
 *
 * Contact: heif@nokia.com
 *
 * This software, including documentation, is protected by copyright controlled by Nokia Corporation and/ or its subsidiaries. All rights are reserved.
 *
 * Copying, including reproducing, storing, adapting or translating, any or all of this material requires the prior written consent of Nokia.
 */
-->

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="HEIF example gallery to demonstrate storage of still images, image bursts, animations, derived images, and non-destructive image processing.">
    <meta name="keywords" content="High Efficiency Image File, High Efficiency Video Coding, HEVC, HEIF, HEIC, MP4, ISOBMFF, MPEG, ISO Base Media File Format, Image Format, Image burst, animation format, derived images, non-destructive image processing, Nokia Technologies, HEIF source code">

    <title>HEIF Example Images - High Efficiency Image File Format</title>

{{--    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>--}}
{{--    <link href="css/bootstrap.min.css" rel="stylesheet" type='text/css'>--}}
{{--    <link href="css/styles.css" rel="stylesheet" type='text/css'>--}}
    <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('js/heic2any.min.js') }}"></script>
</head>
<body id="body">
<div class="">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <form>
                <input type='file' id="imgInp" />
                <img id="blah" src="#" alt="your image" />
{{--                <img id="blah" src="{{ URL::asset('assets/img/autumn_1440x960.heic') }}" alt="your image" />--}}
            </form>
{{--            <img src="{{ URL::asset('assets/img/autumn_1440x960.heic') }}"/>--}}
{{--            <div id="image-show"></div>--}}
        </div>
        <div id="target">

        </div>
    </div>
<script>
    $().ready(function() {
        // imgInp.onchange = evt => {
        //     const [file] = imgInp.files
        //     console.log(file)
        //     if (file) {
        //         console.log(URL.createObjectURL(file))
        //         blah.src = URL.createObjectURL(file)
        //     }
        // }
        $('#imgInp').on('change', function(evt) {
            const [file] = this.files
            console.log(file)
            if (file) {
                console.log(URL.createObjectURL(file))
                const inputImageUrl = URL.createObjectURL(file)
                console.log('000')
                console.log(file['name'].split('.').pop())
                const fileExt = file['name'].split('.').pop().toLowerCase()
                if (fileExt == 'heic' || fileExt == 'heif') {
                    console.log('111')
                    fetch(inputImageUrl)
                    .then((res) => res.blob())
                    .then((blob) => heic2any({
                        blob,
                        toType: "image/jpeg",
                        quality: 1,
                    }))
                    .then((conversionResult) => {
                        console.log('333')
                        // var url = URL.createObjectURL(conversionResult);
                        $('#blah')[0].src = URL.createObjectURL(conversionResult)
                        // document.getElementById("target").innerHTML = `<a target="_blank" href="${url}"><img src="${url}"></a>`;
                    })
                    .catch((e) => {
                        console.log(e);
                    });
                }else {
                    $('#blah')[0].src = inputImageUrl
                }
            }
        })

    })
</script>
</body>
</html>

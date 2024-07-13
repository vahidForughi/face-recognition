$(document).ready(function(){
    const url_origin = window.location.origin

    const imageInput = $("#image-input")[0]
    const faceDetect = $("#face-detect")

    var imageInputUrl = null

    $('#image-input').change(async function () {
        faceDetect.empty()
        const [file] = this.files
        console.log('file', file)
        if (file) {
            const fileType = file["type"].split('/')[0]
            const fileExt = imageInput.files[0]['name'].split('.').pop().toLowerCase()
            if (fileType === 'image' || fileExt == 'heic' || fileExt == 'heif') {
                imageInputUrl = URL.createObjectURL(file)

                if (fileExt == 'heic' || fileExt == 'heif') {
                    await fetch(imageInputUrl)
                        .then((res) => res.blob())
                        .then((blob) => heic2any({
                            blob,
                            toType: "image/jpeg",
                            quality: 1,
                        }))
                        .then((conversionResult) => {
                            imageInputUrl = URL.createObjectURL(conversionResult)
                            console.log('conversionResult', conversionResult)
                        })
                        .catch((e) => {
                            imageInputUrl = null
                            addAlert(faceDetect, 'فایل نا معتبر است!' )
                       });
                }
            }
            else {
                imageInputUrl = null
            }
        }
        else {
            imageInputUrl = null
        }
        if (imageInputUrl) {
            $('#image-show').attr('src', imageInputUrl)
        }
        else{
            addAlert(faceDetect, 'عکس انتخاب نشد!' )
        }
        console.log('imageInputUrl', imageInputUrl)

        const filename = $('#image-input[type=file]').val().split('\\').pop()
        $('#image-input-label').html(filename ? filename : "یه عکس انتخاب کن")
    })


    function showImage(showId, faces = [], desc = false) {
        let display = $('#'+showId)
        if (imageInputUrl) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var image = new Image();
                // image.src = e.target.result;
                image.onload = function () {
                    display.attr('src', image.src);
                    if (faces.length > 0) {
                        const ratio = display[0].width / image.width
                        for (let i = 0; i < faces.length; i++) {
                            var crop = {
                                width: ratio * faces[i].width,
                                height: ratio * faces[i].height,
                                top: ratio * faces[i].top,
                                left: ratio * faces[i].left,
                                rotateX: -faces[i].rotateX,
                                rotateY: -faces[i].rotateY,
                                rotateZ: -faces[i].rotateZ,
                                color: faces[i].color,
                                gender: faces[i].gender
                            }

                            display.after('' +
                                '<div class="position-absolute" ' +
                                'style="' +
                                'border-radius: 5px;' +
                                'border: solid 4px ' + crop.color + ';' +
                                'height: ' + crop.width + 'px; ' +
                                'width: ' + crop.height + 'px;' +
                                'top: ' + crop.top + 'px;' +
                                'left: ' + crop.left + 'px;' +
                                'transform: rotateX(' + crop.rotateX + 'deg) rotateY(' + crop.rotateY + 'deg) rotateZ(' + crop.rotateZ + 'deg)"' +
                                '>' +
                                (desc ? '<span style="display: block;\n' +
                                    '    background: '+ crop.color +';\n' +
                                    '    color: white;\n' +
                                    '    position: absolute;\n' +
                                    '    width: 100%;\n' +
                                    '    top: -25px;\n' +
                                    '    border-radius: 5px;">' + crop.gender + '</span>' +
                                    '</div>' : '')
                            )

                            // console.log(crop)
                            // const scale = 4
                            // if (!desc) {
                            //     display.attr('style', 'top: '+ ((crop.top + 75 - 30)*scale) +'px;\n' +
                            //         '    left: '+ ((150 - crop.left - 30)*scale) +'px;\n' +
                            //         '    width: '+ display.width() +'px;\n' +
                            //         '    height: '+ display.height() +'px;\n' +
                            //         '    transform: scale('+ scale +');')
                            // }
                        }
                    }
                };

                image.src = imageInputUrl;

            // console.log('image', image)
            }



            reader.readAsDataURL(imageInput.files[0]);
        }
        else{
            display.attr('hidden', true);
        }
    }

    $("#form-face-detect").on('submit', function(evt){

        faceDetect.empty()
        $("#face-detect-result").empty()

        const goAwayBtn = $("#go-away")
        btnLoading(goAwayBtn)
        scrollTo($('#DetectFace'))

        faceDetect.append('<div class="scanning"><img id="image-show" class="card-img-top position-relative" src="#" alt="yourimage" /></div>')
        showImage('image-show', []);

        var formData = new FormData($(this)[0]);
        formData.append('file',$(this)[0][0].files[0])

        $.ajax({
            url: url_origin + '/api/face/detect',
            type: 'POST',
            data: formData,
            // async: false,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function (response) {
                console.log('success')
                if (response.success) {
                    // console.log(response.data)
                    if (!(response.hasOwnProperty('data') && response.data && response.data.hasOwnProperty('face_num'))) {
                        faceDetect.empty()
                        addAlert(faceDetect, 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...' )
                    }
                    else if (response.data.face_num <= 0) {
                        $('#face-detect .scanning').toggleClass('scanning')
                        addAlert(faceDetect, 'چهره‌ای شناسایی نشد!' )
                    }
                    else {
                        imageDetected(response.data)
                    }
                }
                else {
                    $('#face-detect .scanning').toggleClass('scanning')
                    addAlert($("#contact-form-alert"), response.errors ? parseErrors(response.errors) : 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...')
                }
            },
            statusCode: {
                500: function(xhr) {
                    faceDetect.empty()
                    addAlert(faceDetect, 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...' )
                },
            },
            error: function (xhr, ajaxOptions, thrownError) {
                faceDetect.empty()
                addAlert(faceDetect, xhr.responseJSON.errors ? parseErrors(xhr.responseJSON.errors) : 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...' )
            },
            complete: function (response) {
                console.log('completed')
                btnResetLoading(goAwayBtn, 'کلیک کنید')
            }
        });

        evt.preventDefault();
        return false;

    });


    function imageDetected(result) {

        console.log(result)

        const faces = result.faces;
        var fecesDisplay = []
        // $("#image-show").attr("src", "#")
        const colors = ["red","blue","green","black","purple","teal","orange","olive","gold","brown"];
        $("#face-detect").empty()

        for (var i = 0; i < faces.length; i++) {
            if (faces[i].attributes) {
                $("#face-detect-result").append('<div class="col-sm-12">\n' +
                    '                                <div class="card overflow-hidden bg-transparent text-white border-0">\n' +
                    '                                    <div class="croped-img-box">\n' +
                    '                                       <img id="image-show-'+ i +'" class="card-img-top" src="#" alt="your image"/>\n' +
                    '                                    </div>\n' +
                    // '                                    <div style="height: 208px; width: 208px; border: splid 2px red"></div>\n' +
                    '                                    <div class="card-body p-0">\n' +
                    '                                        <ul class="list-group px-0 border-none">\n' +
                    '                                            <li class="list-group-item bg-transparent text-white border-0"><span class="float-end">سن: </span><span class="float-start">'+ faces[i].attributes.age.value +'</span></li>\n' +
                    '                                            <li class="list-group-item bg-transparent text-white border-0"><span class="float-end">جنسیت: </span><span class="float-start">'+ ((faces[i].attributes.gender.value === "Male") ? "مرد" : "زن") +'</span></li>\n' +
                    '                                            <li class="list-group-item bg-transparent text-white border-0"><span class="float-end">امتیاز زیبایی از دید آقایان: </span><span class="float-start">'+ (faces[i].attributes.beauty.male_score).toFixed(0) +'%</span></li>\n' +
                    '                                            <li class="list-group-item bg-transparent text-white border-0"><span class="float-end">امتیاز زیبایی از دید خانم‌ها: </span><span class="float-start">'+ (faces[i].attributes.beauty.female_score).toFixed(0) +'%</span></li>\n' +
                    '                                            <li class="list-group-item bg-transparent text-white border-0 final-rate"><span class="float-end">امتیاز نهایی: </span><span class="float-start ring">'+ ((faces[i].attributes.beauty.female_score + faces[i].attributes.beauty.male_score)/2).toFixed(0) +'%</span></li>\n' +
                    // '                                            <li class="list-group-item">Smile: '+ faces[i].attributes.smile.value +'</li>\n' +
                    '                                        </ul>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>'
                )

                let faceDisplay = {
                    width: faces[i].face_rectangle.width,
                    height: faces[i].face_rectangle.height,
                    top: faces[i].face_rectangle.top,
                    left: faces[i].face_rectangle.left,
                    rotateX: faces[i].attributes.headpose.pitch_angle,
                    rotateY: faces[i].attributes.headpose.roll_angle,
                    rotateZ: faces[i].attributes.headpose.yaw_angle,
                    color: colors[i],
                    gender: faces[i].attributes.gender.value,
                    smile: faces[i].attributes.smile.value,
                }

                fecesDisplay.push(faceDisplay)
                showImage('image-show-'+i, [faceDisplay]);

            }

        }

        showImage('image-show', fecesDisplay, true);

    }


    function btnLoading(btn) {
        console.log('btnLoading')
        btn.attr('disabled', 'disabled');
        btn.html("<span class=\"spinner-grow spinner-grow-sm\" role=\"status\" aria-hidden=\"true\"></span> بررسی ...")
    }

    function btnResetLoading(btn, label = 'ok') {
        console.log('btnResetLoading')
        btn.attr('disabled', false)
        btn.html(label)
    }

    // var x = 0
    // const g = $("#go-away")
    // setInterval(function () {
    //     if (!x) {
    //         btnLoading(g)
    //         x = 1
    //     }
    //     else {
    //         btnResetLoading(g)
    //         x = 0
    //     }
    // },2000);


    $("#contact-form").on('submit', function(evt){

        evt.preventDefault();
        $("#contact-form-alert").empty()
        const contactBtn = $("#contact-btn")
        btnLoading(contactBtn)

        let data = new FormData()
        $(this).serializeArray().forEach(function(field) {
            data.append('contact['+field.name+']', field.value)
        })
        data.append('contact[subject]', 'Lead')

        $.ajax({
            url: url_origin + '/api/contact',
            type: 'POST',
            data: data,
            // async: false,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function (response) {
                console.log('success')
                if (response.success) {
                    addAlert($("#contact-form-alert"), 'با تشکر. به زودی با شما تماس خواهیم گرفت.', 'success' )
                }
                else {
                    addAlert($("#contact-form-alert"), response.errors ? parseErrors(response.errors) : 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...')
                }
            },
            statusCode: {
                500: function(xhr) {
                    addAlert($("#contact-form-alert"), 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...' )
                },
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('error')
                addAlert($("#contact-form-alert"), xhr.responseJSON.errors ? parseErrors(xhr.responseJSON.errors) : 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...' )
                // $("#contact-form-alert").prepend('<div class="alert alert-danger" role="alert">مشکلی پیش آمده. لطفا دوباره تلاش کنید...</div>')
            },
            complete: function (response) {
                console.log('completed')
                btnResetLoading(contactBtn, 'ارسال')
            }
        });

        return false;

    });


    function parseErrors (errors) {
        var message = ""

        if ($.type(errors) === 'object') {
            message += parseErrors(Object.keys(errors).map(function (key) { return errors[key]; }))
        }

        else if ($.type(errors) === 'array') {
            message += errors.map(function(err) {
                return parseErrors(err)
            })
        }

        else {
            message += errors + '<br>'
        }

        return message
    }

    function addAlert(selector, message, type = 'danger', pos = 'prepend') {
        selector[pos]('<div class="alert alert-'+ type +'" role="alert">' + message + '</div>')
    }

    function scrollTo(selector) {
        $('html, body').animate({
            scrollTop: selector.offset().top
        }, 600);
    }

})

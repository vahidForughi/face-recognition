$(document).ready(function(){
    const url_origin = window.location.origin

    const cropSize = 300

    const faceDetectForm = $("#face-detect-form")
    const faceDetectInput = $("#face-detect-input")
    const faceDetectInputLabel = $("#face-detect-input-label")
    const faceDetectImage = $('#face-detect-image')
    const faceDetectAlert = $('#face-detect-alert')
    const faceDetectResult = $('#face-detect-result')
    const goAwayBtn = $('#go-away')

    var imageInputUrl = null
    var imageInputFile = null


    faceDetectInput.click(function() {
        resetFaceDetectImage()
        imageInputUrl = null
        // faceDetect.empty()
    })

    faceDetectInput.change(async function () {
        const [file] = this.files

        imageInputUrl = file ? await fetchImage(file) : null;

        if (imageInputUrl) {
            openCroppingModal(imageInputUrl)
        }
        else{
            addAlert(faceDetectAlert, 'عکس انتخاب نشد!' )
        }
        console.log('imageInputUrl', imageInputUrl)
    })


    //// cropping image ////
    var bs_modal = $('#cropping-modal');
    var croppingImage = document.getElementById('cropping-image');
    var cropper,reader,file;

    bs_modal.on('shown.bs.modal', function() {
        cropper = new Cropper(croppingImage, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.cropping-preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            width: cropSize,
            height: cropSize,
        });

        bs_modal.modal('hide');
        setFaceDetectImage(canvas.toDataURL("image/jpeg",1))

        faceDetectForm.submit()
    });

    function openCroppingModal(imageUrl) {
        croppingImage.src = imageUrl;
        bs_modal.modal('show');
    }

    function resetFaceDetectImage() {
        faceDetectResult.empty()
        faceDetectAlert.empty()

        faceDetectInput.prop("value", "")
        faceDetectInputLabel.html("یه عکس انتخاب کن")

        faceDetectImage.attr('src', '#')
        faceDetectImage.addClass('d-none')
    }

    function setFaceDetectImage(imageUrl) {
        const filename = $('#face-detect-input[type=file]').val().split('\\').pop()
        faceDetectInputLabel.html(filename)

        imageInputUrl = imageUrl
        faceDetectImage.attr('src', imageUrl)
        faceDetectImage.removeClass('d-none')
    }

    function setFaceDetectImageScanning() {
        faceDetectImage.parent().addClass('scanning')
    }

    function resetFaceDetectImageScanning() {
        faceDetectImage.parent().removeClass('scanning')
        btnResetLoading(goAwayBtn, 'کلیک کنید')
    }


    function drawFace(showId, faces = [], desc = false) {
        let display = $('#'+showId)
        if (faces.length > 0) {
            // const ratio = display[0].width / display[0].width
            const ratio = display[0].width / cropSize
            // const ratio = 1
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
            }
        }
    }


    faceDetectForm.on('submit', async function(evt){
        evt.preventDefault();
        console.log('submit 111')
        faceDetectAlert.empty()
        btnLoading(goAwayBtn)
        scrollTo($('#DetectFace'))

        setFaceDetectImageScanning()
        // faceDetect.append('<div class="scanning"><img id="image-show" class="card-img-top position-relative" src="#" alt="yourimage" /></div>')
        // showImage('image-show', []);

        startFaceDetect($(this)[0])

        evt.preventDefault();
        return false;

    });

    var autoRetry = 0;

    async function startFaceDetect(form) {
        var formData = new FormData(form);
        // formData.append('file',$(this)[0][0].files[0])

        var imageBlob = await (await fetch(imageInputUrl)).blob();
        imageInputFile = new File([imageBlob], 'file-name.jpg', { lastModified: new Date().getTime(), type: 'image/jpeg' });
        // console.log('imageFile', imageInputFile)
        formData.append('file',imageInputFile)

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
                    if (!(response.hasOwnProperty('data') && response.data && response.data.hasOwnProperty('token'))) {
                        // faceDetect.empty()
                        addAlert(faceDetectAlert, 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...' )
                    }
                    else {
                        setTimeout(function() {
                            autoRetry = 0
                            pushFaceDetect(response.data.token)
                        }, response.data.push_wait * 1000)
                    }
                }
                else {
                    resetFaceDetectImageScanning()
                    addAlert(faceDetectAlert, response.errors ? parseErrors(response.errors) : 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...')
                }
            },
            statusCode: {
                500: function(xhr) {
                    resetFaceDetectImageScanning()
                    addAlert(faceDetectAlert, 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...' )
                },
            },
            error: function (xhr, ajaxOptions, thrownError) {
                resetFaceDetectImageScanning()
                addAlert(faceDetectAlert, xhr.responseJSON !== 'undefined' && xhr.responseJSON.errors ? parseErrors(xhr.responseJSON.errors) : 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...' )
            },
            complete: function (response) {
                console.log('completed')
                // btnResetLoading(goAwayBtn, 'کلیک کنید')
            }
        });
    }


    function pushFaceDetect(token) {
        console.log('autoRetry', autoRetry)
        if (autoRetry >= 3) {
            autoRetry = 0
            resetFaceDetectImageScanning()
            addAlert(faceDetectAlert, 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...' )
        }
        else {

            $.ajax({
                url: url_origin + '/api/face/detect/push',
                type: 'POST',
                data: {"token": token},
                // async: false,
                // cache: false,
                // contentType: false,
                // enctype: 'multipart/form-data',
                // processData: false,
                success: function (response) {
                    console.log('success')
                    if (response.success) {
                        // console.log(response.data)
                        // response.data.hasOwnProperty('face_num')
                        if (!(response.hasOwnProperty('data') && response.data)) {
                            resetFaceDetectImageScanning()
                            addAlert(faceDetectAlert, 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...' )
                        }
                        else if (response.data.status == 'Waiting' ) {
                            setTimeout(function() {
                                autoRetry++
                                pushFaceDetect(token)
                            }, response.data.push_wait * 1000)
                        }
                        else if (response.data.status == 'Failed' ) {
                            resetFaceDetectImageScanning()
                            addAlert(faceDetectAlert, 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...' )
                        }
                        else if (response.data.status == 'Success' ) {
                            if (! response.data.payload.hasOwnProperty('face_num')) {
                                resetFaceDetectImageScanning()
                                addAlert(faceDetectAlert, 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...' )
                            }
                            else if (response.data.payload.face_num <= 0) {
                                resetFaceDetectImageScanning()
                                addAlert(faceDetectAlert, 'چهره‌ای شناسایی نشد!' )
                            }
                            else {
                                resetFaceDetectImageScanning()
                                imageDetected(response.data.payload)
                            }
                        }

                    }
                    else {
                        resetFaceDetectImageScanning()
                        addAlert(faceDetectAlert, response.errors ? parseErrors(response.errors) : 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...')
                    }
                },
                statusCode: {
                    500: function(xhr) {
                        resetFaceDetectImageScanning()
                        addAlert(faceDetectAlert, 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...' )
                    },
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    resetFaceDetectImageScanning()
                    addAlert(faceDetectAlert, xhr.responseJSON.errors ? parseErrors(xhr.responseJSON.errors) : 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...' )
                },
                complete: function (response) {
                    console.log('completed')
                    // btnResetLoading(goAwayBtn, 'کلیک کنید')
                }
            });
        }
    }

    function imageDetected(result) {
        console.log(result)
        // resetFaceDetectImage()
        faceDetectImage.addClass('d-none')

        const faces = result.faces;
        var fecesDisplay = []
        // $("#image-show").attr("src", "#")
        const colors = ["red","blue","green","black","purple","teal","orange","olive","gold","brown"];

        for (var i = 0; i < faces.length; i++) {
            if (faces[i].attributes) {
                faceDetectResult.append('<div class="col-sm-12">\n' +
                    '                                <div class="card overflow-hidden bg-transparent text-white border-0">\n' +
                    '                                    <div class="croped-img-box">\n' +
                    '                                       <img id="image-show-'+ i +'" class="card-img-top" src="'+ imageInputUrl +'" alt="your image"/>\n' +
                    '                                    </div>\n' +
                    // '                                    <div style="height: 208px; width: 208px; border: splid 2px red"></div>\n' +
                    '                                    <div class="card-body p-0">\n' +
                    '                                        <ul class="list-group px-0 border-none">\n' +
                    '                                            <li class="list-group-item bg-transparent text-white border-0"><span class="float-end">سن: </span><span class="float-start">'+ faces[i].attributes.age.value +'</span></li>\n' +
                    '                                            <li class="list-group-item bg-transparent text-white border-0"><span class="float-end">جنسیت: </span><span class="float-start">'+ ((faces[i].attributes.gender.value === "Male") ? "مرد" : "زن") +'</span></li>\n' +
                    '                                            <li class="list-group-item bg-transparent text-white border-0"><span class="float-end">امتیاز زیبایی و بادی از دید آقایان: </span><span class="float-start">'+ (faces[i].attributes.beauty.male_score).toFixed(0) +'%</span></li>\n' +
                    '                                            <li class="list-group-item bg-transparent text-white border-0"><span class="float-end">امتیاز زیبایی و بادی از دید خانم‌ها: </span><span class="float-start">'+ (faces[i].attributes.beauty.female_score).toFixed(0) +'%</span></li>\n' +
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
                drawFace('image-show-'+i, [faceDisplay])
                // showImage('image-show-'+i, [faceDisplay]);

            }

        }

        // showImage('image-show', fecesDisplay, true);

    }

    // function drawFace(identify, face) {
    //
    // }


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


    $("#contact-form").on('submit', function(evt){

        evt.preventDefault();
        $("#contact-form-alert").empty()
        const contactBtn = $("#contact-btn")
        btnLoading(contactBtn)

        let data = new FormData()
        $(this).serializeArray().forEach(function(field) {
            data.append('contact['+field.name+']', field.value)
        })
        data.append('contact[sender_image]', imageInputFile ?? '')
        data.append('contact[landing_id]', 2)
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


    async function fetchImage(file) {
        var imageUrl = null;

        const fileType = file["type"].split('/')[0]
        const fileExt = (file.name).split('.').pop().toLowerCase()

        if (fileType === 'image' || fileExt == 'heic' || fileExt == 'heif') {
            imageUrl = URL.createObjectURL(file)

            // if (fileExt == 'heic' || fileExt == 'heif') {
            //     await fetch(imageUrl)
            //         .then((res) => res.blob())
            //         .then((blob) => heic2any({
            //             blob,
            //             toType: "image/jpeg",
            //             quality: 1,
            //         }))
            //         .then((conversionResult) => {
            //             imageUrl = URL.createObjectURL(conversionResult)
            //             console.log('conversionResult', conversionResult)
            //         })
            //         .catch((e) => {
            //             imageUrl = null
            //             addAlert(faceDetect, 'فایل نا معتبر است!' )
            //         });
            // }
        }

        return imageUrl;
    }


    function createUrl(file) {
        if (URL) {
            return URL.createObjectURL(file);
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function(e) {
                return reader.result;
            };
            reader.readAsDataURL(file);
        }
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

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content="شناسایی و ارزیابی چهره ، مشاوره ترمیم صورت و بهبود نا محسوس زیبایی"/>
    <meta name="author" content=""/>
    <title>ارزیابی چهره - شیرین بهجتی</title>

    <meta property="og:site_name" content="ارزیابی چهره">
    <meta property="og:title" content="ارزیابی چهره - شیرین بهجتی"/>
    <meta property="og:description" content="شناسایی و ارزیابی چهره ، مشاوره ترمیم صورت و بهبود نا محسوس زیبایی"/>
    {{--
    <meta property="og:image" itemprop="image" content="{{ URL::asset('assets/favicon.png?i=2') }}">
    --}}
    <meta property="og:type" content="website"/>
    <meta property="og:updated_time" content="1698583216"/>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('assets/favicon.png?i=3') }}"/>

    {{--
    <link href="{{ URL::asset('css/fonts.googleapis.css') }}" rel="stylesheet"/>
    --}}
    <link href="{{ URL::asset('css/fonts.byekan+.css') }}" rel="stylesheet"/>
    <!-- Bootstrap icons-->
    <link href="{{ URL::asset('css/bootstrap-icons.css') }}" rel="stylesheet"/>
    <!-- Cropper -->
    <link href="{{ URL::asset('css/cropper.min.css') }}" rel="stylesheet"/>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ URL::asset('css/styles.css?i=9') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('css/landings/face-detect-2.css?i=2') }}" rel="stylesheet"/>

</head>
<body>
<main>


    <!--    <section id="recognition-face">-->
    <!--        <div class="container">-->
    <!--            <div class="row justify-content-around align-items-center">-->
    <!--                <div class="col-md-6 col-sm-12 text-align-center pt-6">-->
    <!--                    <p class="h3 text-white">کارنامه خوشگلیت رو بگیر...</p>-->
    <!--                    <br/>-->
    <!--                    <p class="h5">فقط یه عکس بهم بده...</p>-->
    <!--                    <p class="h3 fw-bold">تا بهت بگم چه جوری</p>-->
    <!--                    <p class="h3 fw-bold">نا محسوس زیباتر بشی:)</p>-->
    <!--                </div>-->
    <!--                <div class="col-md-6 col-sm-12 text-align-center">-->
    <!--                    <p class="h4">شناسایی چهره</p>-->
    <!--                    <img src="{{ URL::asset('assets/recognition-min.gif') }}" alt="recognition face"-->
    <!--                         class="face-recognition"/>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </section>-->

    <!-- Detect Section-->
    <!--    <section id="DetectFace">-->
    <!--        <div class="container-fluid px-0 face-detect-container">-->
    <!--            <div class="row gx-5 justify-content-center">-->
    <!--                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-10 col-xs-11 align-items-center px-4">-->
    <!--                    <div class="text-center my-5">-->
    <!--                        <form id="face-detect-form" class="form-inline d-grid d-sm-flex justify-content-sm-center mb-3">-->
    <!--                            <div class="input-group">-->
    <!--                                <div class="custom-file">-->
    <!--                                    <input id="face-detect-input" type="file" class="custom-file-input"-->
    <!--                                           accept="image/png, image/jpeg, image/jpg">-->
    <!--                                    <label class="file-label" for="face-detect-input">-->
    <!--                                        <a class="btn btn-light position-absolute top-0 left-0 py-2">آپلود عکس</a>-->
    <!--                                        <small id="face-detect-input-label" class="fw-bold">یه عکس انتخاب کن</small>-->
    <!--                                        <button id="go-away"-->
    <!--                                                class="btn btn-primary upload-face-btn position-absolute right-0 top-0">-->
    <!--                                            کلیک کنید-->
    <!--                                        </button>-->
    <!--                                    </label>-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                        </form>-->
    <!--                        <div class="row justify-content-center min-h-300">-->
    <!--                            <div class="col-sm-12">-->
    <!--                                <div id="face-detect-box" class="card bg-transparent border-0 position-relative">-->
    <!--                                    <div id="face-detect-alert">-->
    <!---->
    <!--                                    </div>-->
    <!--                                    <div class="">-->
    <!--                                        <img id="face-detect-image" class="card-img-top position-relative d-none"-->
    <!--                                             src="#" alt="your image"/>-->
    <!--                                    </div>-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <div class="col-sm-12">-->
    <!--                                <div id="face-detect-result" class="row justify-content-center">-->
    <!---->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div>-->
    <!--                <div class="position-relative">-->
    <!--                    <img src="{{ URL::asset('assets/banner-2-min.png') }}" class="w-100" style="min-height: 150px"/>-->
    <!--                    <div class="center position-absolute top-0">-->
    <!--                        <div class="center-inner lead-text h1">-->
    <!--                            <div class="row justify-content-center">-->
    <!--                                <div-->
    <!--                                    class="col-xxxl-5 col-xxl-6 col-xl-7 col-lg-8 col-md-10 col-sm-12 text-align-center py-3">-->
    <!--                                    <div class="lead-text h1">-->
    <!--                                        <p>-->
    <!--                                            اگه می خوای sadwa یک مشاوره خوب نمره زیباییت بالاتر بره-->
    <!--                                            شمارتو بذار تا باهم بالاتر ببریمش ...-->
    <!--                                        </p>-->
    <!--                                    </div>-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--                <div class="container py-5">-->
    <!--                    <div class="row justify-content-center">-->
    <!--                        <div class="col-xl-5 col-lg-6 col-md-7 col-sm-12 px-5">-->
    <!--                            <div id="contact-form-alert">-->
    <!---->
    <!--                            </div>-->
    <!--                            <form id="contact-form" class="contact-form">-->
    <!--                                <div class="form-group mb-3">-->
    <!--                                    <input type="text" name="sender_name" class="form-control"-->
    <!--                                           placeholder="نام و نام خانوادگی">-->
    <!--                                </div>-->
    <!--                                <div class="form-group mb-3">-->
    <!--                                    <input type="text" name="sender_mobile" class="form-control"-->
    <!--                                           placeholder="شماره موبایل">-->
    <!--                                </div>-->
    <!--                                <button id="contact-btn" class="custom-btn contact-custom-btn float-left">ارسال</button>-->
    <!--                            </form>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!---->
    <!--            <div class="footer text-align-center pt-5">-->
    <!--                <p>تمام حقوق مادی و معنوی برای مجموعه پاسیو محفوظ است.</p>-->
    <!--            </div>-->
    <!---->
    <!--        </div>-->
    <!---->
    <!--    </section>-->

    <!--    <section>-->
    <!---->
    <!--        <div id="cropping-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel"-->
    <!--             aria-hidden="true">-->
    <!--            <div class="modal-dialog" role="document">-->
    <!--                <div class="modal-content">-->
    <!--                    <div class="modal-body px-0 cropping-box">-->
    <!--                        <img id="cropping-image">-->
    <!--                        <button id="crop" class="btn btn-primary upload-face-btn w-100">انتخاب</button>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!---->
    <!--    </section>-->
    <header class="py-2">
        <div class="container-fluid px-0 pb-0">
            <img src="{{ URL::asset('assets/face-detect-2/banner-min.png') }}" width="100%" alt="face detect"/>
        </div>
    </header>

    <section>
        <div class="container-fluid px-0 face-detect-container">
            <div class="row gx-5 justify-content-center align-items-center">
                <div class="col-xl-5 col-md-8 col-sm-12 text-align-center">
                    {{--                    <p class="h4">با یک کلیک زیبا تر شو</p>--}}
                    <img src="{{ URL::asset('assets/face-detect-2/be-prettier.png') }}" alt="be-prettier" class="w-75 pt-5 mx-5 mt-5">
                    {{--                    <p class="h4">شناسایی زیبایی</p>--}}
                    <a href="#DetectFace" class="detect-beauty mt-5 text-center">همین الان کلیک کن</a>
                    <div class="detect-beauty mt-5 text-center">شناسایی زیبایی</h1>
                        <div class="send-picture-text p-2 rounded-4 text-black my-3 mx-2">فقط یک عکس ایستاده همراه چهره برام
                            بفرست تا
                            بگم چیکار کنی...
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="d-flex flex-column flex-sm-column flex-lg-row align-items-center justify-content-center gap-5 px-2">
                <div class="d-flex flex-column gap-3 col-12 col-md-6 col-lg-4">
                    <video controls autoplay muted loop class="w-100">
                        <source src="http://media.w3.org/2010/05/sintel/trailer.mp4" type="video/mp4">
                    </video>
                    <div class="gallery-container d-flex flex-row justify-content-center">
                        <img src="{{ URL::asset('assets/face-detect-2/video.png') }}" alt="progress"
                             style="max-width: 150px">
                        <img src="{{ URL::asset('assets/face-detect-2/video-logo.png') }}" alt="progress"
                             class="gallery-picture-logo">
                    </div>
                </div>
                <div class="d-flex flex-column gap-3 col-12 col-md-6 col-lg-4">
                    <div id="pictureCarouselControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100 rounded-2"
                                     src="{{ URL::asset('assets/face-detect-2/slide-1.png') }}"
                                     alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100 rounded-2"
                                     src="{{ URL::asset('assets/face-detect-2/slide-2.png') }}"
                                     alt="Second slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#pictureCarouselControls" role="button"
                           data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#pictureCarouselControls" role="button"
                           data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    </div>
                    <div class="gallery-container d-flex flex-row justify-content-center align-items-center">
                        <img src="{{ URL::asset('assets/face-detect-2/picture-gallery.png') }}" alt="progress"
                             style="max-width: 150px">
                        <img src="{{ URL::asset('assets/face-detect-2/picture-gallery-logo.png') }}" alt="progress"
                             class="gallery-picture-logo">
                    </div>
                </div>
            </div>

            <div id="DetectFace" class="row gx-5 justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-10 col-xs-11 align-items-center px-4">
                    <div class="text-center my-5">
                        <form id="face-detect-form" class="form-inline d-grid d-sm-flex justify-content-sm-center mb-3">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input id="face-detect-input" type="file" class="custom-file-input" accept="image/png, image/jpeg, image/jpg">
                                    <label class="file-label" for="face-detect-input">
{{--                                        <a class="btn btn-light position-absolute top-0 left-0 py-2">آپلود عکس</a>--}}
                                        <div class="select-picture text-center py-2 mb-2">یک عکس انتخاب کنید</div>
{{--                                        <small id="face-detect-input-label" class="fw-bold">یه عکس انتخاب کن</small>--}}
                                        <div class="d-flex justify-center gap-1">
                                            <div class="upload-image cursor-pointer">
                                                آپلود عکس
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
                                                </svg>
                                            </div>

{{--                                            <img src="{{ URL::asset('assets/face-detect-2/upload-image.png') }}" alt="" class="upload-image">--}}
{{--                                            <button id="go-away"--}}
{{--                                                    class="go-away-button">--}}
{{--                                                <img src="{{ URL::asset('assets/face-detect-2/click-here.png') }}" alt=""--}}
{{--                                                     class="upload-image">--}}
{{--                                            </button>--}}
                                            <button id="go-away" class="custom-btn w-100">کلیک کنید</button>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </form>
                        <div class="row justify-content-center min-h-300">
                            <div class="col-sm-12">
                                <div id="face-detect-box" class="card bg-transparent border-0 position-relative">
                                    <div id="face-detect-alert">

                                    </div>
                                    <div class="">
                                        <img id="face-detect-image" class="card-img-top position-relative d-none" src="#" alt="your image" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div id="face-detect-result" class="row justify-content-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="position-relative">
                    <img src="{{ URL::asset('assets/banner-2-min.png') }}" class="w-100" style="min-height: 150px"/>
                    <div class="center position-absolute top-0">
                        <div class="center-inner lead-text h1">
                            <div class="row justify-content-center">
                                <div class="col-xxxl-5 col-xxl-6 col-xl-7 col-lg-8 col-md-10 col-sm-12 text-align-center py-3">
                                    <div class="lead-text h1">
                                        <p>
                                            اگه می خوای با یک مشاوره خوب نمره زیباییت بالاتر بره
                                            شمارتو بذار تا باهم بالاتر ببریمش ...
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container py-5">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-6 col-md-7 col-sm-12 px-5">
                            <div id="contact-form-alert">

                            </div>
                            <form id="contact-form" class="contact-form">
                                <div class="form-group mb-3">
                                    <input type="text" name="sender_name" class="form-control" placeholder="نام و نام خانوادگی">
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" name="sender_mobile" class="form-control" placeholder="شماره موبایل">
                                </div>
                                <button id="contact-btn" class="custom-btn contact-custom-btn float-left" >ارسال</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="d-flex flex-column flex-sm-column flex-md-row flex-lg-row mt-5 justify-content-center align-items-center gap-3">
                <a href="tel:+989333667816"
                   class="d-flex flex-row align-items-center text-decoration-none justify-content-center">
                    <img src="{{ URL::asset('assets/face-detect-2/phone-golden.png') }}" alt="" class="social-icon">
                    <div class="mx-3 social-text">۰۹۳۳۳۶۶۷۸۱۶</div>
                </a>
                <a href="https://instagram.com/dr.shirinbehjati"
                   class="d-flex flex-row align-items-center justify-content-center text-decoration-none">
                    <img src="{{ URL::asset('assets/face-detect-2/instagram-golden.png') }}" alt=""
                         class="social-icon">
                    <div class="mx-3 social-text">dr.shirinbehjati</div>
                </a>
                <a href="https://t.me/dr.shirinbehjati"
                   class="d-flex flex-row align-items-center justify-content-center text-decoration-none">
                    <img src="{{ URL::asset('assets/face-detect-2/telegram-golden.png') }}" alt=""
                         class="social-icon">
                    <div class="mx-3 social-text">Telegram Channel</div>
                </a>
            </div>
            <div class="footer text-align-center pt-5">
                <p>تمام حقوق مادی و معنوی برای مجموعه پاسیو محفوظ است.</p>
            </div>

        </div>

    </section>

    <section>


    <section>
        <div id="cropping-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body px-0 cropping-box">
                        <img id="cropping-image">
                        <button id="crop" class="btn btn-primary upload-face-btn w-100">انتخاب</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- JQuery core JS-->
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<!-- Bootstrap core JS-->
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<!-- Heic2Any Lib JS-->
{{--
<script src="{{ URL::asset('js/heic2any.min.js') }}"></script>
--}}
<!-- Cropper -->
<script src="{{ URL::asset('js/cropper.min.js') }}"></script>
<!-- Core theme JS-->
<script src="{{ URL::asset('js/landings/face-detect-1.js?i=2') }}"></script>

{{--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>--}}
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>--}}

</body>
</html>

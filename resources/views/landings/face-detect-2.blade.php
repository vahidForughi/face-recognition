<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="شناسایی و ارزیابی چهره ، مشاوره ترمیم صورت و بهبود نا محسوس زیبایی" />
    <meta name="author" content="" />
    <title>ارزیابی چهره - شیرین بهجتی</title>

    <meta property="og:site_name" content="ارزیابی چهره">
    <meta property="og:title" content="ارزیابی چهره - شیرین بهجتی" />
    <meta property="og:description" content="شناسایی و ارزیابی چهره ، مشاوره ترمیم صورت و بهبود نا محسوس زیبایی" />
{{--    <meta property="og:image" itemprop="image" content="{{ URL::asset('assets/favicon.png?i=2') }}">--}}
    <meta property="og:type" content="website" />
    <meta property="og:updated_time" content="1698583216" />

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('assets/favicon.png?i=3') }}" />

{{--    <link href="{{ URL::asset('css/fonts.googleapis.css') }}" rel="stylesheet" />--}}
    <link href="{{ URL::asset('css/fonts.byekan+.css') }}" rel="stylesheet" />
    <!-- Bootstrap icons-->
    <link href="{{ URL::asset('css/bootstrap-icons.css') }}" rel="stylesheet" />
    <!-- Cropper -->
    <link href="{{ URL::asset('css/cropper.min.css') }}" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ URL::asset('css/styles.css?i=9') }}" rel="stylesheet" />
    <link href="{{ URL::asset('css/landings/face-detect-1.css?i=2') }}" rel="stylesheet" />

</head>
<body>
<main>
    <!-- Header-->
    <header class="py-2">
        <div class="container-fluid px-0 pb-0">
            <img src="{{ URL::asset('assets/banner-min.png') }}" width="100%" alt="face detect"/>
            <div class="row gx-5 justify-content-center align-items-center">
                <div class="col-xl-5 col-md-8 col-sm-12 text-align-center">
                    <p class="h4">زیبایی خودت رو ارزیابی کن</p>
                    <a href="#DetectFace" class="custom-btn main-custom-btn">اینجا کلیک کن</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Recognition Section-->
    <section id="recognition-face">
        <div class="container">
            <div class="row justify-content-around align-items-center">
                <div class="col-md-6 col-sm-12 text-align-center pt-6">
                    <p class="h3 text-white">کارنامه خوشگلیت رو بگیر...</p>
                    <br/>
                    <p class="h5">فقط یه عکس بهم بده...</p>
                    <p class="h3 fw-bold">تا بهت بگم چه جوری</p>
                    <p class="h3 fw-bold">نا محسوس زیباتر بشی:)</p>
                </div>
                <div class="col-md-6 col-sm-12 text-align-center">
                    <p class="h4">شناسایی چهره</p>
                    <img src="{{ URL::asset('assets/recognition-min.gif') }}" alt="recognition face" class="face-recognition"/>
                </div>
            </div>
        </div>
    </section>

    <!-- Detect Section-->
    <section id="DetectFace">
        <div class="container-fluid px-0 face-detect-container">
            <div class="row gx-5 justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-10 col-xs-11 align-items-center px-4">
                    <div class="text-center my-5">
                        <form id="face-detect-form" class="form-inline d-grid d-sm-flex justify-content-sm-center mb-3">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input id="face-detect-input" type="file" class="custom-file-input" accept="image/png, image/jpeg, image/jpg">
                                    <label class="file-label" for="face-detect-input">
                                        <a class="btn btn-light position-absolute top-0 left-0 py-2">آپلود عکس</a>
                                        <small id="face-detect-input-label" class="fw-bold">یه عکس انتخاب کن</small>
                                        <button id="go-away" class="btn btn-primary upload-face-btn position-absolute right-0 top-0">کلیک کنید</button>
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

            <div class="footer text-align-center pt-5">
                <p>تمام حقوق مادی و معنوی برای مجموعه پاسیو محفوظ است.</p>
            </div>

        </div>

    </section>

    <section>

        <div id="cropping-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
{{--<script src="{{ URL::asset('js/heic2any.min.js') }}"></script>--}}
<!-- Cropper -->
<script src="{{ URL::asset('js/cropper.min.js') }}"></script>
<!-- Core theme JS-->
<script src="{{ URL::asset('js/landings/face-detect-1.js?i=2') }}"></script>

</body>
</html>

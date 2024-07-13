<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="شناسایی و ارزیابی چهره ، مشاوره ترمیم صورت و بهبود نا محسوس زیبایی" />
    <meta name="author" content="" />
    <title>ارزیابی چهره - مریم حمزه‌ای</title>

    <meta property="og:site_name" content="ارزیابی چهره">
    <meta property="og:title" content="ارزیابی چهره - مریم حمزه‌ای" />
    <meta property="og:description" content="شناسایی و ارزیابی چهره ، مشاوره ترمیم صورت و بهبود نا محسوس زیبایی" />
{{--    <meta property="og:image" itemprop="image" content="{{ URL::asset('assets/favicon.png?i=1') }}">--}}
    <meta property="og:type" content="website" />
    <meta property="og:updated_time" content="1698583216" />

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('assets/favicon.png?i=2') }}" />

{{--    <link href="{{ URL::asset('css/fonts.googleapis.css') }}" rel="stylesheet" />--}}
    <link href="{{ URL::asset('css/fonts.byekan+.css') }}" rel="stylesheet" />
    <!-- Bootstrap icons-->
    <link href="{{ URL::asset('css/bootstrap-icons.css') }}" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ URL::asset('css/styles.css?i=8') }}" rel="stylesheet" />
    <link href="{{ URL::asset('css/face-detect-1.css?i=1') }}" rel="stylesheet" />

</head>
<body class="d-flex flex-column h-100">
<main class="flex-shrink-0">
    <!-- Header-->
    <header class="py-2">
        <div class="container-fluid px-0 pb-0">
            <div class="position-relative" style="min-height: 190px">
                <img src="{{ URL::asset('assets/banner-min.png') }}" width="100%" style="width: 100%" alt="face detect"/>
{{--                <ul class="socials">--}}
{{--                    <li><a class="text-gradient" href="#!"><i class="bi bi-twitter"></i></a></li>--}}
{{--                    <li><a class="text-gradient" href="#!"><i class="bi bi-twitter"></i></a></li>--}}
{{--                    <li><a class="text-gradient" href="#!"><i class="bi bi-twitter"></i></a></li>--}}
{{--                </ul>--}}
            </div>
            <div class="row gx-5 justify-content-center align-items-center">
                <div class="col-xl-5 col-md-8 col-sm-12 text-align-center">
                    <p style="font-size: 23px">زیبایی خودت رو ارزیابی کن</p>
                    <a href="#recognition-face" class="custom-btn main-custom-btn">اینجا کلیک کن</a>
{{--                    <p style="color: white;font-size: 15px">فقط یه عکس از صورت خودت آپلود کن و منتظر باش</p>--}}
                </div>
            </div>
        </div>
    </header>
    <!-- About Section-->
    <section id="recognition-face">
        <div class="container">
            <div class="row justify-content-around align-items-center">
                <div class="col-md-6 col-sm-12 text-align-center pt-6">
                    <p class="h3" style="color: white">کارنامه خوشگلیت رو بگیر...</p>
                    <br/>
                    <p class="h5">فقط یه عکس بهم بده...</p>
                    <p class="h3 fw-bold">تا بهت بگم چه جوری</p>
                    <p class="h3 fw-bold">نا محسوس زیباتر بشی:)</p>
                </div>
                <div class="col-md-6 col-sm-12 text-align-center">
                    <p style="font-size: 23px">شناسایی چهره</p>
                    <img src="{{ URL::asset('assets/recognition-min.gif') }}" alt="recognition face" class="face-recognition"/>
                </div>
            </div>
        </div>
    </section>

    <section id="DetectFace" class="bg-dark">
        <div class="container-fluid px-0 face-detect-container">
            <div class="row gx-5 justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-10 col-xs-11 align-items-center px-4">
                    <div class="text-center my-5">
                        <form id="form-face-detect" class="form-inline d-grid d-sm-flex justify-content-sm-center mb-3">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input id="image-input" type="file" class="custom-file-input" accept="image/png, image/jpeg, image/jpg, image/heic, image/heif">
                                    <label class="file-label" for="image-input">
                                        <a id="image-input" class="btn btn-light position-absolute top-0 left-0 py-2">آپلود عکس</a>
                                        <small class="fw-bold" id="image-input-label">یه عکس انتخاب کن</small>
                                        <button id="go-away" class="btn btn-primary upload-face-btn position-absolute right-0 top-0">کلیک کنید</button>
                                    </label>
                                </div>
                            </div>
                        </form>
                        <div class="row justify-content-center" style="min-height: 300px">
                            <div class="col-sm-12">
                                <div id="face-detect" class="card bg-transparent border-0 position-relative">

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
{{--                                        <p>اگه می خوای با یک مشاوره خوب نمره زیباییت بالاتر بره</p>--}}
{{--                                        <p>شمارتو بزار تا باهم بالاتر ببریمش ...</p>--}}
                                    </div>
                                </div>
                            </div>
{{--                            <p>اگه می خوای با یک مشاوره خوب نمره زیباییت بالاتر بره</p>--}}
{{--                            <p>شمارتو بزار تا باهم بالاتر ببریمش ...</p>--}}
                        </div>
{{--                        <span class="center-inner">--}}
{{--                            dfknvdkfjv--}}

{{--                        </span>--}}
                    </div>
                </div>
{{--                <div class="banner-2-container">--}}
{{--                    <div class="row justify-content-center">--}}
{{--                        <div class="col-md-10 col-sm-11 text-align-center py-4">--}}
{{--                            <div class="lead-text h1">--}}
{{--                                <p>اگه می خوای با یک مشاوره خوب نمره زیباییت بالاتر بره</p>--}}
{{--                                <p>شمارتو بزار تا باهم بالاتر ببریمش ...</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
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

</main>

<!-- JQuery core JS-->
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<!-- Bootstrap core JS-->
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<!-- Heic2Any Lib JS-->
<script src="{{ URL::asset('js/heic2any.min.js') }}"></script>
<!-- Core theme JS-->
<script src="{{ URL::asset('js/scripts.js?i=7') }}"></script>

</body>
</html>

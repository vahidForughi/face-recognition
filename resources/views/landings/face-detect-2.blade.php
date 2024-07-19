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
    <header class="section section-1">
        <div class="w-100">
            <div class="login-container d-flex flex-row justify-content-center align-items-center gap-3 p-3">
                <div class="text-white fw-bold">Signup</div>
                <div class="bg-white" style="height: 20px; width: 3px"></div>
                <div class="text-white fw-bold">Login</div>
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="white" class="bi bi-person-circle"
                     viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path fill-rule="evenodd"
                          d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>

            </div>
            <div class="social-media-container d-flex flex-column py-4 px-2 gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" class="bi bi-twitter"
                     viewBox="0 0 16 16">
                    <path
                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334q.002-.211-.006-.422A6.7 6.7 0 0 0 16 3.542a6.7 6.7 0 0 1-1.889.518 3.3 3.3 0 0 0 1.447-1.817 6.5 6.5 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.32 9.32 0 0 1-6.767-3.429 3.29 3.29 0 0 0 1.018 4.382A3.3 3.3 0 0 1 .64 6.575v.045a3.29 3.29 0 0 0 2.632 3.218 3.2 3.2 0 0 1-.865.115 3 3 0 0 1-.614-.057 3.28 3.28 0 0 0 3.067 2.277A6.6 6.6 0 0 1 .78 13.58a6 6 0 0 1-.78-.045A9.34 9.34 0 0 0 5.026 15"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white"
                     class="bi bi-facebook" viewBox="0 0 16 16">
                    <path
                        d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white"
                     class="bi bi-instagram" viewBox="0 0 16 16">
                    <path
                        d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" class="bi bi-youtube"
                     viewBox="0 0 16 16">
                    <path
                        d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.01 2.01 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.01 2.01 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31 31 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.01 2.01 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A100 100 0 0 1 7.858 2zM6.4 5.209v4.818l4.157-2.408z"/>
                </svg>
            </div>
        </div>
    </header>

    <div class="section section-2"></div>
    <div class="section section-3">
        <div class="d-flex flex-column align-items-center">
            <img src="{{ URL::asset('assets/face-detect-2/progress.png') }}" alt="progress" class="w-25">
            <img src="{{ URL::asset('assets/face-detect-2/loading.png') }}" alt="loading"
                 class="loading-image w-25 mt-3">
            <img src="{{ URL::asset('assets/face-detect-2/be-prettier.png') }}" alt="be-prettier"
                 class="w-75 mx-5 mt-5">
            <div class="detect-beauty mt-5 text-center">شناسایی زیبایی</h1>
                <div class="send-picture-text p-2 rounded-4 text-black mt-3 mx-2">فقط یک عکس ایستاده همراه چهره برام
                    بفرست تا
                    بگم چیکار کنی...
                </div>
            </div>
        </div>
    </div>
    <div class="section section-4">
        <div class="d-flex flex-column align-items-center justify-content-center w-100">
            <div
                class="d-flex flex-column flex-sm-column flex-lg-row align-items-center justify-content-around gap-5 w-50">
                <div class="gallery-container d-flex flex-row justify-content-center align-items-center">
                    <img src="{{ URL::asset('assets/face-detect-2/picture-gallery.png') }}" alt="progress"
                         style="max-width: 150px">
                    <img src="{{ URL::asset('assets/face-detect-2/picture-gallery-logo.png') }}" alt="progress"
                         class="gallery-picture-logo">
                </div>
                <div class="gallery-container d-flex flex-row justify-content-center">
                    <img src="{{ URL::asset('assets/face-detect-2/video.png') }}" alt="progress"
                         style="max-width: 150px">
                    <img src="{{ URL::asset('assets/face-detect-2/video-logo.png') }}" alt="progress"
                         class="gallery-picture-logo">
                </div>
            </div>

            <div id="DetectFace" class="d-flex flex-column mt-5 gap-4">
                <form id="face-detect-form">
                    <div class="select-picture text-center">یک عکس انتخاب کنید</div>
                    <div class="custom-file">
                        <input id="face-detect-input" type="file" class="custom-file-input"
                               accept="image/png, image/jpeg, image/jpg">
                        <label
                            class=" d-flex flex-column flex-sm-column flex-md-row flex-lg-row align-items-center justify-content-center gap-3"
                            for="face-detect-input">
                            <img src="{{ URL::asset('assets/face-detect-2/upload-image.png') }}" alt=""
                                 class="upload-image">
                            <button id="go-away"
                                    class="go-away-button">
                                <img src="{{ URL::asset('assets/face-detect-2/click-here.png') }}" alt=""
                                     class="upload-image">
                            </button>
                        </label>
                    </div>
                </form>
                <div class="row justify-content-center">
                    <div class="col-sm-12">
                        <div id="face-detect-box" class="card bg-transparent border-0 position-relative">
                            <div id="face-detect-alert">

                            </div>
                            <div class="">
                                <img id="face-detect-image" class="h-25 mx-auto position-relative d-none" src="#"
                                     alt="your image"/>
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
    <div class="section section-5">
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
        <div class="text-center bg-transparent p-4 text-white">تمام حقوق مادی و معنوی برای مجموعه پاسو مخفوظ
            است
        </div>
    </div>
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

</body>
</html>

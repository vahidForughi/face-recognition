<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="آزمون تست هوش" />
    <meta name="author" content="" />
    <title>آزمون</title>

    <meta property="og:site_name" content="آزمون">
    <meta property="og:title" content="آزمون" />
    <meta property="og:description" content="آزمون تست هوش" />
{{--    <meta property="og:image" itemprop="image" content="{{ URL::asset('assets/favicon.png?i=2') }}">--}}
    <meta property="og:type" content="website" />
    <meta property="og:updated_time" content="1698583216" />

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('assets/quiz.png') }}" />

    <link href="{{ URL::asset('css/fonts.byekan+.css') }}" rel="stylesheet" />

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('css/landings/exam-0.css') }}" rel="stylesheet" />

</head>
<body class="is-boxed has-animations">
<div id="app" class="body-wrap boxed-container">
    <header class="site-header">
        <div class="container">
            <div class="site-header-inner">
                <div class="brand header-brand">
                    <h1 class="m-0">
                        <a href="#">
                            <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <title>آزمون تست هوش</title>
                                <defs>
                                    <radialGradient cy="0%" fx="50%" fy="0%" r="100%" id="logo-gradient">
                                        <stop stop-color="#FFF" offset="0%"/>
                                        <stop stop-color="#FFF" stop-opacity=".24" offset="100%"/>
                                    </radialGradient>
                                </defs>
                                <path d="M16 32C7.163 32 0 24.837 0 16S7.163 0 16 0s16 7.163 16 16-7.163 16-16 16zm0-10a6 6 0 1 0 0-12 6 6 0 0 0 0 12z" fill="url(#logo-gradient)" fill-rule="evenodd"/>
                            </svg>
                        </a>
                    </h1>
                </div>
                <ul class="header-links list-reset m-0">
                    <li>
                        <a href="#">شروع آزمون</a>
                    </li>
                    <!--                        <li>-->
                    <!--                            <a class="button button-sm button-shadow" href="#">Signup</a>-->
                    <!--                        </li>-->
                </ul>
            </div>
        </div>
    </header>

    <main>
        <section class="hero text-light text-center">
            <div class="container-sm">
                <div class="hero-inner">
                    <h1 class="hero-title h2-mobile mt-0 is-revealing">آزمون تست هوش</h1>
                    <p class="hero-paragraph is-revealing">با شرکت در این آزمون، هوش خود را محک بزن.</p>
                    <p class="hero-cta is-revealing"><a class="button button-secondary button-shadow" href="#exam-box">همین حالا شروع کنید</a></p>
                    <div id="exam-box" class="card border-0 shadow">
                        <div v-if="page == 'exam'" class="card-body text-white bg-primary text-right rounded">
                            <form ref="exam-form" id="exam-form" @submit.prevent="sendResponse('{{ $exam->slug }}')">
                                <div class="row">
                                    <div class="col-8">

                                        <div class="form-group pb-5">
                                            <label for="fullnameInput" class="pb-2">نام کامل خود را وارد کنید</label>
                                            <input v-model="examForm.fullname" type="text" class="form-control form-control-sm" id="fullnameInput" name="fullname" aria-describedby="fullnameHelp" placeholder="">
                                            {{--<small id="fullname" class="form-text text-muted">نام خود را وارد کنید.</small>--}}
                                        </div>
                                        <div class="form-group pb-5">
                                            <label for="mobileInput" class="pb-2">شماره موبایل خود را وارد کنید</label>
                                            <input v-model="examForm.mobile" type="text" class="form-control form-control-sm" id="mobileInput" name="mobile" placeholder="">
                                        </div>
                                        @foreach ($exam->questions as $question)
                                            <div class="form-group pb-5">
                                                <label class="pb-2" for="question-input-{{$question->id}}">{{ $question->title }}</label>
                                                @if (in_array($question->type, ["Text", "Number", "Email", "Password", "Url", "Color", "Time", "Date", "DateTime-Local", "Month", "Week"]))
                                                    <input
                                                        v-model="examForm.responses[{{$question->id}}]"
                                                        type="{{ $question->type }}"
                                                        @if($question->type == "Integer") min="0" @endif
                                                        class="form-control form-control-sm"
                                                        name="input-{{$question->id}}"
                                                        id="question-input-{{$question->id}}"
                                                        aria-describedby="question-help-{{$question->id}}"
                                                        placeholder="" />
                                                @elseif (in_array($question->type, ["Textarea"]))
                                                    <textarea
                                                        v-model="examForm.responses[{{$question->id}}]"
                                                        class="form-control form-control-sm"
                                                        name="input-{{$question->id}}"
                                                        id="question-input-{{$question->id}}"
                                                        aria-describedby="question-help-{{$question->id}}"
                                                        placeholder=""></textarea>
                                                @elseif (in_array($question->type, ["Radio", "Checkbox"]))
                                                    @foreach($question->options as $key => $option)
                                                        <div class="form-check">
                                                            <label class="form-check-label mx-4" for="option-input-{{$question->id}}-{{$key}}">{{ $option }}</label>
                                                            {{--                                                                v-model="examForm['input-{{$question->id}}']"--}}
                                                            <input
                                                                @if ($question->type == 'Checkbox')
                                                                    @change="examForm.responses[{{$question->id}}] = toggleValueIn(examForm.responses[{{$question->id}}] ,$event.target.value); console.log(examForm.responses[{{$question->id}}])"
                                                                @elseif ($question->type == 'Radio')
                                                                    @change="examForm.responses[{{$question->id}}] = $event.target.value; console.log(examForm.responses[{{$question->id}}])"
                                                                @endif
                                                                type="{{$question->type}}"
                                                                class="form-check-input float-end"
                                                                id="option-input-{{$question->id}}-{{$key}}"
                                                                name="input-{{$question->id}}[]"
                                                                value="{{$key}}" />
                                                        </div>
                                                    @endforeach
                                                @endif

                                                @if ($question->description)
                                                    <small id="question-help-{{$question->id}}" class="form-text text-muted">{{ $question->description }}</small>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <div v-if="errors" class="alert alert-danger" role="alert">
                                        <span v-html="errors"></span>
                                    </div>
                                    <button id="send-response" type="submit" class="btn btn-success shadow px-5" :disabled="loading">
                                        <span v-if="!loading">ارسال</span>
                                        <div v-else>
                                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                            محاسبه نتیجه
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div v-else-if="page == 'score'" class="card-body text-white bg-success text-center rounded">
                            <div class="justify-center">
                                <div class="card text-center text-white bg-success mb-3">
                                    <div class="card-header">امتیاز شما</div>
                                    <div class="card-body">
                                        <h5 class="card-title">نتیجه آزمون شما</h5>
                                        <span class="display-5" v-html="score"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="clients section">
            <div class="container">
                <div class="clients-inner section-inner has-top-divider">
                    <div class="container-sm">
                        <ul class="list-reset mb-0">
                            <li>
                                <span class="screen-reader-text">Instapasio</span>
                                <img src="{{URL::asset('assets/instapasio.png')}}" width="132" height="40" alt="Instapasio"/>
                            <li>
                                <span class="screen-reader-text">Pasioco</span>
                                <img src="{{URL::asset('assets/pasioco.png')}}" width="132" height="40" alt="pasioco"/>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="features section text-center">
            <div class="container">
                <div class="features-inner section-inner has-top-divider">
                    <div class="features-wrap">
                        <div class="feature is-revealing">
                            <div class="feature-inner">
                                <div class="feature-icon">
                                    <svg width="48" height="48" xmlns="http://www.w3.org/2000/svg">
                                        <g fill="none" fill-rule="evenodd">
                                            <path fill="#84E482" d="M48 16v32H16z"/>
                                            <path fill="#0EB3CE" d="M0 0h32v32H0z"/>
                                        </g>
                                    </svg>
                                </div>
                                <h4 class="feature-title h3-mobile">تست روانشناسی</h4>
                                <p class="text-sm"></p>
                            </div>
                        </div>
                        <div class="feature is-revealing">
                            <div class="feature-inner">
                                <div class="feature-icon">
                                    <svg width="48" height="48" xmlns="http://www.w3.org/2000/svg">
                                        <g fill="none" fill-rule="evenodd">
                                            <path fill="#84E482" d="M48 16v32H16z"/>
                                            <path fill="#0EB3CE" d="M0 0v32h32z"/>
                                            <circle fill="#02C6A4" cx="29" cy="9" r="4"/>
                                        </g>
                                    </svg>
                                </div>
                                <h4 class="feature-title h3-mobile">آزمون ریاضی</h4>
                                <p class="text-sm"></p>
                            </div>
                        </div>
                        <div class="feature is-revealing">
                            <div class="feature-inner">
                                <div class="feature-icon">
                                    <svg width="48" height="48" xmlns="http://www.w3.org/2000/svg">
                                        <g fill="none" fill-rule="evenodd">
                                            <path fill="#0EB3CE" d="M0 0h32v32H0z"/>
                                            <path fill="#84E482" d="M16 16h32L16 48z"/>
                                        </g>
                                    </svg>
                                </div>
                                <h4 class="feature-title h3-mobile">پرسشنامه آنلاین</h4>
                                <p class="text-sm"></p>
                            </div>
                        </div>
                        <div class="feature is-revealing">
                            <div class="feature-inner">
                                <div class="feature-icon">
                                    <svg width="48" height="48" xmlns="http://www.w3.org/2000/svg">
                                        <g fill="none" fill-rule="evenodd">
                                            <path d="M32 40H0c0-8.837 7.163-16 16-16s16 7.163 16 16z" fill="#84E482" style="mix-blend-mode:multiply"/>
                                            <path fill="#03C5A4" d="M12 8h8v8h-8z"/>
                                            <path fill="#0EB3CE" d="M32 0h16v48H32z"/>
                                        </g>
                                    </svg>
                                </div>
                                <h4 class="feature-title h3-mobile">تست شخصیت شناسی</h4>
                                <p class="text-sm"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="site-footer mt-5">
        <div class="container text-center py-3">
            <div class="">&copy; 2018 Pasioco, all rights reserved</div>
        </div>
    </footer>
</div>
<!-- JQuery core JS-->
{{--<script src="{{ URL::asset('js/jquery.min.js') }}"></script>--}}
<!-- Bootstrap core JS-->
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('js/vue.global.js') }}"></script>
<script src="{{ URL::asset('js/landings/exam-0.min.js') }}"></script>
</body>

</html>

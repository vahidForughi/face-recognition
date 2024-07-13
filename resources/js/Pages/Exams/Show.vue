<script setup>
import PageLayout from '@/Layouts/PageLayout.vue';
import InputBgImg from '../../assets/images/input-bg-min.png';
import ExamThumbnailImg from '../../assets/images/exam-thumbnail.webp'
import { ref, reactive, toRefs } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({ exam: Object })
let { exam } = toRefs(props)
exam = reactive({
    id: exam.value.id,
    title: exam.value.title,
    slug: exam.value.slug,
    image: exam.value.image,
    description: exam.value.description,
    notice: exam.value.notice,
    thumbnail: exam.value.thumbnail,
    questions: exam.value.questions,
    questions_count: exam.value.questions_count
})
console.log('exam', exam)
const loading = ref(false)
const errors = ref('')
const alert = reactive({
    visibility: false,
    status: 'info',
    content: '',
    reset: () => {
        alert.visibility = false
        alert.status = 'info'
        alert.content = ''
    },
    show: (content, status = 'info') => {
        alert.visibility = true
        alert.status = status
        alert.content = content
    },
    info: (content) => alert.show(content, 'info'),
    success: (content) => alert.show(content, 'success'),
    warning: (content) => alert.show(content, 'warning'),
    danger: (content) => alert.show(content, 'danger')
})
const page = ref('start')
const result = reactive({
    score: 0,
    content: ''
})
const step = reactive({
    number: -1,
    percent: 0
})
const participant = reactive({
    exam_id: '',
    firstname: '',
    lastname: '',
    mobile: '',
    gender: '',
    city: '',
    responses: []
})
const images = reactive({
    inputBg: InputBgImg,
    examThumbnail: ExamThumbnailImg
})

function startExam() {
    participant.exam_id = exam.id;
    participant.responses = [];
    exam.questions.forEach((value, key) => {
        participant.responses[key] = {
            q_id: value.id,
            value: (value.type == 'checkbox') ? [] : ''
        }
    })
    page.value = 'participate';
}

function nextStep() {
    errors.value = ''
    alert.reset()
    if (step.number < 0) {
        var validation = participantSenderInfoValidation()
        if (!validation.validate) {
            errors.value = parseErrors(validation.errors)
            return 0;
        }
        if (exam.notice && exam.notice.length > 0)
            alert.info(exam.notice)
        console.log(exam.notice)
        console.log(alert)
    }
    step.number++ ;
    step.percent = calStepPercent(step.number);
    console.log(step)
    if (step.number < exam.questions_count)
        step.question = exam.questions[step.number]
    else
        sendParticipant()
}

function participantSenderInfoValidation() {
    var messages = []
    if (!participant.lastname) {
        messages.push('نام خود را وارد کنید.')
    }
    if (!participant.lastname) {
        messages.push('نام‌خانوادگی خود را وارد کنید.')
    }
    if (!participant.gender && !['male', 'female'].includes(participant.gender)) {
        messages.push('جنسیت خود را وارد کنید.')
    }
    if (!participant.city) {
        messages.push('شهر سکونت خود را وارد کنید.')
    }
    if (!participant.mobile) {
        messages.push('شماره موبایل خود را وارد کنید.')
    }
    else if (participant.mobile.length !== 11 || !participant.mobile.match(/^(09)[0-9]{9}$/g)) {
        messages.push('شماره موبایل نا معتبر است.')
    }
    return {
        validate: messages.length <= 0,
        errors: messages
    };
}

function calStepPercent(number) {
    return exam.questions_count > 0 ? Math.round((number * 100)/exam.questions_count) : 100;
}

function sendParticipant() {
    errors.value = ''
    loading.value = true;
    fetch("/api/exams/"+ exam.slug +"/participants", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            fullname: participant.firstname + ' ' + participant.lastname,
            mobile: participant.mobile,
            gender: participant.gender,
            city: participant.city,
            responses: participant.responses,
        })
    }).then(async (res) => {
        const response = await res.json()
        console.log('response', response);
        if (response.success) {
            result.score = response.data.score;
            result.content = response.data.content;
            page.value = 'score'
        }
        else{
            errors.value = response.errors ? parseErrors(response.errors) : 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...'
            console.log(errors.value)
        }
    })
    .catch((e) => {
        console.log(e)
        errors.value = e ? parseErrors(e) : 'مشکلی پیش آمده. لطفا دوباره تلاش کنید...'
    })
    .finally(() => loading.value = false)
}

function parseErrors (errs) {
    var message = ""
    if (typeof errs === 'object' && !Array.isArray(errs) && errs !== null) {
        message += parseErrors(Object.keys(errs).map(function (key) { return errs[key]; }))
    }
    else if (Array.isArray(errs)) {
        message += errs.map(function(err) {
            return parseErrors(err)
        })
    }
    else {
        message += errs + '<br>'
    }

    return message
}

// async function getImage(src) {
//     return await import(src)
// }

</script>

<template>
    <PageLayout title="آزمون">
        <div v-if="alert.visibility" class="fixed z-50 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-28 mx-auto p-3 border-2 border-blue-900 w-3/4 shadow-lg rounded-2xl bg-blue-900">
                <div class="text-center">
                    <p class="text-sm text-white py-5" v-html="alert.content"></p>
                    <div class="items-center px-2 py-3">
                        <button @click="alert.reset()" class="px-2 py-2 bg-gray-200 text-blue-900 border-2 border-blue-900
                                text-base rounded-2xl w-40
                                shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            تایید
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="exam-container sm:p-12 p-8 h-100">
            <div class="container exam-box text-white mx-auto pt-4 sm:pt-2 px-2 sm:px-6 h-100">
                <h1 class="px-4 sm:px-0 absolute text-center text-3xl leading-8 sm:text-4xl sm:leading-9">{{ exam.title }}</h1>
<!--                <Link :href="route('exams')">-->
<!--                    <span class="other-exams text-xl sm:text-2xl position-absolute -top-10 sm:-top-16 sm:top-0 left-0 py-2 px-6">پرسشنامه‌های دیگر</span>-->
<!--                </Link>-->

                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 sm:col-span-4">
                        <div class="grid grid-cols-6 flex justify-center justify-content-center items-center text-center">
                            <div class="col-span-6 gap-2 mx-auto">
                                <img class="opacity-30 sm:opacity-100 w-60 sm:w-48 md:w-58 lg:w-64 h-auto sm:mt-4" :src="exam.thumbnail ? exam.thumbnail : images.examThumbnail" :alt="exam.title"/>
                            </div>
                            <div class="col-span-6">
                                <div class="grid grid-cols-10 gap-4 sm:gap-2 sm:mt-6 justify-center justify-content-center justify-items-center sm:static absolute -bottom-5 left-0">
                                    <div class="col-span-3 col-start-5 sm:col-start-3">
                                        <img class="w-12 md:w-24 sm:w-16" src="../../assets/images/pasioco-min.png" alt="pasioco" />
                                    </div>
                                    <div class="col-span-3">
                                        <img class="w-12 md:w-24 sm:w-16" src="../../assets/images/instapasio-min.png" alt="instapasio" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-8 lg:col-span-6 xl:col-span-6 sm:py-6 text-center sm:text-start">
                        <div v-if="page == 'start'" class="absolute bottom-10 w-full right-0 sm:static">
                            <h5 class="mb-2 text-2xl hidden sm:block">آزمون {{ exam.title }}</h5>
                            <p class="mb-3 text-2xl sm:text-5xl md:text-7xl">برای شروع کلیک کنید</p>
                            <div class="img-background start-btn sm:float-left">
                                <img src="../../assets/images/btn-min.png" style="top: 18px"/>
                                <button class="img-background-content" @click="startExam">شروع</button>
                            </div>
                        </div>

                        <template v-if="page == 'participate'">
                            <h5 class="mb-2 text-2xl hidden sm:block">{{ exam.title }}</h5>
                            <form class="">
                                <template v-if="step.number < 0">
                                    <div class="absolute top-24 sm:static">
                                        <p class="mb-3 text-2xl px-3 leading-8">برای ورود به آزمون اطلاعات خود را وارد نمایید</p>
<!--                                        <div v-if="errors" class="sm:hidden text-red-700 py-3 rounded-lg relative text-xl bg-transparent" role="alert">-->
<!--                                            <span class="block sm:inline" v-html="errors"></span>-->
<!--                                        </div>-->
                                    </div>
                                    <div class="absolute w-full px-2 bottom-28 right-0 sm:static">
                                        <div class="w-full px-2 text-xl leading-xl">
                                            <div class="grid grid-cols-12 gap-x-2 sm:gap-x-8 justify-center items-center text-right text-lg sm:text-xl">
                                                <div class="col-span-6">
                                                    <p for="firstname" class="sm:block px-4">نام</p>
                                                    <div class="img-background">
                                                        <img :src="images.inputBg"/>
                                                        <input type="text" class="img-background-content placeholder-white placeholder-opacity-90 sm:placeholder-opacity-0" v-model="participant.firstname" id="firstname" autocomplete="firstname" />
                                                    </div>
                                                </div>
                                                <div class="col-span-6">
                                                    <p for="lastname" class="sm:block px-4">نام خانوادگی</p>
                                                    <div class="img-background">
                                                        <img :src="images.inputBg"/>
                                                        <input type="text" class="img-background-content placeholder-white placeholder-opacity-90 sm:placeholder-opacity-0" v-model="participant.lastname" id="lastname" autocomplete="lastname" />
                                                    </div>
                                                </div>
                                                <div class="col-span-6">
                                                    <p for="city" class="sm:block px-4">شهر سکونت</p>
                                                    <div class="img-background">
                                                        <img :src="images.inputBg"/>
                                                        <input type="text" class="img-background-content placeholder-white placeholder-opacity-90 sm:placeholder-opacity-0" v-model="participant.city" id="city" autocomplete="city" />
                                                    </div>
                                                </div>
                                                <div class="col-span-6">
                                                    <p for="gender" class="sm:block px-4">جنسیت</p>
                                                    <div class="img-background">
<!--                                                        <img :src="images.inputBg"/>-->
                                                        <div class="inline-block px-1 py-3">
                                                            <input id="gender-male" type="radio" value="male" v-model="participant.gender" autocomplete="gender" />
                                                            <label class="px-1" for="gender-male">مرد</label>
                                                        </div>
                                                        <div class="inline-block px-1 py-3">
                                                            <input id="gender-female" type="radio" value="female" v-model="participant.gender" autocomplete="gender" />
                                                            <label for="gender-female" class="px-1">زن</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-span-6 col-start-4">
                                                    <p for="mobile" class="sm:block px-4">شماره تماس</p>
                                                    <div class="img-background">
                                                        <img :src="images.inputBg"/>
                                                        <input type="text" class="img-background-content placeholder-white placeholder-opacity-90 sm:placeholder-opacity-0" v-model="participant.mobile" id="mobile" autocomplete="mobile" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <template v-else-if="step.number < exam.questions_count">
                                    <p :for="'question-input-'+ step.question.id" class="mb-3 text-2xl px-4 absolute top-24 md:px-0 sm:static leading-9">{{ step.question.title }}</p>
                                    <div class="">
                                        <div class="w-full absolute px-4 bottom-28 right-0 sm:static text-xl leading-xl">
                                            <div class="grid grid-cols-12">
                                                <template v-if="['text', 'number', 'email', 'password', 'url', 'color', 'time', 'date', 'dateTime-local', 'month', 'week'].includes(step.question.type)">
                                                    <div class="col-span-10 col-start-2 sm:col-span-10 sm:col-start-1 md:col-span-9 lg:col-span-8 img-background">
                                                        <label v-if="step.question.type === 'color'" :for="'question-input-'+ step.question.id" class="text-black font-mono text-xl font-bold dir-ltr absolute top-2 left-5 z-10" :style="'color:'+ participant.responses[step.number].value">{{ (participant.responses[step.number].value) ? participant.responses[step.number].value : '#000000' }}</label>
                                                        <img :src="images.inputBg"/>
                                                        <input
                                                            v-model="participant.responses[step.number].value"
                                                            :type="step.question.type"
                                                            :min="step.question.type == 'Integer' ? 0 : false"
                                                            class="img-background-content"
                                                            :id="'question-input-'+ step.question.id"
                                                            :aria-describedby="'question-help-'+ step.question.id"
                                                        />
                                                    </div>
                                                </template>
                                                <template v-else-if="['textarea'].includes(step.question.type)">
                                                    <div class="col-span-12 sm:col-span-8 img-background">
                                                        <img :src="images.inputBg"/>
                                                        <textarea
                                                            v-model="participant.responses[step.number].value"
                                                            :type="step.question.type"
                                                            :min="step.question.type == 'Integer' ? 0 : false"
                                                            class="img-background-content"
                                                            :id="'question-input-'+ step.question.id"
                                                            :aria-describedby="'question-help-'+ step.question.id"
                                                            rows="3"
                                                        ></textarea>
                                                    </div>
                                                </template>
                                                <template v-else-if="['radio', 'checkbox'].includes(step.question.type)">
                                                    <div class="col-span-12 span-8 text-center">
                                                        <div class="grid grid-cols-6 gap-2">
                                                            <div v-for="(option, key) in step.question.options" :key="key" class="col-span-3 img-background" >
                                                                <img :src="images.inputBg"/>
                                                                <div :class="((Array.isArray(participant.responses[step.number].value) && participant.responses[step.number].value.length > 0 && participant.responses[step.number].value.includes(key)) ||
                                                                    (participant.responses[step.number].value !== '' && participant.responses[step.number].value === key)) ? 'h-full p-1 bg-blue-600 rounded-full' : 'h-full p-1'">
                                                                    <label class="position-relative block w-full" :for="'option-input-'+step.question.id+'-'+key">{{ option }}</label>
                                                                    <input
                                                                        v-if="step.question.type == 'checkbox'"
                                                                        v-model="participant.responses[step.number].value"
                                                                        type="checkbox"
                                                                        :id="'option-input-'+step.question.id+'-'+key"
                                                                        :value="key"
                                                                        class="img-background-content rounded-full"
                                                                        style="width:3px"
                                                                    />
                                                                    <input
                                                                        v-if="step.question.type == 'radio'"
                                                                        v-model="participant.responses[step.number].value"
                                                                        type="radio"
                                                                        :id="'option-input-'+step.question.id+'-'+key"
                                                                        :value="key"
                                                                        class="img-background-content rounded-full"
                                                                        style="width:3px"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </form>
<!--                            <div class="sm:absolute mt-20 sm:bottom-20 text-center w-full sm:w-4/5 md:w-3/5 step-control">-->
<!--                                <div class="w-4/5 h-5 mx-auto bg-gray-800 rounded-full dir-ltr step-progress-box">-->
<!--                                    <div class="h-5 bg-blue-600 rounded-full step-progress" :style="'width: '+ step.percent + '%'"></div>-->
<!--                                    <span class="mx-auto step-progress-percent">{{ step.percent + '%' }}</span>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="absolute bottom-20 sm:bottom-20 w-full sm:w-3/5 sm:left-16">
                                <div class="w-4/5 h-4 sm:h-5 mx-auto bg-gray-800 rounded-full dir-ltr step-progress-box">
                                    <div class="h-4 sm:h-5 bg-blue-600 rounded-full step-progress" :style="'width: '+ step.percent + '%'"></div>
<!--                                    <div class="w-full text-center">-->
<!--                                        <span class="mx-auto step-progress-percent">{{ step.percent + '%' }}</span>-->
<!--                                    </div>-->
                                    <span class="mx-auto step-progress-percent text-sm right-1">{{ '%' + step.percent }}</span>
                                </div>
                            </div>
                        </template>

                        <template v-else-if="page === 'score'" >
                            <h5 class="text-2xl absolute top-20 right-7 sm:static">نتیجه:</h5>
                            <div class="relative text-center">
                                <div class="text-center m-auto left-0 absolute bottom-0 sm:static px-3">
                                    <div>
                                        <div class="text-5xl sm:text-8xl">امتیاز شما: {{ result.score }}</div>
                                        <p class="text-2xl sm:text-5xl leading-10">{{ result.content }}</p>
                                    </div>
                                    <div class="mt-12 sm:mt-16 md:mt-24 text-center px-5 step-control relative">
                                        <div class="w-full h-4 sm:h-5 bg-gray-800 rounded-full dir-ltr step-progress-box">
                                            <div class="h-4 sm:h-5 bg-blue-600 rounded-full step-progress" :style="'width: '+ step.percent + '%'"></div>
                                            <span class="mx-auto step-progress-percent text-sm -right-5 sm:-right-5">{{ '%' + step.percent }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <template v-if="['participate'].includes(page)">
                            <div class="absolute bottom-8 sm:bottom-16 -left-7 sm:-left-10">
                                <div v-if="errors" class="fixed bottom-12 right-4 sm:right-12 md:right-24 text-lg sm:text-xl text-right leading-7 sm:leading-8">
                                    <div class="relative bg-red-100 border border-red-400 text-red-700 rounded-2xl px-3 py-2 sm:px-4 sm:py-3" role="alert">
                                        <span class="block" v-html="errors"></span>
                                        <span @click="errors = null" class="absolute top-0 bottom-0 left-0 px-2 py-2">
                                            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                                        </span>
                                    </div>
                                </div>
<!--                                <div v-if="errors" class="hidden sm:block text-red-700 py-3 rounded-lg relative text-2xl bg-transparent" role="alert">-->
<!--                                    <span class="block leading-3 text-2xl" v-html="errors"></span>-->
<!--                                </div>-->
                                <button class="next-btn float-left" @click="nextStep()" :disabled="loading">
                                    <div v-if="loading" class="grid justify-center">
                                        <span class="relative flex h-8 w-8">
                                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                                          <span class="relative inline-flex rounded-full h-8 w-8 bg-sky-500"></span>
                                        </span>
                                    </div>
                                    <div v-else class="grid justify-center">
                                        <span class="text-sm sm:text-lg" >مرحله بعد</span>
                                    </div>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </PageLayout>
</template>

<style scoped>

.exam-container {
    background-color: #001149;
    position: fixed;
    width: 100%;
    //font-family: Arshia;
    font-family: "B Yekan+";
    //font-family: "Yekan";
    /*letter-spacing: 1.1px;*/
    font-size: 50px;
    color: white;
}

.exam-box {
    background-image: url('../../assets/images/bg-min.png');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    box-shadow: -22px 36px 143.62px 23.38px rgba(0, 0, 0, 0.3);
    border-radius: 35px;
    position: relative;
}

.other-exams {
    color: #009ea7;
}

.text-big {
    font-size: 100px;
}

.custom-input-box {
    position: relative;
    width: 200px;
    height: 60px;
    overflow: hidden;
}
.custom-input-box img {
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
}
.custom-input-box input, .custom-input-box textarea, .custom-input-box select {
    color: #57e7ab !important;
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 80%;
    background: transparent;
    border: none;
    padding: 10px 25px;
    text-align: center;
    font-size: 35px;
}

.start-btn {
    color: #57e7ab !important;
    height: 112px;
    width: 250px;
    font-size: 60px;
    display: inline-block;
}

.next-btn {
    background: url('../../assets/images/btn-2-min.png') center no-repeat transparent;
    background-size: contain;
    border: none;
    text-decoration: none;
    display: block;
    height: 48px;
    width: 210px;
    padding: 0px;
    letter-spacing: 1.1px;
}

.step-control {
    /*position: absolute;*/
    /*bottom: 50px;*/
    /*left: -42px;*/
}

.step-progress-box {
    -webkit-box-shadow:0px 0px 29px 0px rgba(7,185,173,0.55);
    -moz-box-shadow: 0px 0px 29px 0px rgba(7,185,173,0.55);
    box-shadow: 0px 0px 29px 0px rgba(7,185,173,0.55);
}
.step-progress {
    background: rgb(87,239,166);
    background: linear-gradient(90deg, rgba(87,239,166,1) 0%, rgba(80,181,196,1) 25%, rgba(66,93,230,1) 60%, rgba(0,14,58,1) 100%);
}
.step-progress-percent {
    color: #53c7bb;
    -webkit-text-shadow:0px 140px 91px rgba(83,199,187,0.72);
    -moz-text-shadow: 0px 140px 91px rgba(83,199,187,0.72);
    text-shadow: 0px 140px 91px rgba(83,199,187,0.72);
    /*position: absolute;*/
    /*top: -27px;*/
    /*right: -60px;*/
    /*font-size: 45px;*/
    position: absolute;
    top: -3px;
    /*right: 8px;*/
    /*font-size: 14px;*/
    font-weight: normal;
    font-family: sans-serif;
    letter-spacing: 0px;
}

/*input::placeholder {*/
/*    color: #fff;*/
/*    font-size: 30px;*/
/*}*/

/*input::-ms-input-placeholder { !* Edge 12 -18 *!*/
/*    color: #fff;*/
/*    font-size: 30px;*/
/*}*/

input[type="color"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    width: 100px !important;
    height: 54px !important;
    background-color: transparent;
    border: none;
    cursor: pointer;
}
input[type="color"]::-webkit-color-swatch {
    border-radius: 15px;
    border: none;
}
input[type="color"]::-moz-color-swatch {
    border-radius: 15px;
    border: none;
}


@media (max-width: 640px) {
    .exam-box {
        background-image: url('../../assets/images/bg-rotate-min.png');
    }

    .start-btn {
        height: 85px;
        width: 155px;
        font-size: 45px;
    }

    .next-btn {
        height: 35px;
        width: 145px;
        /*font-size: 30px;*/
    }
}

</style>

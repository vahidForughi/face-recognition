<script setup>
import PageLayout from '@/Layouts/PageLayout.vue';
import ExamThumbnailImg from '../../assets/images/exam-thumbnail.webp'
import { getCurrentInstance, ref, reactive, toRefs } from 'vue'

const app = getCurrentInstance()
const globalProps = app.appContext.config.globalProperties
// console.log($inertia)

const props = defineProps({ exams: Object })

let { exams } = toRefs(props)
exams = reactive(exams)
const images = reactive({
    examThumbnail: ExamThumbnailImg,
})

console.log('exams', exams)

</script>

<template>
    <PageLayout title="آزمون">
        <div class="exam-container sm:p-12 px-6 py-12 h-100">
            <div class="container exam-box text-white mx-auto px-2 sm:px-6 h-100">
                <h1 class="px-4 sm:px-0">پرسشنامه‌ها</h1>
                <div class="grid grid-cols-12 gap-4">
                    <div v-for="exam in exams" class="col-span-6 sm:col-span-4 md:col-span-3">
                        <div class="h-96 rounded-2xl overflow-hidden shadow-2xl cursor-pointer" @click="globalProps.$inertia.visit(route('exams.show', exam.slug));">
                            <img class="h-52 m-auto p-4" :src="exam.thumbnail ? exam.thumbnail : images.examThumbnail" :alt="exam.title" />
                            <div class="px-6 bg-white text-gray-800 h-full">
                                <span class="text-3xl mb-2">{{ exam.title }}</span>
                                <p class="text-gray-700 leading-7 text-2xl line-clamp-3" v-html="exam.description"></p>
                            </div>
                        </div>
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
    font-family: Arshia;
    font-size: 50px;
    color: white;
}

.exam-box {
    background-image: url('../../assets/images/bg-min.png');
    background-size: cover;
    background-position: center;
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
    font-size: 75px;
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
    font-size: 30px;
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
    -webkit-text-shadow:0px 0px 140px 91px rgba(83,199,187,0.72);
    -moz-text-shadow: 0px 0px 140px 91px rgba(83,199,187,0.72);
    text-shadow: 0px 0px 140px 91px rgba(83,199,187,0.72);
    /*position: absolute;*/
    /*top: -27px;*/
    /*right: -60px;*/
    font-size: 45px;
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
    .start-btn {
        height: 95px;
        width: 155px;
        font-size: 55px;
    }
}

</style>

import "./heic2any.min.js"

console.log('00')

// for(let i = 0; i < process.argv.length; ++i) {
//     console.log(process.argv[i]);
// }
console.log(process.argv[process.argv.length - 1])

// useEffect(() => {
// import "./heic2any.min.js"
//     const initTerminal = async () => {
//         const { Terminal } = await import('xterm')
//         const term = new Terminal()
//         // Add logic with `term`
//     }
//     initTerminal()
// }, [])
// setTimeout(function() {
//     console.log('222')
//
// }, 1000)

// fetch(process.argv[process.argv.length - 1])
//     .then((res) => {
//         // console.log('blob', res.blob());
//         res.blob()
//     })
//     .then((blob) => heic2any({
//         blob,
//         toType: "image/jpeg",
//         quality: 1,
//     }))
//     .then((conversionResult) => {
//         // imageInputUrl = URL.createObjectURL(conversionResult)
//         console.log('conversionResult', conversionResult)
//     })
//     .catch((e) => {
//         // imageInputUrl = null
//         // addAlert(faceDetect, 'فایل نا معتبر است!' )
//         console.log('error')
//     });


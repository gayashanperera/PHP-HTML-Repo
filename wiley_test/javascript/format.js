// --------format js---------------

// get current date list
let days = document.getElementsByClassName("js-date-format");
let days_array = []
for (let item of days) {
    days_array.push(new Date(item.innerHTML))
}

setInterval(() => {

    // remove previous section
    let element = document.getElementsByTagName("div"), index;
    for (index = element.length - 1; index >= 0; index--) {
        element[index].parentNode.removeChild(element[index]);
    }

    // change innerHTML with time interval 1000
    days_array.forEach((item, index) => {
        let el = document.createElement("div")
        el.innerHTML = "Started "
        let dt = document.createElement('span')
        dt.className = 'js-date-format'
        if (index === 0) {
            dt.innerHTML = parseInt((new Date() - item) / 1000) + (parseInt((new Date() - item) / 1000) === 1 ? ' second ago' : ' seconds ago')
        } else if (index === 1 || index === 2) {
            dt.innerHTML = parseInt((new Date() - item) / (1000 * 60)) + (parseInt((new Date() - item) / (1000 * 60)) === 1 ? ' minute  ago' : ' minutes  ago')
        } else if (index === 3 || index === 4 || index === 5) {
            dt.innerHTML = parseInt((new Date() - item) / (1000 * 60 * 60)) + (parseInt((new Date() - item) / (1000 * 60 * 60)) === 1 ? ' hour ago' : ' hours ago')
        } else {
            dt.innerHTML = item.toISOString()
        }
        el.appendChild(dt)
        document.body.appendChild(el)
    })
}, 1000);

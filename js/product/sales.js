if (saletime != '' || saletime != null) {
    var countInterval = setInterval(() => {
        calcSalesEndTime()
    })
}

function calcSalesEndTime() {
    const curr_time = Math.floor(Date.now() / 1000),
        remaning_time = saletime - curr_time

    if (remaning_time > 0) {
        const timer = {
            hrs: document.querySelector("#hrs"),
            mins: document.querySelector("#mins"),
            days: document.querySelector("#days"),
            secs: document.querySelector("#secs")
        }

        // get hours mins and seconds
        let days = hrs = mins = sec = "";

        days = Math.floor(remaning_time / (60 * 60 * 24));
        hrs = Math.floor(remaning_time % (60 * 60 * 24) / (60 * 60));
        mins = Math.floor(remaning_time % (60 * 60) / 60);
        secs = Math.floor(remaning_time % 60);

        days < 10 ? days = `0${days}` : days;
        mins < 10 ? mins = `0${mins}` : mins;
        hrs < 10 ? hrs = `0${hrs}` : hrs;
        secs < 10 ? secs = `0${secs}` : secs;


        //display time left
        timer.hrs.innerHTML = hrs;
        timer.mins.innerHTML = mins;
        timer.secs.innerHTML = secs;
        timer.days.innerHTML = days;
    } else clearInterval(countInterval)
}
function UpdateClock() {
    var Now = new Date();
    var Hours = Now.getHours();
    var Minuts = Now.getMinutes();
    var Seconds = Now.getSeconds();

    Hours = Hours < 10 ? "0" + Hours : Hours;
    Minuts = Minuts < 10 ? "0" + Minuts : Minuts;
    Seconds = Seconds < 10 ? "0" + Seconds : Seconds;

    var TimeString = Hours + ":" + Minuts + ":" + Seconds;
    document.getElementById("Clock").innerHTML = TimeString;
}

setInterval(UpdateClock, 1000);
UpdateClock();
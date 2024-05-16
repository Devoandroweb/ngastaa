"use strict";
document.addEventListener("DOMContentLoaded", () =>
    requestAnimationFrame(updateTime)
);
let day = (day_num)=>{
    switch(day_num) {
        case 0: return "Minggu";
        case 1: return "Senin";
        case 2: return "Selasa";
        case 3: return "Rabu";
        case 4: return "Kamis";
        case 5: return "Jum`at";
        case 6: return "Sabtu";
    }
}
function updateTime() {
    document.documentElement.style.setProperty(
        "--timer-day",
        "'" + day(moment().day()) + "'"
    );
    document.documentElement.style.setProperty(
        "--timer-hours",
        "'" + moment().format("k") + "'"
    );
    document.documentElement.style.setProperty(
        "--timer-minutes",
        "'" + moment().format("mm") + "'"
    );
    document.documentElement.style.setProperty(
        "--timer-seconds",
        "'" + moment().format("ss") + "'"
    );
    requestAnimationFrame(updateTime);
}
$(document).ready(function () {

    var eventDate = $('input[name=eventDate]').val();
//Data for flipClock
    var date = new Date(eventDate + ' GMT');
    var now = new Date();
    var diff = (date.getTime() / 1000) - (now.getTime() / 1000);
    var clock = $('.clock').FlipClock(diff, {
        clockFace: 'DailyCounter',
        countdown: true
    });
});
const timeNow = ()=>Math.floor(Date.now() / 1000);

document.addEventListener('DOMContentLoaded', ()=>{

    // Start Timing
    // const startTimingForm = document.querySelector('form.start-timing');
    // if (startTimingForm)
    // {
    //     const startTimeInput = document.querySelector('form.start-timing input[name=time]');
    //     startTimingForm.addEventListener('submit', (event)=>{
    //         event.preventDefault();
    //         startTimeInput.value = timeNow();
    //         startTimingForm.submit();
    //     });
    // }

    // Stop Timing
    // const stopTimingForm = document.querySelector('form.stop-timing');
    // if (stopTimingForm)
    // {
    //     const finishTimeInput = document.querySelector('form.stop-timing input[name=time]');
    //     stopTimingForm.addEventListener('submit', (event)=>{
    //         event.preventDefault();
    //         finishTimeInput.value = timeNow();
    //         stopTimingForm.submit();
    //     });
    // }

    // Total Time
    const totalTimeSpan = document.querySelector('.total-time span');
    if (totalTimeSpan && startedAt)
    {
        function updateTotalTime()
        {
            const updatedTotalTime = totalTime + (timeNow() - startedAt);
            const hours = Math.floor(updatedTotalTime / 60 / 60);
            const minutes = Math.floor((updatedTotalTime - hours * 60 * 60) / 60);
            const seconds = Math.floor((updatedTotalTime - hours * 60 * 60 + minutes * 60) / 60);

            totalTimeSpan.innerHTML = `${hours}h ${minutes}m ${seconds}s`;
        }
        setInterval(updateTotalTime, 50);
    }

    // Time Now
    const timeNowSpan = document.querySelector('.time-now span');
    if (timeNowSpan)
    {
        function updateCurrentTime()
        {
            timeNowSpan.innerHTML = timeNow();
        }
        setInterval(updateCurrentTime, 50);
    }

});

document.addEventListener('DOMContentLoaded', ()=>{

    // Start Timing
    const startTimingForm = document.querySelector('form.start-timing');
    const startTimeInput = document.querySelector('form.start-timing input[name=time]');
    startTimingForm.addEventListener('submit', (event)=>{
        event.preventDefault();
        startTimeInput.value = Math.floor(Date.now() / 1000);
        startTimingForm.submit();
    });

    // Stop Timing
    const stopTimingForm = document.querySelector('form.stop-timing');
    const finishTimeInput = document.querySelector('form.stop-timing input[name=time]');
    stopTimingForm.addEventListener('submit', (event)=>{
        event.preventDefault();
        finishTimeInput.value = Math.floor(Date.now() / 1000);
        stopTimingForm.submit();
    });

    const totalTimeField = document.querySelector('.total-time')
    function updateTotalTime()
    {
        totalTimeField.innerHTML = totalTime + (Math.floor(Date.now() / 1000) - startedAt);
    }
    if (startedAt)
    {
        setInterval(updateTotalTime, 50);
    }

});

const drumRoll = document.getElementById('drumRoll');
const launchButton = document.getElementById('launch-draw')
const leaveDrawPageButton = document.getElementById('leaveDrawPage')
const credits = document.getElementById('wrapper')
const looserName = document.getElementById('looser')
const body = document.getElementById('body')
var delayInMilliseconds = 24000; //1 second

launchButton.addEventListener('click', function () {
    launchButton.classList.add('hide');
    body.classList.add('body');
    credits.classList.toggle('active');
    drumRoll.play();
    setTimeout(function() {
        looserName.classList.add('fixed')
        credits.classList.toggle('active');
        leaveDrawPageButton.classList.remove('hide');
        setTimeout(function() {
            body.classList.remove('body');
        }, delayInMilliseconds);
    }, delayInMilliseconds);
})

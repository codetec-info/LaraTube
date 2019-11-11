let player = videojs('video');

let viewLogged = false;

player.on('timeupdate', function () {
    let percentagePlayed = Math.ceil(player.currentTime() / player.duration() * 100);
    if (percentagePlayed > 5 && !viewLogged) {

        axios.put('/videos/' + window.CURRENT_VIDEO);

        viewLogged = true;
    }
});

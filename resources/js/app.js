import './bootstrap';
import './video';

import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'

window.Alpine = Alpine

Alpine.plugin(persist)

Alpine.store('status', {
    videoWorks : !!document.createElement('video').canPlayType,
    isPlaying: false,
    videoDuration: null,
    timeElapsed: null,
    percentElapsed: 0,
    seek: 0,
    progressBar: 0,
    seekTooltip: null,
    videos: Alpine.$persist([
        { foo: 'uno'},
        { bar: 'due'},
        { baz: 'tre'}
    ]).as('contatore'),
    changeMe(index,prop,value) {
        console.log(this.videos[index][prop])
        console.log(value)
        this.videos[index][prop] = value + ' rigo ' + Math.floor(Math.random() * 10)
    },
    togglePlay() {
        if (this.$refs.video.paused || this.$refs.video.ended) {
            this.$refs.video.play()
            this.isPlaying  = true
        } else {
            this.$refs.video.pause()
            this.isPlaying  = false
        }
    },
    formatTime(timeInSeconds) {
        const result = new Date(timeInSeconds * 1000).toISOString().substr(11, 8)
        return {
          minutes: result.substr(3, 2),
          seconds: result.substr(6, 2)
        };
      },
      initializeVideo() {
        const videoDuration = Math.round(this.$refs.video.duration)
        this.$refs.seek.setAttribute('max', videoDuration)
        this.$refs.progressBar.setAttribute('max', videoDuration)
        const time = this.formatTime(videoDuration)
        this.$refs.duration.innerText = `${time.minutes}:${time.seconds}`
        this.$refs.duration.setAttribute('datetime', `${time.minutes}m ${time.seconds}s`)
        return `${time.minutes}:${time.seconds}`
      },
      updateTimeElapsed() {
        const time = this.formatTime(Math.round(this.$refs.video.currentTime))
        this.$refs.timeElapsed.innerText = `${time.minutes}:${time.seconds}`
        this.$refs.timeElapsed.setAttribute('datetime', `${time.minutes}m ${time.seconds}s`)
        this.timeElapsed = `${time.minutes}:${time.seconds}`
        return `${time.minutes}:${time.seconds}`
      },
      updatePercentElapsed() {
        const videoDuration = Math.round(this.$refs.video.duration)
        const time = Math.round(this.$refs.video.currentTime)
        this.percentElapsed = time/videoDuration
        return time/videoDuration
      },
      updateProgress() {
        this.$refs.progressBar.value = Math.floor(this.$refs.video.currentTime)
        this.$refs.seek.value = Math.floor(this.$refs.video.currentTime)
      },
      test(event) {
        let x = event.offsetX;
        document.getElementById("demo").innerHTML = "The x-coordinate is: " + x;
      },
      updateSeekTooltip(event) {
        const skipTo = Math.round((event.offsetX / event.target.clientWidth) * parseInt(event.target.getAttribute('max'), 10));
        this.$refs.seek.setAttribute('data-seek', skipTo)
        const t = this.formatTime(skipTo);
        this.seekTooltip = `${t.minutes}:${t.seconds}`;
        const rect = this.$refs.video.getBoundingClientRect();
        seekTooltip.style.left = `${event.pageX - rect.left}px`;
      },
      // skipAhead jumps to a different point in the video when
      // the progress bar is clicked
      skipAhead(event) {
        const skipTo = event.target.dataset.seek ? event.target.dataset.seek : event.target.value;
        console.log(skipTo);
        this.currentTime = skipTo;
        this.progressBar = skipTo;
        this.seek = skipTo;
      },
      animatePlayback() {
        this.$refs.playbackAnimation.animate([
          {
            opacity: 1,
            transform: "scale(1)",
          },
          {
            opacity: 0,
            transform: "scale(1.3)",
          }], {
          duration: 500,
        });
      },
      hideControls() {
        if (this.$refs.video.paused) {
            return;
        }
        this.$refs.videoControls.classList.add('hide');
      },
      showControls() {
        this.$refs.videoControls.classList.remove('hide');
      }
});
Alpine.start()

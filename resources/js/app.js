import './bootstrap'
// import './video'

import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'

window.Alpine = Alpine

Alpine.plugin(persist)

Alpine.store('status', {
    videoWorks : !!document.createElement('video').canPlayType,
    isPlaying: false,
    videoDuration: null,
    timeElapsed: null,
    currentTime: 10,
    percentElapsed: 0,
    seek: 0,
    progressBar: 0,
    completedTime: Alpine.$persist(0).as('completed'),
    seekTooltip: null,
    mute: false,
    fullScreen: false,
    videos: Alpine.$persist([
        { foo: 'uno'},
        { bar: 'due'},
        { baz: 'tre'}
    ]).as('contatore'),
    changeMe(index,prop,value) {
        this.videos[index][prop] = value + ' rigo ' + Math.floor(Math.random() * 10)
    },
    getCurTime() {
        alert(this.$refs.video.currentTime)
    },
    setCurTime(arg) {
        this.currentTime = arg
        this.$refs.video.currentTime = this.currentTime
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
        }
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
        this.currentTime = this.$refs.video.currentTime
        if (this.$refs.video.currentTime > this.completedTime) {
            this.completedTime = this.$refs.video.currentTime
        }
        this.$refs.timeElapsed.innerText = `${time.minutes}:${time.seconds}`
        this.$refs.timeElapsed.setAttribute('datetime', `${time.minutes}m ${time.seconds}s`)
        this.timeElapsed = `${time.minutes}:${time.seconds}`
        // return `${time.minutes}:${time.seconds}`
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
        this.progressBar = this.$refs.video.currentTime
        this.seek = this.$refs.video.currentTime
        this.currentTime = this.$refs.video.currentTime
      },
      updateSeekTooltip(event) {
        const skipTo = Math.round((event.offsetX / event.target.clientWidth) * parseInt(event.target.getAttribute('max'), 10))
        this.$refs.seek.setAttribute('data-seek', skipTo)
        const t = this.formatTime(skipTo)
        this.seekTooltip = `${t.minutes}:${t.seconds}`
        const rect = this.$refs.video.getBoundingClientRect()
        seekTooltip.style.left = `${event.pageX - rect.left}px`
      },
      // skipAhead jumps to a different point in the video when
      // the progress bar is clicked
      skipAhead(event) {
        const skipTo = event.target.dataset.seek ? event.target.dataset.seek : event.target.value
        if (skipTo > this.completedTime) {
            console.log(skipTo)
            this.setCurTime(this.completedTime)
            this.$refs.video.pause()
            alert('Non puoi andare avanti altrimenti ti stronzo')
        } else {
            this.setCurTime(skipTo)
        }
        // this.setCurTime(skipTo)
        // this.currentTime = skipTo
        // this.progressBar = skipTo
        // this.seek = skipTo
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
        })
      },
      toggleMute() {
        this.$refs.video.muted = !this.$refs.video.muted

        if (this.$refs.video.muted) {
          this.$refs.volume.setAttribute('data-volume', this.$refs.volume.value)
          this.$refs.volume.value = 0
          this.mute = true
        } else {
          this.$refs.volume.value = this.$refs.volume.dataset.volume
          this.mute = false
        }
      },
      updateVolume() {
        if (this.$refs.video.muted) {
            this.$refs.video.muted = false
        }
        this.$refs.video.volume = this.$refs.volume.value
      },
      updateVolumeIcon() {
        this.$refs.volumeMute.classList.add('hidden')
        this.$refs.volumeLow.classList.add('hidden')
        this.$refs.volumeHigh.classList.add('hidden')


        if (this.$refs.video.muted || this.$refs.video.volume === 0) {
          this.$refs.volumeMute.classList.remove('hidden')
        } else if (this.$refs.video.volume > 0 && this.$refs.video.volume <= 0.5) {
          this.$refs.volumeLow.classList.remove('hidden')
        } else {
          this.$refs.volumeHigh.classList.remove('hidden')
        }
      },
      hideControls() {
        if (this.$refs.video.paused) {
            return
        }
        this.$refs.videoControls.classList.add('hide')
      },
      showControls() {
        this.$refs.videoControls.classList.remove('hide')
      },
      toggleFullScreen() {
        if (document.fullscreenElement) {
          document.exitFullscreen()
          this.fullScreen = false
        } else if (document.webkitFullscreenElement) {
          // Need this to support Safari
          document.webkitExitFullscreen()
          this.fullScreen = false
        } else if (this.$refs.videoContainer.webkitRequestFullscreen) {
          // Need this to support Safari
          this.$refs.videoContainer.webkitRequestFullscreen()
          this.fullScreen = true
        } else {
          this.$refs.videoContainer.requestFullscreen()
          this.fullScreen = true
        }
      },
      updateFullscreenButton() {
        fullscreenIcons.forEach(icon => icon.classList.toggle('hidden'))
        if (document.fullscreenElement) {
          this.$refs.fullscreenButton.setAttribute('data-title', 'Exit full screen (f)')
        } else {
          this.$refs.fullscreenButton.setAttribute('data-title', 'Full screen (f)')
        }
      },
      keyboardShortcuts(event) {
        const { key } = event
        switch(key) {
          case 'k':
            this.togglePlay()
            this.animatePlayback()
            if (this.$refs.video.paused) {
              this.showControls()
            } else {
              setTimeout(() => {
                this.hideControls()
              }, 2000)
            }
            break
          case 'm':
            this.toggleMute()
            break
          case 'f':
            this.toggleFullScreen()
            break
        }
      },
      test() {
        this.$nextTick(() => {
            this.target = document.querySelectorAll('use')
        })
      }
})
Alpine.start()

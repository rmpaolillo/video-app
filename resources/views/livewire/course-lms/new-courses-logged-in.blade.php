<div>
    <div x-data="videos" class="flex items-center justify-center w-full h-auto">
        <div class="flex items-center justify-center w-full h-auto my-10">
            <div class="w-full max-w-2xl">
                <h1 class="text-2xl font-bold text-center text-blue-800">
                    Frequenza Corso n. {{ $codice }}
                </h1>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-center text-purple-600">
                    {{ $title }}</h2>
                <div class="w-full p-2 mt-4 bg-green-200 rounded-lg">
                    <div class="flex flex-row items-center text-gray-700">
                        <svg class="w-6 h-6 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-gray-700">Per rispondere <span class="font-bold">cliccare</span> sul
                            testo
                            della
                            risposta.</p>
                    </div>
                </div>
                <nav aria-label="Progress" class="mt-4">
                    <ol role="list" class="flex items-center">
                        <template x-for="(video, key) in videos" :key>
                            <li class="relative" :class="key == count - 1 ? '' : 'pr-8 sm:pr-20'">
                                <!-- Upcoming Step -->
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="h-0.5 w-full "
                                        :class="video.completed == 1 ? 'bg-violet-600' : 'bg-gray-200'"></div>
                                </div>
                                <template x-if="video.completed == 1 && key == index">
                                <a href="#"
                                    class="relative flex items-center justify-center w-8 h-8 bg-white border-2 rounded-full border-violet-600"
                                    aria-current="step">
                                    <span class="h-2.5 w-2.5 rounded-full bg-violet-600" aria-hidden="true"></span>
                                    <span class="sr-only" x-text="key+1"></span>
                                </a>
                                </template>
                                <template x-if="video.completed == 1 && key != index">
                                    <a href="#"
                                        class="relative flex items-center justify-center w-8 h-8 rounded-full bg-violet-600 hover:bg-violet-900"
                                        {{-- :class="key == index ? 'border-violet-600' : 'border-gray-300'" --}}>
                                        <template x-if="key != index">
                                            <svg class="w-5 h-5 text-white" viewBox="0 0 20 20" fill="currentColor"
                                                aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </template>
                                </template>
                                <span class="sr-only" x-text="key+1"></span>
                                </a>
                                <template x-if="video.completed != 1">
                                    <a href="#"
                                        class="relative flex items-center justify-center w-8 h-8 bg-white border-2 rounded-full group hover:border-gray-400"
                                        {{-- :class="video.completed == 1 ? 'bg-violet-600 hover:bg-violet-900' : ''" --}}
                                        :class="key == index ? 'border-violet-600' :
                                            'border-gray-300'"
                                        aria-current="step">
                                        <span class="h-2.5 w-2.5 rounded-full"
                                            :class="key == index ? 'bg-violet-600' :
                                                'bg-transparent group-hover:bg-gray-300'"
                                            aria-hidden="true"></span>
                                        <span class="sr-only" x-text="key+1"></span>
                                    </a>
                                </template>
                            </li>
                        </template>

                    </ol>
                </nav>
                {{-- {{ $index }} --}}
                <div class="mt-6">
                    <template x-for="(video, key) in videos" :key>
                        <template x-if="key == index">
                            <video class="w-full h-auto max-w-full" controls>
                                <source :src="video.link" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </template>
                    </template>
                </div>

                <div class="flex justify-between">
                    <button x-on:click="setCompleted({{ $index }}, 'completed', 1)"
                        class="px-4 py-3 my-2 text-white bg-green-500 rounded-lg">SET COMPLETATO</button>
                    <button x-on:click="setUncompleted({{ $index }}, 'completed', 0)"
                        class="px-4 py-3 my-2 text-white bg-red-500 rounded-lg">SET ZERO</button>
                </div>
                <div class="flex justify-between">
                    <button x-on:click="previousVideo"
                        class="px-4 py-3 my-2 text-white bg-gray-500 rounded-lg">PRECEDENTE</button>
                    <button x-on:click="nextVideo" x-show="videos[index]['completed'] && index < count - 1"
                        class="px-4 py-3 my-2 text-white bg-gray-500 rounded-lg">SUCCESSIVO</button>
                </div>
                <div class="flex justify-center" x-show="completed == 1">
                    <button class="px-4 py-3 my-2 text-white bg-yellow-600 rounded-lg">VAI AL TEST</button>
                </div>
                <br>
            </div>
        </div>
        {{-- start modal  --}}
        {{-- <template x-if="compliancePopup"> --}}
        @if ($compliancePopup)
            <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                        <div
                            class="relative px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                            <div>
                                <div
                                    class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full">
                                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-5">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
                                        Controllo
                                        Conformità Frequenza Corso</h3>
                                    <div class="mt-2 space-y-2">
                                        <p class="text-sm text-gray-500">Stai vedendo questo "pop-up" ai fini della
                                            "compliance" che gli ordini professionali impongono per l'attestazione della
                                            frequenza a distanza dei corsi in modalità asincrona/P.O.D. (Play On Demand)
                                        </p>
                                        <p class="text-sm text-gray-500">Le interazioni con questa questo "pop up"
                                            verranno
                                            registrati sui nostri sistemi ai fini di controllo.</p>
                                        <p class="text-sm text-gray-500">Se non sei interessato ai "Crediti Formativi
                                            Professionali" puoi utilizzare il link del canale Youtube fornito in calce
                                            alla pagina.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                <button x-on:click="closeCompliacePopup()" type="button"
                                    class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2">Ok
                                    Prosegui </button>
                                <button x-on:click="closeCompliacePopup()" type="button"
                                    class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Cancella</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </template>
        @endif
        {{-- end modal  --}}
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('videos', function() {
                window.localStorage.removeItem('_x_id_attendance')
                window.localStorage.removeItem('_x_codice')
                window.localStorage.removeItem('_x_course_id')
                window.localStorage.removeItem('_x_course_uuid')
                window.localStorage.removeItem('_x_index')
                window.localStorage.removeItem('_x_videos')
                window.localStorage.removeItem('_x_completed')
                window.localStorage.removeItem('_x_dateTimeCompleted')
                window.localStorage.removeItem('_x_count')
                window.localStorage.removeItem('_x_compliancePopup')
                window.setInterval(() => {
                    test = false;
                    if (test) {
                        let istante = new Date()
                        window.localStorage.setItem('_x_compliancePopup', true)
                        @this.openCompliance()
                        console.log(istante)
                    } else {
                        return
                    }
                }, Math.round(Math.random() * (20000 - 5000)) + 5000)
                return {
                    id_attendance: this.$persist({{ $id_attendance }}),
                    codice: this.$persist('{{ $codice }}'),
                    course_id: this.$persist({{ $course_id }}),
                    course_uuid: this.$persist('{{ $course_uuid }}'),
                    index: this.$persist({{ $index }}),
                    videos: this.$persist(<?php echo $videos_json; ?>),
                    completed: this.$persist({{ $completed }}),
                    dateTimeCompleted: this.$persist(<?php echo $dateTimeCompleted; ?>),
                    count: this.$persist({{ count(json_decode($videos_json)) }}),
                    compliancePopup: this.$persist({{ $compliancePopup }}),
                    answered(e) {
                        this.selectedAnswer = e.target.value
                        this.questions[this.index]['givenAnswer'] = this.selectedAnswer
                        if (this.questions[this.index]['givenAnswer'] == this.questions[this.index][
                                'correctAnswer'
                            ]) {
                            this.questions[this.index]['point'] = 1
                        } else {
                            this.questions[this.index]['point'] = 0
                        }
                    },
                    nextVideo() {
                        this.index++
                        if (this.index > this.count - 1) {
                            this.index = this.count - 1
                            this.nextVisible = 0
                        }
                        @this.update(this.id_attendance, this.codice, this.course_id, this.course_uuid, this
                            .index, this.videos, this.completed, this.dateTimeCompleted)
                    },
                    previousVideo() {
                        this.index--
                        if (this.index < 0) {
                            this.index = 0
                        }
                        @this.update(this.id_attendance, this.codice, this.course_id, this.course_uuid, this
                            .index, this.videos, this.completed, this.dateTimeCompleted)
                    },
                    setCompleted(index, prop, value) {
                        if (index == this.count - 1) {
                            this.completed = 1
                        }
                        this.videos[index][prop] = value
                        @this.update(this.id_attendance, this.codice, this.course_id, this.course_uuid, this
                            .index, this.videos, this.completed, this.dateTimeCompleted)
                    },
                    setUncompleted(index, prop, value) {
                        if (index == this.count - 1) {
                            this.completed = 0
                        }
                        this.videos[index][prop] = value
                        @this.update(this.id_attendance, this.codice, this.course_id, this.course_uuid, this
                            .index, this.videos, this.completed, this.dateTimeCompleted)
                    },
                    closeCompliacePopup() {
                        this.compliancePopup = false
                        @this.closeCompliance()
                    },
                    showResults() {
                        this.submitted = true
                        this.dateTimeSubmitted = new Date().toLocaleString()

                        this.totalScore = this.questions.reduce(function(previousValue, currentValue) {
                            return previousValue + currentValue.point
                        }, 0)

                        this.blank = this.questions.filter(function(options) {
                            return options.givenAnswer === ''
                        }).length

                        this.wrongAnswers = this.questions.filter(function(options) {
                            if (options.givenAnswer != '') {
                                return options.givenAnswer != options.correctAnswer
                            }
                        }).length
                    },
                    updateResults() {
                        if (!this.submitted) {
                            this.dateTimeSubmitted = new Date().toLocaleString()

                            this.totalScore = this.questions.reduce(function(previousValue, currentValue) {
                                return previousValue + currentValue.point
                            }, 0)

                            this.blank = this.questions.filter(function(options) {
                                return options.givenAnswer === ''
                            }).length

                            this.wrongAnswers = this.questions.filter(function(options) {
                                if (options.givenAnswer != '') {
                                    return options.givenAnswer != options.correctAnswer
                                }
                            }).length
                        }
                    },
                    resetQuiz() {
                        this.index = 0
                        this.review = true
                    }
                }
            })
        })
    </script>
</div>

<div>
    <div class="flex items-center justify-center w-full h-auto">
        <div class="flex items-center justify-center w-full h-auto my-10">
            <div x-data="videos" class="w-full max-w-2xl">
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
                        <li class="relative pr-8 sm:pr-20">
                            <!-- Completed Step -->
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="h-0.5 w-full bg-violet-600"></div>
                            </div>
                            <a href="#"
                                class="relative flex items-center justify-center w-8 h-8 rounded-full bg-violet-600 hover:bg-violet-900">
                                <svg class="w-5 h-5 text-white" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="sr-only">Step 1</span>
                            </a>
                        </li>
                        <li class="relative pr-8 sm:pr-20">
                            <!-- Completed Step -->
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="h-0.5 w-full bg-violet-600"></div>
                            </div>
                            <a href="#"
                                class="relative flex items-center justify-center w-8 h-8 rounded-full bg-violet-600 hover:bg-violet-900">
                                <svg class="w-5 h-5 text-white" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="sr-only">Step 2</span>
                            </a>
                        </li>
                        <li class="relative pr-8 sm:pr-20">
                            <!-- Current Step -->
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="h-0.5 w-full bg-gray-200"></div>
                            </div>
                            <a href="#"
                                class="relative flex items-center justify-center w-8 h-8 bg-white border-2 rounded-full border-violet-600"
                                aria-current="step">
                                <span class="h-2.5 w-2.5 rounded-full bg-violet-600" aria-hidden="true"></span>
                                <span class="sr-only">Step 3</span>
                            </a>
                        </li>
                        <li class="relative pr-8 sm:pr-20">
                            <!-- Upcoming Step -->
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="h-0.5 w-full bg-gray-200"></div>
                            </div>
                            <a href="#"
                                class="relative flex items-center justify-center w-8 h-8 bg-white border-2 border-gray-300 rounded-full group hover:border-gray-400">
                                <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"
                                    aria-hidden="true"></span>
                                <span class="sr-only">Step 4</span>
                            </a>
                        </li>
                        <li class="relative">
                            <!-- Upcoming Step -->
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="h-0.5 w-full bg-gray-200"></div>
                            </div>
                            <a href="#"
                                class="relative flex items-center justify-center w-8 h-8 bg-white border-2 border-gray-300 rounded-full group hover:border-gray-400">
                                <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"
                                    aria-hidden="true"></span>
                                <span class="sr-only">Step 5</span>
                            </a>
                        </li>
                    </ol>
                </nav>
                <nav aria-label="Progress" class="mt-4">
                    <ol role="list" class="flex items-center">
                        @foreach (json_decode($videos_json) as $video)
                            @if ($loop->first)
                                    <div class="flex flex-col">
                                        <button wire:click="goTo({{ $loop->index }}, {{ $id_attendance }}, {{ $course_id }})" class="p-2 m-2 bg-green-400">PRIMO</button>
                                        <button wire:click="goTo({{ $loop->index }}, {{ $id_attendance }}, {{ $course_id }})" class="p-2 m-2 bg-green-400">COMPLETATO</button>
                                        @if ($loop->index == $index)
                                            <button wire:click="goTo({{ $loop->index }}, {{ $id_attendance }}, {{ $course_id }})" class="p-2 m-2 bg-green-400">SELEZIONATO</button>
                                        @endif
                                    </div>

                                {{-- <a wire:click="goTo({{ $loop->index }}, {{ $id_attendance }}, {{ $course_id }})"
                                        href="#"
                                        class="relative flex items-center justify-center w-8 h-8 bg-white border-2 border-gray-300 rounded-full"> --}}
                            @elseif(!$loop->first && !$loop->last)
                                @if ($video->completed)
                                    <div class="flex flex-col">
                                        <button wire:click="goTo({{ $loop->index }}, {{ $id_attendance }}, {{ $course_id }})" class="p-2 m-2 bg-green-400">MEZZO</button>
                                        <button wire:click="goTo({{ $loop->index }}, {{ $id_attendance }}, {{ $course_id }})" class="p-2 m-2 bg-green-400">COMPLETATO</button>
                                        @if ($loop->index == $index)
                                            <button wire:click="goTo({{ $loop->index }}, {{ $id_attendance }}, {{ $course_id }})" class="p-2 m-2 bg-green-400">SELEZIONATO</button>
                                        @endif
                                    </div>
                                @else
                                    <div class="flex flex-col">
                                        <button class="p-2 m-2 bg-red-400">MEZZO</button>
                                        <button class="p-2 m-2 bg-red-400">NON COMPLETATO</button>
                                        @if ($loop->index == $index)
                                            <button class="p-2 m-2 bg-red-400">SELEZIONATO</button>
                                        @endif
                                    </div>
                                @endif
                            @else
                                @if ($video->completed)
                                    <div class="flex flex-col">
                                        <button wire:click="goTo({{ $loop->index }}, {{ $id_attendance }}, {{ $course_id }})" class="p-2 m-2 bg-green-400">ULTIMO</button>
                                        <button wire:click="goTo({{ $loop->index }}, {{ $id_attendance }}, {{ $course_id }})" class="p-2 m-2 bg-green-400">NON COMPLETATO</button>
                                        @if ($loop->index == $index)
                                            <button wire:click="goTo({{ $loop->index }}, {{ $id_attendance }}, {{ $course_id }})" class="p-2 m-2 bg-green-400">SELEZIONATO</button>
                                        @endif
                                    </div>
                                @else
                                    <div class="flex flex-col">
                                        <button class="p-2 m-2 bg-red-400">ULTIMO</button>
                                        <button class="p-2 m-2 bg-red-400">NON COMPLETATO</button>
                                        @if ($loop->index == $index)
                                            <button class="p-2 m-2 bg-red-400">SELEZIONATO</button>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </ol>
                </nav>
                {{ $index }}
                @foreach (json_decode($videos_json) as $video)
                    <div>
                        <video class="w-full h-auto max-w-full" controls
                            @if ($loop->index == $index) visible @else hidden @endif>
                            <source src="{{ $video->link }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                @endforeach
                <div class="flex justify-between">
                    <button x-on:click="setCompleted({{ $index }}, 'completed', 1)" class="px-4 py-3 my-2 text-white bg-green-500 rounded-lg">SET COMPLETATO</button>
                    <button x-on:click="setUncompleted({{ $index }}, 'completed', 0)" class="px-4 py-3 my-2 text-white bg-red-500 rounded-lg">SET ZERO</button>
                </div>
                <div class="flex justify-between">
                    <button x-on:click="previousVideo" class="px-4 py-3 my-2 text-white bg-gray-500 rounded-lg">PRECEDENTE</button>
                    <button x-on:click="nextVideo" class="px-4 py-3 my-2 text-white bg-gray-500 rounded-lg">SUCCESSIVO</button>
                </div>
                <br>
            </div>
        </div>
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
                return {
                    id_test: this.$persist({{ $id_attendance }}),
                    codice: this.$persist('{{ $codice }}'),
                    course_id: this.$persist({{ $course_id }}),
                    course_uuid: this.$persist('{{ $course_uuid }}'),
                    index: this.$persist({{ $index }}),
                    videos: this.$persist(<?php echo $videos_json; ?>),
                    completed: this.$persist({{ $completed }}),
                    dateTimeCompleted: this.$persist(<?php echo $dateTimeCompleted; ?>),
                    count: this.$persist({{ count(json_decode($videos_json)) }}),
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
                        }
                        @this.update(this.id_test, this.codice, this.course_id, this.course_uuid, this.index, this.videos, this.completed, this.dateTimeCompleted)
                    },
                    previousVideo() {
                        this.index--
                        if (this.index < 0) {
                            this.index = 0
                        }
                        @this.update(this.id_test, this.codice, this.course_id, this.course_uuid, this.index, this.videos, this.completed, this.dateTimeCompleted)
                    },
                    setCompleted(index, prop, value) {
                        this.videos[index][prop] = value
                        @this.update(this.id_test, this.codice, this.course_id, this.course_uuid, this.index, this.videos, this.completed, this.dateTimeCompleted)
                    },
                    setUncompleted(index, prop, value) {
                        this.videos[index][prop] = value
                        @this.update(this.id_test, this.codice, this.course_id, this.course_uuid, this.index, this.videos, this.completed, this.dateTimeCompleted)
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

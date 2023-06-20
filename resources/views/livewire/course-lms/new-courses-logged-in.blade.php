<div>
    <div x-data="videos" x-on:visibilitychange.window="visibilityChange()"
        class="flex items-center justify-center w-full h-auto">
        <div class="flex items-center justify-center w-full h-auto my-10">
            <div class="w-full max-w-2xl">
                <h1 class="text-2xl font-bold text-center text-blue-800">
                    Frequenza Corso n. {{ $codice }}
                </h1>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-center text-purple-600">
                    {{ $title }}</h2>
                @foreach (json_decode($videos_json) as $key => $video)
                    @if ($key == $index)
                        <h3 class="mt-2 text-2xl font-extrabold tracking-tight text-center text-gray-500">
                            {{ Str::upper($video->titolo) }}</h3>
                    @endif
                @endforeach
                <div class="w-full p-2 mt-4 bg-green-200 rounded-lg">
                    <div class="flex flex-row items-center text-gray-700">
                        <svg class="w-6 h-6 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-gray-700">I seguenti <span class="font-bold">simboli</span> indicano lo
                            stato di avanzamento del corso in base ai moduli/video.<br />In basso a sinistra (barra di
                            progresso in alto su
                            schermi piccoli) l'indicazione della <span class="font-bold">percentuale completata</span>
                            del singolo video.</p>
                    </div>
                </div>
                {{-- nav videos blade --}}
                <nav aria-label="Progress" class="mt-4">
                    <ol role="list" class="flex items-center">
                        @foreach (json_decode($videos_json) as $key => $video)
                            <li class="relative @if ($key != count(json_decode($videos_json)) - 1) pr-8 sm:pr-20 @endif">
                                <!-- Upcoming Step -->
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div
                                        class="h-0.5 w-full @if ($video->completato == 1) bg-violet-600 @else bg-gray-200 @endif">
                                    </div>
                                </div>
                                <div>
                                    @if ($video->completato == 1 && $key == $index)
                                        <a href="#" type="button" x-on:notify.window="isClickedGoTo = true"
                                            wire:click="goTo({{ $key }}, {{ $id_attendance }}, {{ $course_id }})"
                                            class="relative flex items-center justify-center w-8 h-8 bg-white border-2 rounded-full border-violet-600"
                                            aria-current="step">
                                            <span class="h-2.5 w-2.5 rounded-full bg-violet-600"
                                                aria-hidden="true"></span>
                                            <span class="sr-only">{{ $key + 1 }}</span>
                                        </a>
                                    @elseif($video->completato == 1 && $key != $index)
                                        <a href="#" type="button" x-on:notify.window="isClickedGoTo = true"
                                            wire:click="goTo({{ $key }}, {{ $id_attendance }}, {{ $course_id }})"
                                            class="relative flex items-center justify-center w-8 h-8 rounded-full bg-violet-600 hover:bg-violet-900">
                                            @if ($key != $index)
                                                <svg class="w-5 h-5 text-white" viewBox="0 0 20 20" fill="currentColor"
                                                    aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                    @endif
                                    <span class="sr-only">{{ $key + 1 }}</span>
                                    </a>
                                </div>

                                @if ($video->completato != 1)
                                    <a href="#"
                                        class="relative flex items-center justify-center w-8 h-8 bg-white border-2 rounded-full group hover:border-gray-400 @if ($key == $index) border-violet-600 @else border-gray-300 @endif"
                                        aria-current="step">
                                        <span
                                            class="h-2.5 w-2.5 rounded-full @if ($key == $index) bg-violet-600 @else bg-transparent group-hover:bg-gray-300 @endif"
                                            aria-hidden="true"></span>
                                        <span class="sr-only">{{ $key + 1 }}</span>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
                {{-- end nav videos blade --}}
                {{-- videos blade --}}
                <div class="mt-6">
                    @foreach (json_decode($videos_json) as $key => $video)
                        <div class="w-full h-auto max-w-full video-container" x-ref="videoContainer"
                            x-on:fullscreenchange="checkFullScreenMode()">
                            <div>
                                @if ($key == $index)
                                    <video x-ref="video" preload="metadata" x-init="initializeVideo()"
                                        x-on:click="togglePlay($event)" x-on:pause="togglePlay($event)"
                                        x-on:playing="togglePlay($event)" x-on:seeked="skipAhead($event)"
                                        x-on:timeupdate="updateTimeElapsed($event), updatePercentElapsed()"
                                        class="video" x-ref="video" controls controlsList="nodownload"
                                        poster="{{ asset('poster/poster_logo_mga.png') }}">
                                        <source src="{{ $video->link }}" type="video/mp4">
                                    </video>
                                @endif
                            </div>
                            <div>
                                @if ($key == $index)
                                    {{-- progress top --}}
                                    <div class="fixed inset-x-0 top-0 z-10 sm:hidden">
                                        <div class="h-1 bg-violet-500" :style="`width: ${percent}%`"></div>
                                    </div>
                                    {{-- end progress top --}}
                                    {{-- progress circle --}}
                                    <div
                                        class="fixed z-50 inline-flex items-center justify-center invisible bg-white rounded-full bottom-5 left-10 sm:visible">
                                        <svg class="w-20 h-20">
                                            <circle class="text-gray-300" stroke-width="5" stroke="currentColor"
                                                fill="transparent" r="30" cx="40" cy="40" />
                                            <circle x-show="!Number.isNaN(percent)" class="text-violet-600"
                                                stroke-width="5" :stroke-dasharray="circumference"
                                                :stroke-dashoffset="circumference - percent / 100 * circumference"
                                                stroke-linecap="round" stroke="currentColor" fill="transparent"
                                                r="30" cx="40" cy="40" />
                                        </svg>
                                        <span x-show="Number.isNaN(percent)" class="absolute text-xl text-violet-700"
                                            x-text="'0%'"></span>
                                        <span x-show="!Number.isNaN(percent)" class="absolute text-xl text-violet-700"
                                            x-effect="$el.textContent = Math.trunc((percentElapsed).toFixed(2)*100)+'%'"></span>
                                    </div>
                                    {{-- end progress circle --}}
                                    {{-- <div x-effect="$el.textContent=circumference"></div>
                                    <div x-effect="$el.textContent=circumference - percent / 100 * circumference">
                                    </div>
                                    <div x-show="!Number.isNaN(percent)" x-text="percent"></div>
                                    <div>tempoCompletato[{{ $key }}]: {{ $video->tempoCompletato }}</div>
                                    <div>durataVideo[{{ $key }}]: {{ $video->durataVideo }}</div>
                                    <div>videoCompletato[{{ $index }}]: {{ $video->completato }}</div> --}}
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- end video  --}}

                {{-- $count: {{ count(json_decode($videos_json)) }}
                <br>
                $index: {{ $index }} --}}
                <div class="flex justify-between">
                    <button type="button" wire:click="setCompleted({{ $index }}, {{ $id_attendance }})"
                        class="px-4 py-3 my-2 text-white bg-green-500 rounded-lg">SET COMPLETATO</button>
                    <button type="button" wire:click="setUncompleted({{ $index }}, {{ $id_attendance }})"
                        class="px-4 py-3 my-2 text-white bg-red-500 rounded-lg">SET NON COMPLETATO</button>
                </div>
                <div class="flex justify-between">
                    <button type="button"
                        wire:click="goToPrevious({{ $index }}, {{ $id_attendance }}, {{ $course_id }})"
                        x-on:notify.window="isClickedGoTo = true" x-on:click="isPlaying = false"
                        class="px-4 py-3 my-2 text-white bg-gray-500 rounded-lg">PRECEDENTE</button>
                    {{-- next button blade  --}}
                    <div>
                        @if (json_decode($videos_json)[$index]->completato && $index < count(json_decode($videos_json)) - 1)
                            <button type="button"
                                wire:click="goToNext({{ $index }}, {{ $id_attendance }}, {{ $course_id }}), updateTempVariable"
                                x-on:notify.window="isClickedGoTo = true" x-on:click="isPlaying = false"
                                class="px-4 py-3 my-2 text-white bg-gray-500 rounded-lg @if (json_decode($videos_json)[$index]->completato && !json_decode($videos_json)[$index + 1]->completato) animate-pulse @endif">SUCCESSIVO</button>
                        @endif
                    </div>

                    {{-- next button blade  --}}
                </div>
                <div class="flex justify-between">
                    <button type="button" x-on:click="compliancePopup=true; openCompliancePopup();"
                        class="px-4 py-3 my-2 text-white bg-gray-500 rounded-lg">COMPLIANCE POPUP</button>

                    index: <div x-text="index"></div>

                    <div x-text="JSON.stringify(checkPoints)"></div>
                    <button type="button" x-on:click="setCurTime(previousCheckPoint)"
                        class="px-4 py-3 my-2 text-white bg-gray-500 rounded-lg">TORNA INDIETRO</button>
                </div>
                <div class="flex justify-between">
                    <button type="button" x-on:click="$refs.video.play()"
                        class="px-4 py-3 my-2 text-white bg-gray-500 rounded-lg">PLAY</button>
                    <button type="button" x-on:click="$refs.video.pause()"
                        class="px-4 py-3 my-2 text-white bg-gray-500 rounded-lg">PAUSE</button>
                    <button type="button" x-on:click="toggleFullScreen()"
                        class="px-4 py-3 my-2 text-white bg-gray-500 rounded-lg">FULL SCREEN</button>
                </div>
                @if ($completed)
                    <div class="flex justify-center">
                        <button class="px-4 py-3 my-2 text-white bg-yellow-600 rounded-lg">VAI AL TEST FINALE</button>
                    </div>
                @endif
                <br />
                {{-- <div>completedTimeTemp[{{ $index }}]: <span x-ref="elapsed" class="font-bold text-red-600"
                        x-effect="$el.textContent = completedTimeTemp"></span></div>
                index: {{ $index }}<br />
                is playing: <span class="font-bold text-red-600" x-effect="$el.textContent = isPlaying"></span><br />
                time elapsed: <span x-ref="elapsed" class="font-bold text-red-600"
                    x-effect="$el.textContent = timeElapsed"></span><br />
                time completed byref: <span class="font-bold text-red-600"
                    x-effect="$el.textContent = completedTime"></span><br />
                percent elapsed: <span class="font-bold text-red-600"
                    x-effect="$el.textContent = Math.trunc((percentElapsed).toFixed(2)*100)+'%'"></span><br />
                current time: <span class="font-bold text-red-600"
                    x-effect="$el.textContent = currentTime"></span><br />
                seek: <span class="font-bold text-red-600" x-effect="$el.textContent = seek"></span><br />
                progress bar: <span class="font-bold text-red-600"
                    x-effect="$el.textContent = progressBar"></span><br>
                videoDuration[{{ $index }}]: <span
                    class="font-bold text-red-600">{{ json_decode($videos_json)[$index]->durataVideo }}</span><br />
                tempoCompletato[{{ $index }}]: <span
                    class="font-bold text-red-600">{{ json_decode($videos_json)[$index]->tempoCompletato }}</span><br>
                <div x-text="index"></div>
                <div x-text="id_attendance"></div>
                <div x-text="currentTime"></div> --}}
                {{-- <div wire:model="logs_json">
                    {{ $logs_json }}
                </div> --}}
            </div>
        </div>

        {{-- start modal  --}}
        <div x-cloak x-show="compliancePopup" x-init="">
            {{-- @if ($compliancePopup) --}}
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
                                        <p class="text-sm text-gray-500">Clicca sul tasto "Prosegui" <span
                                                class="font-bold">entro 60 secondi
                                            </span> per non perdere i progressi fatti in questo modulo.
                                        </p>
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
                            <div class="mt-5 sm:mt-6 ">
                                <button x-on:click="closeCompliancePopup; $dispatch('accept')"
                                    x-on:accept.window="openCompliancePopup" type="button"
                                    class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2">Prosegui</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- @endif --}}
        </div>
        {{-- end modal  --}}

        {{-- wire loading --}}
        <div wire:loading wire:target="goTo, goToNext, goToPrevious, setCompleted, setUncompleted"
            class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">

                    <div
                        class="relative px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                        <div>
                            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full">
                                <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-5">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Attendere
                                    prego</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end wire loading --}}

        {{-- modal skipAhead --}}
        <div x-cloak x-show="alertSkipAhead" class="relative z-10" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                    <div
                        class="relative px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                        <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                            <button x-on:click="alertSkipAhead = false" type="button"
                                class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <span class="sr-only">Close</span>
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="sm:flex sm:items-start">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
                                    Attenzione</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Non si può andare avanti e/o oltre la porzione di
                                        video che hai visualizzato.</p>
                                    <p class="text-sm text-gray-500">Questa operazione verrà registrata sui nostri
                                        sistemi.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                            <button x-on:click="alertSkipAhead = false, appendLogs('ha cercato di andare avanti')"
                                type="button"
                                class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white bg-red-600 rounded-md shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Chiudi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- emd modal --}}

        {{-- modal shkipBehind --}}
        <div x-cloak x-show="alertSkipBehind" class="relative z-10" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                    <div
                        class="relative px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
                                    Sei sicuro di voler andare indietro?</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Andando indietro perderai i progressi fatti. Solo quando avrai terminato
                                        l'intero video/modulo potrai andare avanti e/o indietro liberamente.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                            <button x-on:click="alertSkipBehind = false" type="button"
                                class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white bg-red-600 rounded-md shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Procedo
                                Comunque</button>
                            <button x-on:click="alertSkipBehind = false, setCurTime(completedTimeTemp)" type="button"
                                class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancella
                                Azione</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end modal skipBehind --}}
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
                window.localStorage.removeItem('_x_fullScreen')
                window.localStorage.removeItem('_x_timePopup')
                window.localStorage.removeItem('_x_checkPoints')
                return {
                    videoWorks: !!document.createElement('video').canPlayType,
                    id_attendance: @entangle('id_attendance'),
                    codice: @entangle('codice'),
                    course_id: @entangle('course_id'),
                    course_uuid: @entangle('course_uuid'),
                    index: @entangle('index'),
                    videos: @entangle('videos_json'),
                    dateTimeCompleted: @entangle('dateTimeCompleted'),
                    count: this.$persist({{ count(json_decode($videos_json)) }}),
                    compliancePopup: this.$persist(false),
                    timePopup: this.$persist(60),
                    timeout: null,
                    checkPoints: this.$persist([]),
                    currentCheckPoint: this.$persist(0),
                    currentCheckPointKey: this.$persist(0),
                    previousCheckPoint: this.$persist(0),
                    isClickedGoTo: false,
                    isPlaying: false,
                    videoDuration: 0,
                    completedTime: 0,
                    videoDurationTemp: 0,
                    completedTimeTemp: this.$persist(0),
                    timeElapsed: 0,
                    currentTime: this.$persist(0),
                    percentElapsed: 0,
                    seek: 0,
                    progressBar: 0,
                    fullScreen: this.$persist('false'),
                    completed: @entangle('completed'),
                    circumference: 30 * 2 * Math.PI,
                    percent: 0,
                    alertSkipAhead: false,
                    alertSkipBehind: false,
                    visibilityChange() {
                        if ((document.visibilityState !== "visible") && (this.completed == 0)) {
                            this.$refs.video.pause()
                            this.isPlaying = false
                        } else {
                            //this.$refs.video.play()
                            //this.isPlaying = true
                        }
                    },
                    setUncompleted(index, prop, value) {
                        if (index == this.count - 1) {
                            this.completed = 0
                        }
                        this.videos[index][prop] = value
                        @this.update(this.id_attendance, this.codice, this.course_id, this
                            .course_uuid, this
                            .index, this.videos, this.completed, this.dateTimeCompleted)
                    },
                    setTrue() {
                        this.checkPoints[this.currentCheckPointKey]['checkPassed'] = true
                        console.log(this.checkPoints[this.currentCheckPointKey]['checkPassed'])
                        this.initializeThisCheckPoints()
                        //JSON.parse(this.videos)[this.index]['checkPoints'][this.currentCheckPointKey]['checkPassed'] = true
                        //console.log(JSON.parse(this.videos)[this.index]['checkPoints'][this.currentCheckPointKey])
                        //this.initializeCheckPoints()
                    },
                    closeCompliancePopup() {
                        this.checkPoints[this.currentCheckPointKey]['checkPassed'] = true
                        JSON.parse(this.videos)[this.index]['checkPoints'][this.currentCheckPointKey][
                            'checkPassed'
                        ] = true
                        @this.closeCompliance(this.currentCheckPointKey, this.id_attendance)
                        @this.appendLogs(this.index, this.id_attendance, this.currentTime,
                            `ckeckpoint no. ${this.currentCheckPointKey} superato`)
                        this.initializeThisCheckPoints()
                        this.compliancePopup = false
                        this.$refs.video.play()
                    },
                    async getVideoDuration() {
                        let response = await this.$refs.video.duration
                        return await response
                    },
                    initializeVideo() {
                        if ((JSON.parse(this.videos)[this.index]['completato'])) {
                            return
                        }
                        (JSON.parse(this.videos)).forEach((detail, index) => {
                            if (this.index == index) {
                                this.videoDurationTemp = detail.durataVideo
                                this.completedTimeTemp = detail.tempoCompletato
                                this.setCurTime(this.completedTimeTemp)
                                this.initializeCheckPoints()
                            }
                        })
                    },
                    initializeCheckPoints() {
                        this.checkPoints = JSON.parse(this.videos)[this.index]['checkPoints'];
                        Object.keys(this.checkPoints).forEach(key => {
                            if (key > 0 && this.checkPoints[key - 1]['checkPassed'] && !this
                                .checkPoints[key]['checkPassed']) {
                                console.log(key - 1, 'previous checkpoint', this.checkPoints[key -
                                    1]['checkTime']);
                                this.previousCheckPoint = this.checkPoints[key - 1]['checkTime']
                                console.log(key, 'current checkpoint', this.checkPoints[key][
                                    'checkTime'
                                ]);
                                this.currentCheckPoint = this.checkPoints[key]['checkTime']
                                this.currentCheckPointKey = key
                            }
                        })
                    },
                    initializeThisCheckPoints() {
                        Object.keys(this.checkPoints).forEach(key => {
                            if (key > 0 && this.checkPoints[key - 1]['checkPassed'] && !this
                                .checkPoints[key]['checkPassed']) {
                                console.log(key - 1, 'previous checkpoint', this.checkPoints[key -
                                    1]['checkTime']);
                                this.previousCheckPoint = this.checkPoints[key - 1]['checkTime']
                                console.log(key, 'current checkpoint', this.checkPoints[key][
                                    'checkTime'
                                ]);
                                this.currentCheckPoint = this.checkPoints[key]['checkTime']
                                this.currentCheckPointKey = key
                            }
                        })
                    },
                    formatTime(timeInSeconds) {},
                    togglePlay(event) {
                        if (event.type === "pause") {
                            if (this.currentTime > this.completedTimeTemp) {
                                this.completedTimeTemp = this.currentTime
                            }
                            console.log("paused");
                            this.isPlaying = false
                        } else if (event.type === "playing") {
                            console.log("playing");
                            this.isPlaying = true
                        }
                    },
                    checkFullScreenMode() {
                        if (document.fullscreenElement) {
                            this.fullScreen = true
                        } else if (document.webkitFullscreenElement) {
                            this.fullScreen = true
                        } else if (this.$refs.videoContainer.webkitRequestFullscreen) {
                            // Need this to support Safari
                            this.fullScreen = false
                        } else {
                            this.fullScreen = false
                        }
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
                    exitFullScreen() {
                        if (document.fullscreenElement) {
                            document.exitFullscreen()
                            this.fullScreen = false
                        } else if (document.webkitFullscreenElement) {
                            // Need this to support Safari
                            document.webkitExitFullscreen()
                            this.fullScreen = false
                        }
                    },
                    skipAhead(event) {
                        this.exitFullScreen()
                        this.$refs.video.pause()
                        if (event.type === 'seeked') {
                            if (this.currentTime > this.completedTimeTemp) {
                                this.$refs.video.pause()
                                //alert('OPERAZIONE NON CONSENTITA');
                                this.setCurTime(this.completedTimeTemp)
                                console.log(this.completedTimeTemp)
                                this.alertSkipAhead = true
                            } else if (this.currentTime < this.completedTimeTemp) {
                                this.$refs.video.pause()
                                //alert('OPERAIZONE NON CONSENTITA');
                                this.alertSkipBehind = true
                            }
                        }
                    },
                    setCurTime(arg) {
                        this.currentTime = arg
                        this.completedTimeTemp = this.previousCheckPoint
                        this.$refs.video.currentTime = this.currentTime
                    },
                    updateTempVariable() {},
                    updateTimeElapsed() {
                        if ((JSON.parse(this.videos)[this.index]['completato'])) {
                            return
                        }
                        const time = this.formatTime(Math.round(this.$refs.video.currentTime))
                        this.currentTime = this.$refs.video.currentTime
                        if (!this.isClickedGoTo) {
                            @this.updateCompletedTime(this.index, this.id_attendance, this
                                .currentTime)
                        }
                        if (this.$refs.video.currentTime > this.completedTime) {
                            this.completedTime = this.$refs.video.currentTime
                        }

                        if (this.$refs.video.currentTime > this.currentCheckPoint) {
                            this.$refs.video.pause()
                            //this.timePopup= 60
                            //@this.openCompliance()
                            this.openCompliancePopup()
                            console.log(this.compliancePopUp)
                        }
                        //this.$refs.timeElapsed.innerText = `${time.minutes}:${time.seconds}`
                        //this.$refs.timeElapsed.setAttribute('datetime',`${time.minutes}m ${time.seconds}s`)
                        //this.timeElapsed = `${time.minutes}:${time.seconds}`

                        this.isClickedGoTo = false
                        // return `${time.minutes}:${time.seconds}`
                    },
                    sleep(ms) {
                        return new Promise(resolve => setTimeout(resolve, ms));
                    },
                    async openCompliancePopup() {
                        this.exitFullScreen()
                        this.$refs.video.pause()
                        this.timePopup = 60
                        this.compliancePopup = true
                        await this.sleep(this.timePopup * 1000)
                        if (!this.compliancePopup) {
                            return;
                        }
                        this.compliancePopup = false;
                        this.timePopup = 0;
                        this.completedTimeTemp = this.previousCheckPoint;
                        this.setCurTime(this.previousCheckPoint)
                    },
                    formatTime(timeInSeconds) {
                        const result = new Date(timeInSeconds * 1000).toISOString().substr(11, 8)
                        return {
                            minutes: result.substr(3, 2),
                            seconds: result.substr(6, 2)
                        }
                    },
                    updatePercentElapsed() {
                        const videoDuration = Math.round(this.$refs.video.duration)
                        const time = Math.round(this.$refs.video.currentTime)
                        this.percentElapsed = time / videoDuration
                        this.percent = Math.trunc((this.percentElapsed).toFixed(2) * 100)
                        if (this.percentElapsed >= 1 && (!JSON.parse(this.videos)[this.index][
                                'completato'
                            ])) {
                            @this.setCompleted(this.index, this.id_attendance)
                            @this.appendLogs(this.index, this.id_attendance, this.currentTime,
                                'modulo completato')
                        }
                        return time / videoDuration
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
                    appendLogs(annotation) {
                        @this.appendLogs(this.index, this.id_attendance, this.currentTime, annotation)
                    }
                }
            })
        })
    </script>
</div>

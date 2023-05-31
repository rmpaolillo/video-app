<x-app-layout :title="$course_title" :course_title="$course_title" :course_id="$course_id" :course_uuid="$course_uuid">
    {{-- @include('layouts.navigation')
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}
    <div class="py-12 bg-violet-50">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @livewire('course-lms.new-courses-logged-in', [
                        'title' => $course_title,
                        'course_title' => $course_title,
                        'course_id' => $course_id,
                        'course_uuid' => $course_uuid,
                        'course_link_video' => $course_link_video,
                        'course_link_youtube' => $course_link_youtube,
                        'course_link_dispense' => $course_link_dispense,
                        'codice' => $codice
                    ])

                    {{-- <livewire:course-lms.new-courses-logged-in > --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

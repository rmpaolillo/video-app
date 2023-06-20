<?php

use App\Models\Course;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('index');
});

Route::get('corso/loggedin/{uuid}/{num_offerta}', function ($uuid, $num_offerta) {
    // http://video-app.test/corso/loggedin/e235b17a-c8ba-4339-8d37-df0904523007/123456789-1
    // if (!session('cod_cliente')) {
    //     return redirect('customer-login');
    // }
    $data = Course::where('unique_id', 'like', $uuid.'%')->firstOrFail();
    $title = $data['title'];
    $course_title = $data['title'];
    $course_id = $data['id'];
    $course_uuid = $data['unique_id'];
    $course_link_video = $data['link_video'];
    $course_link_youtube = $data['link_youtube'];
    $course_link_dispense = $data['link_dispense'];
    $codice = $num_offerta;
    $ipAddress = Request::getClientIp(true);

    return view('course-lms.new-courses-logged-in', compact('title', 'course_title', 'course_id', 'course_uuid', 'course_link_video', 'course_link_youtube', 'course_link_dispense', 'codice', 'ipAddress'));
});

// Route::get('/example', function () {
//     return view('welcome');
// });

// Route::get('/row-example', function () {
//     return view('row-example-index');
// });
Route::get('/session-flush', function () {
    Session::flush(); // removes all session data
});

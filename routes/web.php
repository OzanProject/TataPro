<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('authenticate');
    Route::post('/logout', 'logout')->name('logout');
});
// Protected Routes
Route::middleware(['auth'])->group(function () {

    // Unified Dashboard Route (Accessible by all authenticated users)
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/guide', [\App\Http\Controllers\DashboardController::class, 'guide'])->name('guide');

    // Redirect / to /dashboard
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Admin Only Routes
    Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function () {
        Route::resource('users', \App\Http\Controllers\UserController::class);
        Route::resource('roles', \App\Http\Controllers\RoleController::class);
    });

    // Administrasi Surat
    // Administrasi Surat
    Route::group(['prefix' => 'correspondence', 'middleware' => ['permission:mail-list']], function () {
        Route::resource('incoming', \App\Http\Controllers\IncomingMailController::class);
        Route::get('outgoing/{outgoing}/preview', [\App\Http\Controllers\OutgoingMailController::class, 'preview'])->name('outgoing.preview');
        Route::resource('outgoing', \App\Http\Controllers\OutgoingMailController::class);

        // Disposition Routes
        Route::get('disposition', [\App\Http\Controllers\DispositionController::class, 'index'])->name('disposition.index');
        Route::get('incoming/{incoming}/disposition/create', [\App\Http\Controllers\DispositionController::class, 'create'])->name('disposition.create');
        Route::post('incoming/{incoming}/disposition', [\App\Http\Controllers\DispositionController::class, 'store'])->name('disposition.store');
        Route::put('disposition/{disposition}/update-status', [\App\Http\Controllers\DispositionController::class, 'updateStatus'])->name('disposition.update_status');
        Route::delete('disposition/{disposition}', [\App\Http\Controllers\DispositionController::class, 'destroy'])->name('disposition.destroy');
        Route::get('disposition/{incoming}/print', [\App\Http\Controllers\DispositionController::class, 'print'])->name('disposition.print');

        // Agenda Routes
        Route::get('agenda', [\App\Http\Controllers\AgendaController::class, 'index'])->name('agenda.index');
        Route::get('agenda/print', [\App\Http\Controllers\AgendaController::class, 'print'])->name('agenda.print');

        // Document Templates
        Route::get('templates/sample', [\App\Http\Controllers\DocumentTemplateController::class, 'sample'])->name('templates.sample');
        Route::resource('templates', \App\Http\Controllers\DocumentTemplateController::class);

        // Document Generator
        Route::get('generator/student/{student}/select', [\App\Http\Controllers\DocumentGeneratorController::class, 'selectTemplateForStudent'])->name('generator.student.select');
        Route::get('generator/template/{template}/student/{student}', [\App\Http\Controllers\DocumentGeneratorController::class, 'createForStudent'])->name('generator.createForStudent');

        // Teacher Generator
        Route::get('generator/teacher/{teacher}/select', [\App\Http\Controllers\DocumentGeneratorController::class, 'selectTemplateForTeacher'])->name('generator.teacher.select');
        Route::get('generator/template/{template}/teacher/{teacher}', [\App\Http\Controllers\DocumentGeneratorController::class, 'createForTeacher'])->name('generator.createForTeacher');

        Route::get('generator', [\App\Http\Controllers\DocumentGeneratorController::class, 'index'])->name('generator.index');
        Route::get('generator/{template}/create', [\App\Http\Controllers\DocumentGeneratorController::class, 'create'])->name('generator.create');
        Route::post('generator/{template}', [\App\Http\Controllers\DocumentGeneratorController::class, 'store'])->name('generator.store');

        // Archive Search
        Route::get('archive', [\App\Http\Controllers\ArchiveController::class, 'index'])->name('archive.index');

        // Master Data Routes
        Route::resource('mail-categories', \App\Http\Controllers\MailCategoryController::class)->except(['create', 'edit', 'show']);

        // Student Routes
        Route::get('students/export', [\App\Http\Controllers\StudentController::class, 'export'])->name('students.export');
        Route::post('students/import', [\App\Http\Controllers\StudentController::class, 'import'])->name('students.import');
        Route::post('students/actions/bulk-delete', [\App\Http\Controllers\StudentController::class, 'bulkDestroy'])->name('students.bulk_destroy');
        Route::match(['get', 'post'], 'students/actions/bulk-print', [\App\Http\Controllers\StudentController::class, 'bulkPrint'])->name('students.bulk_print');
        Route::get('students/template', [\App\Http\Controllers\StudentController::class, 'downloadTemplate'])->name('students.template');
        Route::get('students/{id}/buku-induk', [\App\Http\Controllers\StudentController::class, 'bukuInduk'])->name('students.buku_induk');
        Route::resource('students', \App\Http\Controllers\StudentController::class);
        // Settings Route
        Route::get('settings/school', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.school');
        Route::put('settings/school', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.school.update');

        // Teacher Route
        Route::get('teachers/template', [\App\Http\Controllers\TeacherController::class, 'downloadTemplate'])->name('teachers.template');
        Route::get('teachers/export', [\App\Http\Controllers\TeacherController::class, 'export'])->name('teachers.export');
        Route::post('teachers/import', [\App\Http\Controllers\TeacherController::class, 'import'])->name('teachers.import');
        Route::resource('teachers', \App\Http\Controllers\TeacherController::class);
    });

});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\DPLController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProgramKampusController;
use App\Http\Controllers\ProgramTransactionController;
use App\Http\Controllers\StudiController;
use App\Http\Controllers\WilayahController;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\roleMiddleware;
use App\Models\ProgramTransaction;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

Route::get('/', function () {
    return view('admin.student.kampus_merdeka');
});

Route::get('/dashboard_operator', function () {
    return view('admin.operator.dashboard_operator');
});

Route::get('/get-provinsi', [WilayahController::class, 'getProvinsi'])->name('getProvinsi');
Route::get('/get-kabupaten/{idProvinsi}', [WilayahController::class, 'getKabupaten'])->name('getKabupaten');
Route::get('/get-kecamatan/{idKabupaten}', [WilayahController::class, 'getKecamatan'])->name('getKecamatan');
Route::get('/get-kelurahan/{idKelurahan}', [WilayahController::class, 'getKelurahan'])->name('getKelurahan');


Route::middleware([AuthenticateMiddleware::class])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::prefix('dashboard/student')->group(function () {
            Route::get('/', [MahasiswaController::class, 'dashboard'])->name('student.dashboard');

            Route::get('/browse_program', function () {
                return view('admin.student.browse_program');
            });
            Route::get('/program_history', function () {
                return view('admin.student.program_history');
            }) ->name('student.program_history');
            Route::get('/weekly_logbook', [MahasiswaController::class, 'weeklyBook'])->name('student.weekly_logbook');
            Route::get('/daily_logbook/{id}', [MahasiswaController::class, 'dailyBook'])->name('student.daily_logbook');
            Route::get('/daily_form/{id}', [MahasiswaController::class, 'dailyLogForm'])->name('student.daily_logbookForm');
            Route::post('/daily_form/{id}', [MahasiswaController::class, 'dailyLog'])->name('student.daily_logbookForm.edit');
            Route::post('/weekly_form/{id}', [MahasiswaController::class, 'weeklyLog'])->name('student.weekly_logbookForm.edit');

            Route::get('/weekly_form', [
                function () {
                    return view('admin.student.weekly_logbook_form');
                }
            ]);
        });
    });

    Route::middleware(['role:guru'])->group(function () {
        Route::prefix('dashboard/pamong')->group(function () {
            Route::get('/', [GuruController::class, 'dashboard'])->name('guru.dashboard');
            Route::get('/programs_pamong', function () {
                return view('admin.pamong.programs_pamong');
            });
            Route::get('/program_details_pamong/{lowongan_id}/{lokasi_id}', [GuruController::class, 'programDetail'])->name('guru.program.detail');
            Route::get('/daily_logbook_pamong/${id}', [GuruController::class, 'dailyBook'])->name('guru.daily.log');
            Route::get('/daily_review_pamong/{id}', [GuruController::class, 'dailyReview'])->name('guru.daily.review');
            Route::get('/get-peserta/{id}', [GuruController::class, 'getPesertaDetail'])->name('guru.getPeserta');
            Route::post('/daily_review_pamong/{id}/{status}', [GuruController::class, 'review'])->name('guru.daily.submit');
        });
    });

    Route::middleware(['role:dosen'])->group(function () {
        Route::prefix('dashboard/dpl')->group(function () {
            Route::get('/', [DosenController::class, 'dashboard'])->name('dosen.dashboard');
            Route::get('/programs_dpl', function () {
                return view('admin.dpl.programs_dpl');
            });
            Route::get('/program_details_dpl/{lowongan_id}/{lokasi_id}', [DosenController::class, 'programDetail'])->name('dosen.program.detail');
            Route::get('/weekly_review_dpl/{id}', [DosenController::class, 'dailyBook'])->name('dosen.weekly_review');
            Route::get('/get-peserta/{id}', [DosenController::class, 'getPesertaDetail'])->name('dosen.getPeserta');
            Route::post('/weekly_review_dpl/{id}', [DosenController::class, 'weeklyBook'])->name('dosen.weekly_review.submit');
        });
    });


    Route::middleware(['role:admin'])->group(function () {
        Route::prefix('dashboard/admin')->group(function () {

            Route::get('/', function () {
                return view('admin.superadmin.dashboard_superadmin');
            })->name('admin.dashboard');

            /* DATA MASTER */

            Route::prefix('/faculties')->group(function () {
                Route::get('/', [FakultasController::class, 'index'])->name('admin.faculties');
                Route::post('/import', [FakultasController::class, 'import'])->name('admin.faculties.import');
            });

            Route::prefix('/departement')->group(function () {
                Route::get('/', [JurusanController::class, 'index'])->name('admin.departement');
                Route::post('/import', [JurusanController::class, 'import'])->name('admin.departement.import');

            });

            Route::prefix('/study_program')->group(function () {
                Route::get('/', [StudiController::class, 'index'])->name('admin.study_program');
                Route::post('/import', [StudiController::class, 'import'])->name('admin.study_program.import');
            });

            Route::prefix('/campus_merdeka_program')->group(function () {
                Route::get('/', [ProgramKampusController::class, 'index'])->name('admin.campus_merdeka_program');
                Route::post('/import', [ProgramKampusController::class, 'import'])->name('admin.campus_merdeka_program.import');
            });

            /* MBKM */

            Route::prefix('/dosen')->group(function () {
                Route::get('/', [DosenController::class, 'index'])->name('admin.dosen');
                Route::post('/import', [DosenController::class, 'import'])->name('admin.dosen.import');
            });

            Route::prefix('/student')->group(function () {
                Route::get('/', [MahasiswaController::class, 'index'])->name('admin.student');
                Route::post('/import', [MahasiswaController::class, 'import'])->name('admin.student.import');
            });

            Route::prefix('/guru')->group(function () {
                Route::get('/', [GuruController::class, 'index'])->name('admin.guru');
                Route::get('/add', [GuruController::class, 'create'])->name('admin.guru.add');
                Route::post('/add', [GuruController::class, 'store'])->name('admin.guru.store');
                Route::post('/import', [GuruController::class, 'import'])->name('admin.guru.import');
            });

            Route::prefix('/dpl')->group(function () {
                Route::get('/', [DPLController::class, 'index'])->name('admin.dpl');
                Route::get('/add', [DPLController::class, 'create'])->name('admin.dpl.add');
                Route::post('/add', [DPLController::class, 'store'])->name('admin.dpl.store');
                Route::post('/import', [DPLController::class, 'import'])->name('admin.dpl.import');
            });

            Route::prefix('/location')->group(function () {
                Route::get('/', [LokasiController::class, 'index'])->name('admin.location');
                Route::get('/add', [LokasiController::class, 'create'])->name('admin.location.add');
                Route::post('/add', [LokasiController::class, 'store'])->name('admin.location.store');
                Route::post('/import', [LokasiController::class, 'import'])->name('admin.location.import');
            });

            Route::prefix('/lowongan')->group(function () {
                Route::get('/', [LowonganController::class, 'index'])->name('admin.lowongan');
                Route::get('/add', [LowonganController::class, 'create'])->name('admin.lowongan.add');
                Route::post('/add', [LowonganController::class, 'store'])->name('admin.lowongan.store');
                Route::post('/import', [LowonganController::class, 'import'])->name('admin.lowongan.import');
            });

            Route::prefix('/peserta')->group(function () {
                Route::get('/', [ProgramTransactionController::class, 'index'])->name('admin.peserta');
                Route::get('/add', [ProgramTransactionController::class, 'create'])->name('admin.peserta.add');
                Route::post('/add', [ProgramTransactionController::class, 'store'])->name('admin.peserta.store');
                Route::post('/import', [ProgramTransactionController::class, 'import'])->name('admin.peserta.import');
            });

        });
    });


});


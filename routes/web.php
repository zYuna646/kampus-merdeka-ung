<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\DPLController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PamongController;
use App\Http\Controllers\ProgramKampusController;
use App\Http\Controllers\ProgramTransactionController;
use App\Http\Controllers\StudiController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsCategoryController;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\roleMiddleware;
use App\Models\ProgramTransaction;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);




Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/berita', [HomeController::class, 'berita'])->name('berita');
Route::get('/infografis', [HomeController::class, 'infografis'])->name('infografis');
Route::get('/program', [HomeController::class, 'lowongan'])->name('program');
Route::get('/detail_program/{id}', [HomeController::class, 'showProgram'])->name('detail_program');
Route::get('/detail_news/{id}', [HomeController::class, 'showNews'])->name('detail_news');
Route::get('/berita/kategori/{category}', [HomeController::class, 'newsByCategory'])->name('news_by_category');
Route::get('/sample', function () {
    return view('document_sp3');
});

Route::get('/get-provinsi', [WilayahController::class, 'getProvinsi'])->name('getProvinsi');
Route::get('/get-kabupaten/{idProvinsi}', [WilayahController::class, 'getKabupaten'])->name('getKabupaten');
Route::get('/get-kecamatan/{idKabupaten}', [WilayahController::class, 'getKecamatan'])->name('getKecamatan');
Route::get('/get-kelurahan/{idKelurahan}', [WilayahController::class, 'getKelurahan'])->name('getKelurahan');

Route::get('/get-fakultas', [FakultasController::class, 'getFakultas'])->name('getFakultas');
Route::get('/get-jurusan/{idFakultas}', [FakultasController::class, 'getJurusan'])->name('getJurusan');
Route::get('/get-prodi/{idJurusan}', [FakultasController::class, 'getProdi'])->name('getProdi');





Route::middleware([AuthenticateMiddleware::class])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'userProfile'])->name('profile');
    Route::post('/update-password', [AuthController::class, 'password'])->name('password');
    Route::post('/update-profile', [AuthController::class, 'profile'])->name('profile.update');


    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::prefix('dashboard/student')->group(function () {
            Route::get('/', [MahasiswaController::class, 'dashboard'])->name('student.dashboard');

            Route::get('/browse_program', function () {
                return view('admin.student.browse_program');
            });
            Route::get('/program_history', [MahasiswaController::class, 'program_history'])->name('student.program_history');
            Route::get('/detail_history', function () {
                return view('admin.student.detail_history');
            })->name('student.detail_history');
            Route::get('/download_daily/{id}', [MahasiswaController::class, 'downloadDaily'])->name('student.download_daily');
            Route::get('/download_surat/{id}', [MahasiswaController::class, 'downloadSurat'])->name('student.download_surat');

            Route::get('/download_week/{id}', [MahasiswaController::class, 'downloadWeekly'])->name('student.download_weekly');
            Route::get('/weekly_logbook/{id}', [MahasiswaController::class, 'weeklyBook'])->name('student.weekly_logbook');
            Route::get('/daily_logbook/{id}', [MahasiswaController::class, 'dailyBook'])->name('student.daily_logbook');
            Route::get('/daily_form/{id}', [MahasiswaController::class, 'dailyLogForm'])->name('student.daily_logbookForm');
            Route::post('/daily_form/{id}', [MahasiswaController::class, 'dailyLog'])->name('student.daily_logbookForm.edit');
            Route::get('/weekly_form/{id}', [MahasiswaController::class, 'weeklyLog'])->name('student.weekly_logbookForm.edit');
            Route::post('/weekly_form/{id}', [MahasiswaController::class, 'weeklyLogSubmit'])->name('student.weekly_logbookForm.edit.submit');
            Route::post('/rancangan/{id}', [MahasiswaController::class, 'rancangan'])->name('student.rancangan.submit');
            Route::post('/register/{id}', [MahasiswaController::class, 'register'])->name('student.register');
        });
    });

    Route::middleware(['role:operator'])->group(function () {
        Route::prefix('dashboard/operator')->group(function () {
            Route::get('/', [OperatorController::class, 'dashboard'])->name('operator.dashboard');
            Route::get('/get-lowongan/{id}', [OperatorController::class, 'getLowongan'])->name('operator.dashboard.getLowongan');
            Route::get('/lowongan_details/{id}', [OperatorController::class, 'detail_lowongan'])->name('operator.lowongan_detail');
            Route::get('/get-peserta/{id}', [OperatorController::class, 'getPesertaDetail'])->name('operator.getPeserta');
            Route::get('/weekly_review/{id}', [OperatorController::class, 'weeklyLogbook'])->name('operator.weeklyLogbook');
        });
    });

    Route::middleware(['role:guru'])->group(function () {
        Route::prefix('dashboard/pamong')->group(function () {
            Route::get('/', [GuruController::class, 'dashboard'])->name('guru.dashboard');
            Route::get('/programs_pamong', function () {
                return view('admin.pamong.programs_pamong');
            });
            Route::get('/program_details_pamong/{lowongan_id}', [GuruController::class, 'programDetail'])->name('guru.program.detail');
            Route::get('/program_details_pamong/{lowongan_id}/{search}', [GuruController::class, 'programDetail'])->name('guru.program.detail.search');
            Route::get('/daily_logbook_pamong/${id}', [GuruController::class, 'dailyBook'])->name('guru.daily.log');
            Route::get('/daily_review_pamong/{id}', [GuruController::class, 'dailyReview'])->name('guru.daily.review');
            Route::get('/get-peserta/{id}', [GuruController::class, 'getPesertaDetail'])->name('guru.getPeserta');
            Route::post('/daily_review_pamong/{id}/{status}', [GuruController::class, 'review'])->name('guru.daily.submit');
            Route::post('/rancangan/{id}', [GuruController::class, 'rancangan'])->name('guru.rancangan.submit');
        });
    });

    Route::middleware(['role:dosen'])->group(function () {
        Route::prefix('dashboard/dpl')->group(function () {
            Route::get('/', [DosenController::class, 'dashboard'])->name('dosen.dashboard');
            Route::get('/programs_dpl', function () {
                return view('admin.dpl.programs_dpl');
            });
            Route::get('/program_details_dpl/{lowongan_id}', [DosenController::class, 'programDetail'])->name('dosen.program.detail');
            Route::get('/weekly_review_dpl/{id}', [DosenController::class, 'dailyBook'])->name('dosen.weekly_review');
            Route::get('/get-peserta/{id}', [DosenController::class, 'getPesertaDetail'])->name('dosen.getPeserta');
            Route::post('/weekly_review_dpl/{id}', [DosenController::class, 'weeklyBook'])->name('dosen.weekly_review.submit');
            Route::post('/rancangan/{id}', [DosenController::class, 'rancangan'])->name('dosen.rancangan.submit');
        });
    });


    Route::middleware(['role:admin'])->group(function () {
        Route::prefix('dashboard/admin')->group(function () {

            Route::get('/',[dashboardController::class, 'admin'])->name('admin.dashboard');

            /* DATA MASTER */

            Route::prefix('/faculties')->group(function () {
                Route::get('/', [FakultasController::class, 'index'])->name('admin.faculties');
                Route::post('/import', [FakultasController::class, 'import'])->name('admin.faculties.import');
                Route::get('/add', [FakultasController::class, 'create'])->name('admin.faculties.add');
                Route::post('/add', [FakultasController::class, 'store'])->name('admin.faculties.store');
                Route::get('/edit/{id}', [FakultasController::class, 'edit'])->name('admin.faculties.edit');
                Route::post('/update/{id}', [FakultasController::class, 'update'])->name('admin.faculties.update');
                Route::delete('/delete/{id}', [FakultasController::class, 'destroy'])->name('admin.faculties.delete');

            });

            Route::prefix('/departement')->group(function () {
                Route::get('/', [JurusanController::class, 'index'])->name('admin.departement');
                Route::post('/import', [JurusanController::class, 'import'])->name('admin.departement.import');
                Route::get('/add', [JurusanController::class, 'create'])->name('admin.departement.add');
                Route::post('/add', [JurusanController::class, 'store'])->name('admin.departement.store');
                Route::get('/edit/{id}', [JurusanController::class, 'edit'])->name('admin.departement.edit');
                Route::post('/update/{id}', [JurusanController::class, 'update'])->name('admin.departement.update');
                Route::delete('/delete/{id}', [JurusanController::class, 'destroy'])->name('admin.departement.delete');


            });

            Route::prefix('/study_program')->group(function () {
                Route::get('/', [StudiController::class, 'index'])->name('admin.study_program');
                Route::post('/import', [StudiController::class, 'import'])->name('admin.study_program.import');
                Route::get('/add', [StudiController::class, 'create'])->name('admin.study_program.add');
                Route::post('/add', [StudiController::class, 'store'])->name('admin.study_program.store');
                Route::get('/edit/{id}', [StudiController::class, 'edit'])->name('admin.study_program.edit');
                Route::post('/update/{id}', [StudiController::class, 'update'])->name('admin.study_program.update');
                Route::delete('/delete/{id}', [StudiController::class, 'destroy'])->name('admin.study_program.delete');

            });

            Route::prefix('/campus_merdeka_program')->group(function () {
                Route::get('/', [ProgramKampusController::class, 'index'])->name('admin.campus_merdeka_program');
                Route::post('/import', [ProgramKampusController::class, 'import'])->name('admin.campus_merdeka_program.import');
                Route::get('/add', [ProgramKampusController::class, 'create'])->name('admin.campus_merdeka_program.add');
                Route::post('/add', [ProgramKampusController::class, 'store'])->name('admin.campus_merdeka_program.store');
                Route::get('/edit/{id}', [ProgramKampusController::class, 'edit'])->name('admin.campus_merdeka_program.edit');
                Route::post('/update/{id}', [ProgramKampusController::class, 'update'])->name('admin.campus_merdeka_program.update');
                Route::delete('/delete/{id}', [ProgramKampusController::class, 'destroy'])->name('admin.campus_merdeka_program.delete');
            });

            /* MBKM */

            Route::prefix('/dosen')->group(function () {
                Route::get('/', [DosenController::class, 'index'])->name('admin.dosen');
                Route::post('/import', [DosenController::class, 'import'])->name('admin.dosen.import');
                Route::get('/export', [DosenController::class, 'export'])->name('admin.dosen.export');
                Route::get('/add', [DosenController::class, 'create'])->name('admin.dosen.add');
                Route::post('/add', [DosenController::class, 'store'])->name('admin.dosen.store');
                Route::get('/edit/{id}', [DosenController::class, 'edit'])->name('admin.dosen.edit');
                Route::post('/update/{id}', [DosenController::class, 'update'])->name('admin.dosen.update');
                Route::delete('/delete/{id}', [DosenController::class, 'destroy'])->name('admin.dosen.delete');
            });

            Route::prefix('/student')->group(function () {
                Route::get('/', [MahasiswaController::class, 'index'])->name('admin.student');
                Route::get('/export', [MahasiswaController::class, 'export'])->name('admin.student.export');
                Route::post('/import', [MahasiswaController::class, 'import'])->name('admin.student.import');
                Route::get('/add', [MahasiswaController::class, 'create'])->name('admin.student.add');
                Route::post('/add', [MahasiswaController::class, 'store'])->name('admin.student.store');
                Route::get('/edit/{id}', [MahasiswaController::class, 'edit'])->name('admin.student.edit');
                Route::post('/update/{id}', [MahasiswaController::class, 'update'])->name('admin.student.update');
                Route::post('/verifikasi/{id}', [MahasiswaController::class, 'verifikasi'])->name('admin.student.verifikasi');
                Route::delete('/delete/{id}', [MahasiswaController::class, 'destroy'])->name('admin.student.delete');
            });

            Route::prefix('/mitra')->group(function () {
                Route::get('/export', [GuruController::class, 'export'])->name('admin.guru.export');
                Route::get('/', [GuruController::class, 'index'])->name('admin.guru');
                Route::get('/add', [GuruController::class, 'create'])->name('admin.guru.add');
                Route::post('/add', [GuruController::class, 'store'])->name('admin.guru.store');
                Route::post('/import', [GuruController::class, 'import'])->name('admin.guru.import');
                Route::delete('/delete/{id}', [GuruController::class, 'destroy'])->name('admin.guru.delete');
                Route::get('/show', [GuruController::class, 'index'])->name('admin.guru.show');
                Route::get('/edit/{id}', [GuruController::class, 'edit'])->name('admin.guru.edit');
                Route::post('/update/{id}', [GuruController::class, 'update'])->name('admin.guru.update');
            });

            Route::prefix('/dpl')->group(function () {
                Route::get('/', [DPLController::class, 'index'])->name('admin.dpl');
                Route::get('/add', [DPLController::class, 'create'])->name('admin.dpl.add');
                Route::post('/add', [DPLController::class, 'store'])->name('admin.dpl.store');
                Route::get('/edit/{id}', [DPLController::class, 'edit'])->name('admin.dpl.edit');
                Route::post('/update/{id}', [DPLController::class, 'update'])->name('admin.dpl.update');
                Route::delete('/delete/{id}', [DPLController::class, 'destroy'])->name('admin.dpl.delete');
                Route::post('/import', [DPLController::class, 'import'])->name('admin.dpl.import');
            });

            Route::prefix('/pamong')->group(function () {
                Route::get('/', [PamongController::class, 'index'])->name('admin.pamong');
                Route::get('/add', [PamongController::class, 'create'])->name('admin.pamong.add');
                Route::post('/add', [PamongController::class, 'store'])->name('admin.pamong.store');
                Route::get('/edit/{id}', [PamongController::class, 'edit'])->name('admin.pamong.edit');
                Route::post('/udpate/{id}', [PamongController::class, 'update'])->name('admin.pamong.update');
                Route::delete('/delete/{id}', [PamongController::class, 'destroy'])->name('admin.pamong.delete');
                Route::post('/import', [PamongController::class, 'import'])->name('admin.pamong.import');
            });

            Route::prefix('/location')->group(function () {
                Route::get('/', [LokasiController::class, 'index'])->name('admin.location');
                Route::get('/add', [LokasiController::class, 'create'])->name('admin.location.add');
                Route::post('/add', [LokasiController::class, 'store'])->name('admin.location.store');
                Route::post('/import', [LokasiController::class, 'import'])->name('admin.location.import');
                Route::get('/edit/{id}', [LokasiController::class, 'edit'])->name('admin.location.edit');
                Route::post('/update/{id}', [LokasiController::class, 'update'])->name('admin.location.update');
                Route::delete('/delete/{id}', [LokasiController::class, 'destroy'])->name('admin.location.delete');
            });

            Route::prefix('/lowongan')->group(function () {
                Route::get('/', [LowonganController::class, 'index'])->name('admin.lowongan');
                Route::get('/add', [LowonganController::class, 'create'])->name('admin.lowongan.add');
                Route::post('/add', [LowonganController::class, 'store'])->name('admin.lowongan.store');
                Route::get('/edit/{id}', [LowonganController::class, 'edit'])->name('admin.lowongan.edit');
                Route::post('/update/{id}', [LowonganController::class, 'update'])->name('admin.lowongan.update');
                Route::post('/import', [LowonganController::class, 'import'])->name('admin.lowongan.import');
                Route::delete('/delete/{id}', [LowonganController::class, 'destroy'])->name('admin.lowongan.delete');
            });

            Route::prefix('/peserta')->group(function () {
                Route::get('/', [ProgramTransactionController::class, 'index'])->name('admin.peserta');
                Route::get('/get/lokasi', [ProgramTransactionController::class, 'getLokasi'])->name('admin.peserta.lokasi');
                Route::get('/get/lowongan', [ProgramTransactionController::class, 'getLowongan'])->name('admin.peserta.lowongan');
                Route::get('/add', [ProgramTransactionController::class, 'create'])->name('admin.peserta.add');
                Route::post('/add', [ProgramTransactionController::class, 'store'])->name('admin.peserta.store');
                Route::get('/edit/{id}', [ProgramTransactionController::class, 'edit'])->name('admin.peserta.edit');
                Route::post('/update/{id}', [ProgramTransactionController::class, 'update'])->name('admin.peserta.update');
                Route::delete('/delete/{id}', [ProgramTransactionController::class, 'destroy'])->name('admin.peserta.delete');
                Route::post('/import', [ProgramTransactionController::class, 'import'])->name('admin.peserta.import');
                Route::delete('/delete/{id}', [ProgramTransactionController::class, 'destroy'])->name('admin.peserta.delete');
            });

            Route::prefix('/peminat')->group(function () {
                Route::get('/', [ProgramTransactionController::class, 'peserta'])->name('admin.peminat');
                Route::get('/locations/{programId}', [ProgramKampusController::class, 'getLocations'])->name('locations.get');
                Route::post('/verifikasi/{id}', [ProgramTransactionController::class, 'verifikasi'])->name('admin.peminat.verifikasi');
                Route::post('/import', [ProgramTransactionController::class, 'verifikasiImport'])->name('admin.peminat.import');
            });

            Route::prefix('/berita')->group(function () {
                Route::get('/', [NewsController::class, 'index'])->name('admin.berita');
                Route::get('/add', [NewsController::class, 'create'])->name('admin.berita.add');
                Route::post('/add', [NewsController::class, 'store'])->name('admin.berita.store');
                Route::get('/edit/{id}', [NewsController::class, 'edit'])->name('admin.berita.edit');
                Route::post('/update/{id}', [NewsController::class, 'update'])->name('admin.berita.update');
                Route::delete('/delete/{id}', [NewsController::class, 'destroy'])->name('admin.berita.delete');
            });

            Route::prefix('/kategori')->group(function () {
                Route::get('/', [NewsCategoryController::class, 'index'])->name('admin.kategori');
                Route::get('/add', [NewsCategoryController::class, 'create'])->name('admin.kategori.add');
                Route::post('/add', [NewsCategoryController::class, 'store'])->name('admin.kategori.store');
                Route::get('/edit/{id}', [NewsCategoryController::class, 'edit'])->name('admin.kategori.edit');
                Route::post('/update/{id}', [NewsCategoryController::class, 'update'])->name('admin.kategori.update');
                Route::delete('/delete/{id}', [NewsCategoryController::class, 'destroy'])->name('admin.kategori.delete');
            });

            Route::prefix('/operator')->group(function () {
                Route::get('/', [OperatorController::class, 'index'])->name('admin.operator');
                Route::get('/add', [OperatorController::class, 'create'])->name('admin.operator.add');
                Route::post('/add', [OperatorController::class, 'store'])->name('admin.operator.store');
                Route::get('/edit/{id}', [OperatorController::class, 'edit'])->name('admin.operator.edit');
                Route::post('/update/{id}', [OperatorController::class, 'update'])->name('admin.operator.update');
            });

        });
    });


});


<?php

// namespace App\Http\Controllers;



use App\Http\Controllers\Hod\HodFormController;
use App\Http\Controllers\Teacher\DashboardController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// AdminControllers
use App\Http\Controllers\Admin\GradeController as AdminGradeController;
use App\Http\Controllers\Admin\SectionController as AdminSectionController;
use App\Http\Controllers\Admin\CasController as AdminCasController;
use App\Http\Controllers\Admin\SubjectController as AdminSubjectController;
use App\Http\Controllers\Admin\SubjectTeacherController as AdminSubjectTeacherController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\SchoolController as AdminSchoolController;
use App\Http\Controllers\Admin\TermController as AdminTermController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartmentController;
use App\Http\Controllers\Admin\CasTypeController as AdminCasTypeController;
use App\Http\Controllers\Admin\AssignmentController as AdminAssignmentController;
use App\Http\Controllers\Admin\ExamController as AdminExamController;
use App\Http\Controllers\GenerateMarksheetController;
use App\Http\Controllers\Admin\DataController as AdminDataController;


// HOD Controllers
use App\Http\Controllers\Hod\DashboardController as HodDashboardController;
use App\Http\Controllers\Hod\AssignmentController as HodAssignmentController;
use App\Http\Controllers\Hod\ExamController as HodExamController;
use App\Http\Controllers\Hod\DataController as HodDataController;


// HOS Controllers
use App\Http\Controllers\Hos\DashboardController as HosDashboardController;
use App\Http\Controllers\Hos\GradeController as HosGradeController;
use App\Http\Controllers\Hos\SubjectController as HosSubjectController;
use App\Http\Controllers\Hos\SubjectTeacherController as HosSubjectTeacherController;
use App\Http\Controllers\Hos\TermController as HosTermController;
use App\Http\Controllers\Hos\StudentController as HosStudentController;
use App\Http\Controllers\Hos\CasTypeController as HosCasTypeController;
use App\Http\Controllers\Hos\SectionController as HosSectionController;
use App\Http\Controllers\Hos\HosFormController;
use App\Http\Controllers\Hos\AssignmentController as HosAssignmentController;
use App\Http\Controllers\Hos\ExamController as HosExamController;
use App\Http\Controllers\Hos\DataController as HosDataController;




// Teacher Controllers
use App\Http\Controllers\Teacher\AssignmentController as TeacherAssignmentController;
use App\Http\Controllers\Teacher\ExamController as TeacherExamController;
use App\Http\Controllers\Teacher\TeacherFormController;
use App\Http\Controllers\Teacher\DataController as TeacherDataController;



use App\Models\Subject;


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
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    }
    return redirect('/login');
});

// Route::get('/test', function () { // Using a test blade file to change UI
//     return view('auth.test');
// });
Route::view('change-password', 'auth.change-password')->name('change-password');

Route::view('change-password', 'auth.change-password')->name('change-password');




/*
 *----------------------------------------------------------------------
 *                      TEACHER Routes
 *----------------------------------------------------------------------
 */
Route::group(['middleware' => ['prevent-back-button', 'auth', 'role:teacher', 'password.change']], function () {

    Route::get('/teacher', [DashboardController::class, 'index'])->name('teacherDashboard.index');



    // Initial form of Teacher

    Route::get("/teacher/dashboard/create/{id}", [TeacherFormController::class, 'formIndex'])->name("teacherForms.index");




    // Assignment/CAS Routes
    Route::get('/teacher/assignments', [TeacherAssignmentController::class, 'index'])->name('teacherAssignments.index');
    Route::get("/teacher/assignments/view/{id}", [TeacherAssignmentController::class, 'view'])->name("teacherAssignments.view");
    Route::get('/teacher/assignments/edit/{id}', [TeacherAssignmentController::class, 'edit'])->name("teacherAssignments.edit");
    Route::post("/teacher/assignments/save/{id}", [TeacherAssignmentController::class, 'updateAndSave'])->name('teacherAssignments.updateAndSave');
    Route::post("/teacher/assignments/update/{id}", [TeacherAssignmentController::class, "updateAndStore"])->name("teacherAssignments.updateAndStore");
    Route::post("/teacher/dashboard/store/cas/{id}", [TeacherFormController::class, "storeCas"])->name("teacherForms.storeCas");
    Route::post("/teacher/dashboard/save/cas/{id}", [TeacherFormController::class, "saveCas"])->name("teacherForms.saveCas");
    Route::delete("/teacher/assignments/delete/{id}", [TeacherAssignmentController::class, "destroy"])->name("teacherAssignments.destroy");




    // Exam Routes
    Route::get("/teacher/exams", [TeacherExamController::class, "index"])->name("teacherExams.index");
    Route::get("/teacher/exams/view/{termId}/{subjectId}", [TeacherExamController::class, "view"])->name("teacherExams.view");
    Route::post("/teacher/dashboard/store/exam/{id}", [TeacherFormController::class, 'storeExam'])->name("teacherForms.storeExam");





    // CAS Report
    Route::get("/teacher/cas/report", [TeacherAssignmentController::class, "reportIndex"])->name("teacherCasReport.index");
    Route::post("/teacher/cas/report", [TeacherAssignmentController::class, "reportSearch"])->name("teacherCasReport.search");





    // Profiler Routes
    Route::get("/teacher/profiler/student", [TeacherDataController::class, "studentProfilerView"])->name("teacherData.studentProfilerView");


    Route::post("/teacher/profiler/student/getdata", [TeacherDataController::class, "getStudentAssignmentData"])->name("teacherData.getStudentData");


    Route::post("/teacher/profiler/getTerms", [TeacherDataController::class, "getTermsForStudent"])->name("teacherData.getTermsForStudent");


    Route::post("/teacher/profiler/student/getAverageData/casType/subject/average", [TeacherDataController::class, "getStudentAverageAssignmentMarksByCasTypeForEachSubject"])->name("teacherData.getStudentAverageAssignmentMarksByCasTypeForEachSubject");


    Route::post("/teacher/profiler/student/gerExamMark/subject", [TeacherDataController::class, "getExamMarksForEachTerm"])->name("teacherData.getExamMarksForEachTerm");


    Route::post("/teacher/profiler/student/getData/term", [TeacherDataController::class, "filterTermForStudentAssignmentData"])->name("teacherData.filterTermForStudentAssignmentData");


    Route::post("/teacher/profiler/student/getAverageData/casType/subject/average/filterByTerm", [TeacherDataController::class, "filterStudentAverageAssignmentMarksByCasTypeForEachSubjectByTerm"])->name("teacherData.filterStudentAverageAssignmentMarksByCasTypeForEachSubjectByTerm");


});







/*
 *----------------------------------------------------------------------
 *                      HOD Routes
 *----------------------------------------------------------------------
 */

Route::group(['middleware' => ['prevent-back-button', 'auth', 'role:hod', 'password.change']], function () {


    Route::get('/hod', [HodDashboardController::class, 'index'])->name('hodDashboard.index');


    Route::get("/hod/dashboard/create/{id}", [HodFormController::class, 'formIndex'])->name("hodForms.index");


    // CAS/Assignment Routes
    Route::get('/hod/assignments', [HodAssignmentController::class, 'index'])->name('hodAssignments.index');
    Route::get("/hod/assignments/view/{id}", [HodAssignmentController::class, 'view'])->name("hodAssignments.view");
    Route::get('/hod/assignments/edit/{id}', [HodAssignmentController::class, 'edit'])->name("hodAssignments.edit");
    Route::post("/hod/assignments/save/{id}", [HodAssignmentController::class, 'updateAndSave'])->name('hodAssignments.updateAndSave');
    Route::post("/hod/assignments/update/{id}", [HodAssignmentController::class, "updateAndStore"])->name("hodAssignments.updateAndStore");
    Route::post("/hod/dashboard/store/cas/{id}", [HodFormController::class, "storeCas"])->name("hodForms.storeCas");
    Route::post("/hod/dashboard/save/cas/{id}", [HodFormController::class, "saveCas"])->name("hodForms.saveCas");
    Route::delete("/hod/assignments/delete/{id}", [HodAssignmentController::class, "destroy"])->name("hodAssignments.destroy");


    // Exam Routes
    Route::get("/hod/exams", [HodExamController::class, "index"])->name("hodExams.index");
    Route::get("/hod/exams/view/{termId}/{subjectId}", [HodExamController::class, "view"])->name("hodExams.view");
    Route::post("/hod/dashboard/store/exam/{id}", [HodExamController::class, 'storeExam'])->name("hodForms.storeExam");


    // Data Visualization Routes
    // Route::get("/hod/analytics", [HodDataController::class, "dataIndex"])->name("hod.dataIndex");



});







/*
 *----------------------------------------------------------------------
 *                      HOS Routes
 *----------------------------------------------------------------------
 */
Route::group(['middleware' => ['prevent-back-button', 'auth', 'role:hos', 'password.change']], function () {


    Route::get('/hos/dashboard', [HosDashboardController::class, 'index'])->name('hosDashboard.index');



    // Grade Routes
    Route::get("/hos/grades", [HosGradeController::class, "index"])->name("hosGrades.index");
    Route::get("/hos/grades/create", [HosGradeController::class, "create"])->name("hosGrades.create");
    Route::post("/hos/grades/store", [HosGradeController::class, "store"])->name("hosGrades.store");
    Route::get("/hos/grades/edit/{grade}", [HosGradeController::class, "edit"])->name("hosGrades.edit");
    Route::put("/hos/grades/update/{grade}", [HosGradeController::class, "update"])->name("hosGrades.update");

    // Subject Routes
    Route::get("/hos/subjects", [HosSubjectController::class, "index"])->name("hosSubjects.index");
    Route::get("/hos/subjects/create", [HosSubjectController::class, "create"])->name("hosSubjects.create");
    Route::post("/hos/subjects/store", [HosSubjectController::class, "store"])->name("hosSubjects.store");
    Route::get("/hos/subjects/edit/{subject}", [HosSubjectController::class, "edit"])->name("hosSubjects.edit");
    Route::put("/hos/subjects/update/{subject}", [HosSubjectController::class, "update"])->name("hosSubjects.update");
    Route::delete("/hos/subjects/delete/{subject}", [HosSubjectController::class, "destroy"])->name("hosSubjects.destroy");


    // SubjectTeachers Routes
    Route::get("/hos/subject-teachers/", [HosSubjectTeacherController::class, "index"])->name("hosSubjectTeachers.index");
    Route::get("/hos/subject-teachers/create", [HosSubjectTeacherController::class, "create"])->name("hosSubjectTeachers.create");
    Route::post("/hos/subject-teachers/store", [HosSubjectTeacherController::class, "store"])->name("hosSubjectTeachers.store");
    Route::get("/hos/subject-teachers/edit/{subject_teacher}", [HosSubjectTeacherController::class, "edit"])->name("hosSubjectTeachers.edit");
    Route::put("/hos/subject-teachers/update/{subject_teacher}", [HosSubjectTeacherController::class, "update"])->name("hosSubjectTeachers.update");
    Route::delete("/hos/subject-teachers/delete/{subject_teacher}", [HosSubjectTeacherController::class, "destroy"])->name("hosSubjectTeachers.destroy");


    // Terms Routes
    Route::get("/hos/terms", [HosTermController::class, "index"])->name("hosTerms.index");
    Route::get("/hos/terms/create", [HosTermController::class, "create"])->name("hosTerms.create");
    Route::post("/hos/terms/store", [HosTermController::class, "store"])->name("hosTerms.store");
    Route::get("/hos/terms/edit/{term}", [HosTermController::class, "edit"])->name("hosTerms.edit");
    Route::put("/hos/terms/update/{term}", [HosTermController::class, "update"])->name("hosTerms.update");
    Route::delete("/hos/terms/delete/{term}", [HosTermController::class, "destroy"])->name("hosTerms.destroy");


    // CAS Types Routes
    Route::get("/hos/cas-types", [HosCasTypeController::class, "index"])->name("hosCasTypes.index");
    Route::get("/hos/cas-types/create", [HosCasTypeController::class, "create"])->name("hosCasTypes.create");
    Route::post("/hos/cas-types/store", [HosCasTypeController::class, "store"])->name("hosCasTypes.store");
    Route::get("/hos/cas-types/edit/{cas_type}", [HosCasTypeController::class, "edit"])->name("hosCasTypes.edit");
    Route::put("/hos/cas-types/update/{cas_type}", [HosCasTypeController::class, "update"])->name("hosCasTypes.update");
    Route::delete("/hos/cas-types/delete/{cas_type}", [HosCasTypeController::class, "destroy"])->name("hosCasTypes.destroy");


    // Sections Routes
    Route::get("/hos/sections", [HosSectionController::class, "index"])->name("hosSections.index");
    Route::get("/hos/sections/create", [HosSectionController::class, "create"])->name("hosSections.create");
    Route::post("/hos/sections/store", [HosSectionController::class, "store"])->name("hosSections.store");
    Route::get("/hos/sections/edit/{section}", [HosSectionController::class, "edit"])->name("hosSections.edit");
    Route::put("/hos/sections/update/{section}", [HosSectionController::class, "update"])->name("hosSections.update");
    Route::delete("/hos/sections/delete/{section}", [HosSectionController::class, "destroy"])->name("hosSections.destroy");



    // Form Routes for CAS and Exam Marks
    Route::get("/hos/dashboard/create/{id}", [HosFormController::class, 'formIndex'])->name("hosForms.index");




    // Assignment/CAS Routes
    Route::get('/hos/assignments', [HosAssignmentController::class, 'index'])->name('hosAssignments.index');
    Route::get("/hos/assignments/view/{id}", [HosAssignmentController::class, 'view'])->name("hosAssignments.view");
    Route::get('/hos/assignments/edit/{id}', [HosAssignmentController::class, 'edit'])->name("hosAssignments.edit");
    Route::post("/hos/assignments/save/{id}", [HosAssignmentController::class, 'updateAndSave'])->name('hosAssignments.updateAndSave');
    Route::post("/hos/assignments/update/{id}", [HosAssignmentController::class, "updateAndStore"])->name("hosAssignments.updateAndStore");
    Route::delete("/hos/assignments/delete/{id}", [HosAssignmentController::class, "destroy"])->name("hosAssignments.destroy");
    Route::post("/hos/dashboard/store/cas/{id}", [HosFormController::class, "storeCas"])->name("hosForms.storeCas");
    Route::post("/hos/dashboard/save/cas/{id}", [HosFormController::class, "saveCas"])->name("hosForms.saveCas");



    // Exam Routes
    Route::get("/hos/exams", [HosExamController::class, "index"])->name("hosExams.index");
    Route::get("/hos/exams/edit/{termId}/{subjectId}", [HosExamController::class, "edit"])->name("hosExams.edit");
    Route::post("/hos/exams/update/{termId}/{subjectId}", [HosExamController::class, "update"])->name("hosExams.update");
    Route::post("/hos/dashboard/store/exam/{id}", [HosFormController::class, 'storeExam'])->name("hosForms.storeExam");
    Route::delete("/hos/exams/delete/{termId}/{subjectId}", [HosExamController::class, "destroy"])->name("hosExams.delete");





    // CAS Report
    Route::get("/hos/cas/report", [HosAssignmentController::class, "reportIndex"])->name("hosCasReport.index");
    Route::post("/hos/cas/report", [HosAssignmentController::class, "reportSearch"])->name("hosCasReport.search");


    // Data Visualization Routes
    Route::get("/hos", [HosDataController::class, "dataIndex"])->name("hosData.dataIndex");
    Route::post("/hos/filterTermAssignmentCount", [HosDataController::class, "filterTermAssignmentCount"])->name("hosData.filterTermAssignmentCount");
    Route::post("/hos/filterTermAssignmentCountByGrade", [HosDataController::class, "filterTermAssignmentCountByGrade"])->name("hosData.filterTermAssignmentCountByGrade");
    Route::post("/hos/filterTermAssignmentAverageBySubject", [HosDataController::class, "filterTermAssignmentAverageBySubject"])->name("hosData.filterTermAssignmentAverageBySubject");
    Route::post("/hos/filterTermExamAverageBySubject", [HosDataController::class, "filterTermExamAverageBySubject"])->name("hosData.filterTermExamAverageBySubject");
    Route::post("/hos/filterTermOverallAverageBySection", [HosDataController::class, "filterTermOverallAverageBySection"])->name("hosData.filterTermOverallAverageBySection");
    Route::post("/hos/filterStudentAverageAssignmentBySubjectTeacher", [HosDataController::class, "filterStudentAverageAssignmentBySubjectTeacher"])->name("hosData.filterStudentAverageAssignmentBySubjectTeacher");
    Route::post("/hos/filter/assignmentByterm", [HosDataController::class, "filterStudentAverageExamBySubjectTeacher"])->name("hosData.filterStudentAverageExamBySubjectTeacher");



    // Student Profiler Routes
    Route::get("/hos/profiler/student", [HosDataController::class, "studentProfilerView"])->name("hosData.studentProfilerView");

    Route::post("/hos/profiler/student/getdata", [HosDataController::class, "getStudentAssignmentData"])->name("hosData.getStudentData");

    Route::post("/hos/profiler/getTerms", [HosDataController::class, "getTermsForStudent"])->name("hosData.getTermsForStudent");

    Route::post("/hos/profiler/student/getData/term", [HosDataController::class, "filterTermForStudentAssignmentData"])->name("hosData.filterTermForStudentAssignmentData");


    Route::post("/hos/profiler/student/getAverageData/casType/subject/average", [HosDataController::class, "getStudentAverageAssignmentMarksByCasTypeForEachSubject"])->name("hosData.getStudentAverageAssignmentMarksByCasTypeForEachSubject");


    Route::post("/hos/profiler/student/getAverageData/casType/subject/average/filterByTerm", [HosDataController::class, "filterStudentAverageAssignmentMarksByCasTypeForEachSubjectByTerm"])->name("hosData.filterStudentAverageAssignmentMarksByCasTypeForEachSubjectByTerm");


    Route::post("/hos/profiler/student/gerExamMark/subject", [HosDataController::class, "getExamMarksForEachTerm"])->name("hosData.getExamMarksForEachTerm");




    // Students
    Route::get("/hos/students", [HosStudentController::class, "index"])->name("hosStudents.index");
    Route::get("/hos/students/create", [HosStudentController::class, "create"])->name("hosStudents.create");
    Route::post("/hos/students/store", [HosStudentController::class, "store"])->name("hosStudents.store");
    Route::get("/hos/students/edit/{student}", [HosStudentController::class, "edit"])->name("hosStudents.edit");
    Route::put("/hos/students/update/{student}", [HosStudentController::class, "update"])->name("hosStudents.update");
    Route::delete("/hos/students/delete/{student}", [HosStudentController::class, "destroy"])->name("hosStudents.destroy");


    Route::get('/hos/bulk-upload', [HosStudentController::class, 'getBulkUpload'])->name('hosStudents.getBulkUpload');
    Route::get('/hos/bulk-sample-download', [HosStudentController::class, 'bulkSample'])->name('hosStudents.bulkSample');
    Route::post('/hos/bulk', [HosStudentController::class, 'bulkUpload'])->name('hosStudents.bulkUpload');




});










/*
 *----------------------------------------------------------------------
 *                      ADMIN Routes
 *----------------------------------------------------------------------
 */

Route::group(['middleware' => ['prevent-back-button', 'auth', 'role:admin', 'password.change']], function () {

    Route::get('/configuration', function () {
        return view('admin.configuration.index');
    })->name('configuration.index');


    Route::get("/home", [AdminDataController::class, "dataIndex"])->name("adminData.dataIndex");


    // Bulk Upload Routes
    Route::get('/bulk-upload', [AdminStudentController::class, 'getBulkUpload'])->name('student.getBulkUpload');
    Route::get('/bulk-sample-download', [AdminStudentController::class, 'bulkSample'])->name('student.bulkSample');
    Route::post('/bulk', [AdminStudentController::class, 'bulkUpload'])->name('student.bulkUpload');



    // Route for the CAS Report
    // Route::get("/cas/report", [AdminCasController::class, 'reportIndex'])->name("cas.reportIndex");
    // Route::get("/cas/report/search", [AdminCasController::class, "reportSearch"])->name("cas.reportSearch");
    // Route::get("/cas/fetchdata", [AdminCasController::class, "fetchData"])->name("cas.fetchData");
    // Route::get("/cas/create/{subjectTeacher}", [AdminCasController::class, "create"])->name("cas.create");
    // Route::post("/cas/store/{subjectTeacher}", [AdminCasController::class, "store"])->name("cas.store");
    // Route::resource("cas", AdminCasController::class)->except(["create", "store"]);


    // EXAM ROUTES
    // todo: Move to resources after completed
    // Route::get("/exam/create/{subjectTeacher}", [AdminExamController::class, "create"])->name("exam.create");
    // Route::get("/exam", [AdminExamController::class, "index"])->name("exam.index");
    // Route::post("/exam/store/{subjectTeacher}", [AdminExamController::class, "store"])->name("exam.store");
    // Route::get("/exam/edit/{exam}", [AdminExamController::class, "edit"])->name("exam.edit");
    // Route::post("/exam/update/{exam}", [AdminExamController::class, "update"])->name("exam.update");
    // Route::delete("/exam/delete/{exam}", [AdminExamController::class, "destroy"])->name("exam.destroy");


    Route::get("/cas/report/search/{subjectTeacher}", [AdminCasController::class, "newReportSearch"])->name("cas.newReportSearch");
    Route::get("/cas/report/{subjectTeacher}", [AdminCasController::class, "newReportIndex"])->name("cas.newReportIndex");
    Route::get("/download-result/{terms}", [AdminTermController::class, "downloadResult"])->name("downloadResult");


    // Marksheet Generation Routes
    Route::get("/marksheet", GenerateMarksheetController::class);

    Route::get("/marksheet", function () {
        return view('admin.marksheets.middleandhighschool');
    });

    Route::get("/elementary-marksheet", function () {
        return view('admin.marksheets.elementary');
    });

    Route::get("/remarks", function () {
        return view("admin.marksheets.remark");
    });

    Route::get("/generate-marksheet", GenerateMarksheetController::class);

    Route::resources([
        "grades" => AdminGradeController::class,
        "schools" => AdminSchoolController::class,
        "terms" => AdminTermController::class,
        "users" => AdminUserController::class,
        "sections" => AdminSectionController::class,
        "departments" => AdminDepartmentController::class,
        "subjects" => AdminSubjectController::class,
        "subject-teachers" => AdminSubjectTeacherController::class,
        "students" => AdminStudentController::class,
        "cas-types" => AdminCasTypeController::class,
        // "assignments" => AdminAssignmentController::class,
    ]);

    Route::get('/download-zip', function () {
        $filePath = storage_path('app/Third-Term-Grade-11.zip');
        return response()->download($filePath);
    });







    // Student Profiler Routes
    Route::get("/admin/profiler/student", [AdminDataController::class, "studentProfilerView"])->name("adminData.studentProfilerView");

    Route::post("/admin/profiler/student/getdata", [AdminDataController::class, "getStudentAssignmentData"])->name("adminData.getStudentData");

    Route::post("/admin/profiler/getTerms", [AdminDataController::class, "getTermsForStudent"])->name("adminData.getTermsForStudent");

    Route::post("/admin/profiler/student/getData/term", [AdminDataController::class, "filterTermForStudentAssignmentData"])->name("adminData.filterTermForStudentAssignmentData");


    Route::post("/admin/profiler/student/getAverageData/casType/subject/average", [AdminDataController::class, "getStudentAverageAssignmentMarksByCasTypeForEachSubject"])->name("adminData.getStudentAverageAssignmentMarksByCasTypeForEachSubject");


    Route::post("/admin/profiler/student/getAverageData/casType/subject/average/filterByTerm", [AdminDataController::class, "filterStudentAverageAssignmentMarksByCasTypeForEachSubjectByTerm"])->name("adminData.filterStudentAverageAssignmentMarksByCasTypeForEachSubjectByTerm");


    Route::post("/admin/profiler/student/gerExamMark/subject", [AdminDataController::class, "getExamMarksForEachTerm"])->name("adminData.getExamMarksForEachTerm");

});
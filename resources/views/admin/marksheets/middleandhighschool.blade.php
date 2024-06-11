<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <div class="containter text-center">
            <img src="{{ asset('storage/logo.jpg') }}" width="350px" height="100px" alt="Logo" style="opacity: 0.5;" >
            <p style="text-transform: uppercase;"><b>Second Term Exam Grade Sheet, 2080</b></p>    
        </div>
        <div class="row">
            <div class="col-4">GRADE: </div>
            <div class="col-4">ROLL NO: </div>
            <div class="col-4">NAME: </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Subjects</th>
                    <th scope="col">Credit Hour</th>
                    <th scope="col">Grade</th>
                    <th scope="col">Grade Point</th>
                    <th scope="col">Final Grade</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-6">Grade Point Average:</div>
            <div class="col-6">Grade Average:</div>
        </div>
        <p>DSS Credit Subjects</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Subjects</th>
                    <th scope="col">Credit Hour</th>
                    <th scope="col">Grade</th>
                    <th scope="col">Grade Point</th>
                    <th scope="col">Final Grade</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <p>ECA & Reading</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Exceptional</th>
                    <th>More Than Satisfactory</th>
                    <th>Satisfactory</th>
                    <th>Need Improvement</th>
                    <th>Not Acceptable</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-end">
            <div>
                <img src="{{ asset('storage/logo.jpg') }}" width="250px" height="50px" alt="Logo">
                <p>Class Teacher</p>
            </div>
            <div>
                <img src="{{ asset('storage/logo.jpg') }}" width="250px" height="50px" alt="Logo">
                <p>Principal</p>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <p style="opacity: 0.6;">Sifal, Kathmandu, Nepal | 977-01-4591250 | <span><a href="mailto:contact@sifal.deerwalk.edu.np">contact@sifal.deerwalk.edu.np</a></span> | deerwalk.edu.np</p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>





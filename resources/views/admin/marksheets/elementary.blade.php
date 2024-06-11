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
        <p>Continuous Assesment System (CAS)</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Subjects</th>
                    <th scope="col">CP (25)</th>
                    <th scope="col">HW (15)</th>
                    <th scope="col">PW (15)</th>
                    <th scope="col">MT (15)</th>
                    <th scope="col">ES (10)</th>
                    <th scope="col">GP</th>
                    <th scope="col">Grade</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <p>Theory & CAS</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Subjects</th>
                    <th scope="col">Theory (25%)</th>
                    <th scope="col">CAS (75%)</th>
                    <th scope="col">GP</th>
                    <th scope="col">Grade</th>
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
            <div class="col-6">Grade Point Average (GPA):</div>
            <div class="col-6">Grade Average (GA):</div>
        </div>
        <p>ECA</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>CP (15)</th>
                    <th>P (15)</th>
                    <th>D (10)</th>
                    <th>ES (10)</th>
                    <th>GP</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <p>Reading Books</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>CP (15)</th>
                    <th>HW (10)</th>
                    <th>BL (15)</th>
                    <th>ES (10)</th>
                    <th>GP</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <p>Grade Threshold</p>
        <table class="table table-bordered">
           <thead>
                <tr>
                    <th>Range</th>
                    <th>90-100</th>
                    <th>80-90</th>
                    <th>70-80</th>
                    <th>60-70</th>
                    <th>50-60</th>
                    <th>40-50</th>
                    <th>35-40</th>
                    <th>0-35</th>
                </tr>
           </thead>
           <tbody>
                <tr>
                    <td>Grade Point</td>
                    <td>4</td>
                    <td>3.6</td>
                    <td>3.2</td>
                    <td>2.8</td>
                    <td>2.4</td>
                    <td>2</td>
                    <td>1.6</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Grade</td>
                    <td>A+</td>
                    <td>A</td>
                    <td>B+</td>
                    <td>B</td>
                    <td>C+</td>
                    <td>C</td>
                    <td>D</td>
                    <td>NG</td>
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





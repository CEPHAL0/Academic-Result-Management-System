@extends('layouts.hos.app')

@section('Page Title', 'Home')

@section('title')

<p>Analytics</p>

    <a href="{{ route('hosData.studentProfilerView') }}"
    class="bg-dark-orange text-white font-normal text-base px-3 py-2 rounded-md">Profiler</a>

@endsection

@section('headScript')

<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    // Load the Visualization API and the corechart package.
        google.charts.load('current', {
            'packages': ['corechart']
        });
</script>

@endsection


@section('content')

<div class="w-full flex py-4 px-3 flex-wrap justify-around gap-y-10">

    <div class="flex justify-around w-full flex-wrap">

        {{-- Assignment Counts Section --}}
        <div class="flex flex-col gap-2 w-1/2 justify-center items-center">
            {{-- <p class="text-lg font-bold">Assignments</p> --}}
            <div id="myPieChart" class="h-64"></div>

            <select name="term_id" id="termId"
                class="w-fit border-2 border-dark-gray rounded-md px-3 py-1 focus:outline-none text-sm focus:border-dark-orange">
                <option value="{{ null }}">-- Select Term --</option>
                @foreach ($terms as $term)
                <option value="{{ $term->id }}">{{ $term->name }} -- Grade {{ $term->grade->name }}</option>
                @endforeach
            </select>
        </div>


        {{-- Assignment Count by Grades --}}
        <div class="flex flex-col gap-2 justify-center items-center">
            {{-- <p class="text-lg font-bold">Assignments By Grade</p> --}}

            <div id="assignmentByGrade"></div>


            <select name="term_id" id="termIdAssignmentCount"
                class="w-fit border-2 border-dark-gray rounded-md px-3 py-1 focus:outline-none text-sm focus:border-dark-orange">

                <option value="{{ null }}">-- Select Term --</option>
                @foreach ($terms as $term)
                <option value="{{ $term->id }}">{{ $term->name }} -- Grade {{ $term->grade->name }}</option>
                @endforeach
            </select>


        </div>
    </div>



    <div class="flex justify-around w-full flex-wrap">
        {{-- Assignment Average Marks By Subject --}}
        <div class="flex flex-col items-center justify-around gap-4">
            {{-- <p class="text-lg font-bold">Average Assignment Marks By Subject</p> --}}

            <div id="averageAssignmentMarksBySubject"></div>

            <select name="term_id" id="termIdAssignmentAverage"
                class="w-fit border-2 border-dark-gray rounded-md px-3 py-1 focus:outline-none text-sm focus:border-dark-orange">

                <option value="{{ null }}">-- Select Term --</option>
                @foreach ($terms as $term)
                <option value="{{ $term->id }}">{{ $term->name }} -- Grade {{ $term->grade->name }}
                </option>
                @endforeach
            </select>
        </div>


        {{-- Exam Average Marks By Subject --}}
        <div class="flex flex-col items-center justify-around gap-4">
            {{-- <p class="text-lg font-bold">Average Exam Marks By Subject</p> --}}


            <div id="examAverageMarksBarGraphData"></div>

            <select name="term_id" id="termIdExamAverage"
                class="w-fit border-2 border-dark-gray rounded-md px-3 py-1 focus:outline-none text-sm focus:border-dark-orange">

                <option value="{{ null }}">-- Select Term --</option>
                @foreach ($terms as $term)
                <option value="{{ $term->id }}">{{ $term->name }} -- Grade {{ $term->grade->name }}
                </option>
                @endforeach
            </select>
        </div>
    </div>


    {{-- Average Exam and Assignment Marks for each section --}}

    <div class="flex flex-col items-center justify-around gap-4 w-full">
        <div id="overallAverageMarksBarGraphData"></div>

        <select name="term_id" id="termIdOverallAverage"
            class="w-fit border-2 border-dark-gray rounded-md px-3 py-1 focus:outline-none text-sm focus:border-dark-orange">

            <option value="{{ null }}">-- Select Term --</option>
            @foreach ($terms as $term)
            <option value="{{ $term->id }}">{{ $term->name }} -- Grade {{ $term->grade->name }}
            </option>
            @endforeach
        </select>
    </div>


    {{-- <div class="flex justify-around w-full flex-wrap">
        <div class="flex flex-col items-center justify-around gap-4  relative">
            <p class="text-lg font-bold">Average Assignment Mark of Student</p>


            <div id="assignmentAverageMarksStudentBarGraph" class="hidden h-80"></div>

            <select name="student_id" id="studentIdAssignmentAverage"
                class="w-fit border-2 border-dark-gray rounded-md px-3 py-1 focus:outline-none text-sm focus:border-dark-orange">

                <option value="{{ null }}">-- Select Student --</option>
                @foreach ($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }} -- {{ $student->roll_number }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col items-center justify-around gap-4  relative">
            <p class="text-lg font-bold">Average Examination Mark of Student</p>


            <div id="examAverageMarksStudentBarGraph" class="hidden h-80"></div>

            <select name="student_id" id="studentIdExamAverage"
                class="w-fit border-2 border-dark-gray rounded-md px-3 py-1 focus:outline-none text-sm focus:border-dark-orange">

                <option value="{{ null }}">-- Select Student --</option>
                @foreach ($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }} -- {{ $student->roll_number }}
                </option>
                @endforeach
            </select>
        </div>
    </div> --}}

</div>


@endsection


@section('script')

{{-- Select 2 initialization --}}
<script>
    $(document).ready(function() {
            $("#studentIdAssignmentAverage").select2();
            $("#studentIdExamAverage").select2();
        })
</script>

{{-- Assignment Percentage by CAS Type --}}
<script>
    let pieData = JSON.parse(`<?php echo $assignmentCountData; ?>`);

        console.log(pieData);

        google.charts.setOnLoadCallback(drawChart);


        function drawChart() {
            let data = google.visualization.arrayToDataTable(pieData);

            let options = {
                "title": "Assignment Type Distribution",
            }

            let chart = new google.visualization.PieChart(document.getElementById("myPieChart"));
            chart.draw(data, options);
        }

        $("#termId").change(function() {
            let termId = $(this).find(":selected").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('hosData.filterTermAssignmentCount') }}",

                data: {
                    "_token": "{{ csrf_token() }}",
                    "term_id": termId,
                },
                success: function(data) {
                    pieData = JSON.parse(data);
                    drawChart();
                },
                error: function(xhr, status, error) {
                    console.log("error", xhr.responseText);
                }
            })
        })
</script>


{{-- Assignment Count By Grade --}}
<script>
    let rawData = <?php echo $assignmentCountByGrade; ?>;

        google.charts.setOnLoadCallback(function() {
            drawBarChart(rawData);
        });


        function drawBarChart(data) {

            let jsonData = data;

            let barGraphData = google.visualization.arrayToDataTable(jsonData);

            let chartHeight = (data.length - 1) * 35;



            let optionsBarChart = {
                "title": "Assignment Counts of Grade",
                "legend": {
                    "position": "none"
                },
                "bars": "vertical",
                "hAxis": {
                    "title": "Number of Assignments",
                    "textStyle": {
                        "fontSize": 10,
                        "whitespace": "nowrap"
                    }
                },
                "orientation": "vertical",
                "vAxis": {
                    "title": "Grade",
                    "textStyle": {
                        "fontSize": 10,
                    }
                },
                "height": chartHeight,
            }

            let chart = new google.visualization.BarChart(document.getElementById("assignmentByGrade"));
            chart.draw(barGraphData, optionsBarChart);
        }

        $("#termIdAssignmentCount").change(function() {
            let termId = $(this).find(":selected").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('hosData.filterTermAssignmentCountByGrade') }}",

                data: {
                    "_token": "{{ csrf_token() }}",
                    "term_id": termId,
                },
                success: function(data) {
                    let rawData = JSON.parse(data);
                    drawBarChart(rawData);
                },
                error: function(xhr, status, error) {
                    console.log("error", xhr.responseText);
                }
            })
        })
</script>

{{-- Average CAS Marks by Subject --}}
<script>
    let assignmentAverageMarksBarGraphData = <?php echo $averageCasMarksBySubject; ?>;

        google.charts.setOnLoadCallback(function() {
            drawAssignmentAverageMarksBarChart(assignmentAverageMarksBarGraphData)
        });


        function drawAssignmentAverageMarksBarChart(data) {

            let jsonData = data;

            console.log(data.length);


            let barGraphData = google.visualization.arrayToDataTable(jsonData);

            let chartHeight = (data.length - 1) * 25;

            let optionsBarChart = {
                "title": "Average Assignment Marks",

                "legend": {
                    "position": "none"
                },

                "orientation": "vertical",
                "vAxis": {
                    "textPosition": "out",
                    "textStyle": {
                        "fontSize": 10,
                    }
                },
                "hAxis": {
                    "title": "Marks",
                    "textStyle": {
                        "fontSize": 10,
                        "whitespace": "nowrap"
                    },
                },
                "height": chartHeight,
                "chartArea": {
                    "top": 20,
                    "bottom": 0
                }
            }

            let chart = new google.visualization.BarChart(document.getElementById("averageAssignmentMarksBySubject"));
            chart.draw(barGraphData, optionsBarChart);
        }

        $("#termIdAssignmentAverage").change(function() {
            let termId = $(this).find(":selected").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('hosData.filterTermAssignmentAverageBySubject') }}",

                data: {
                    "_token": "{{ csrf_token() }}",
                    "term_id": termId,
                },

                success: function(data) {
                    let rawData = JSON.parse(data);
                    drawAssignmentAverageMarksBarChart(rawData);
                },
                error: function(xhr, status, error) {
                    console.log("error", xhr.responseText);
                }
            })
        })
</script>


{{-- Average Exam Marks By Subject --}}
<script>
    let examAverageMarksBarGraphData = <?php echo $averageExamMarksBySubject; ?>;

        google.charts.setOnLoadCallback(function() {
            drawExamAverageMarksBarChart(examAverageMarksBarGraphData);
        });


        function drawExamAverageMarksBarChart(data) {

            let jsonData = data;

            let barGraphData = google.visualization.arrayToDataTable(jsonData);

            let chartHeight = (data.length - 1) * 25;

            let optionsBarChart = {
                "legend": {
                    "position": "none"
                },
                "series": {
                    0: {
                        color: '#EF7634'
                    }
                },

                "orientation": "vertical",
                "hAxis": {
                    "title": "Marks",
                    "textStyle": {
                        "fontSize": 10,
                        "whitespace": "nowrap"
                    }
                },
                "vAxis": {
                    "textPosition": "out",
                    "textStyle": {
                        "fontSize": 10,
                    }
                },

                "height": chartHeight,
                "title": "Average Exam Marks",
                "chartArea": {
                    "top": 20,
                    "bottom": 0
                }

            }



            let chart = new google.visualization.BarChart(document.getElementById("examAverageMarksBarGraphData"));
            chart.draw(barGraphData, optionsBarChart);


            google.visualization.events.addListener(chart, 'error', function(googleError) {
                google.visualization.errors.removeError(googleError.id);
                console.log(googleError.message);

            });
        }

        $("#termIdExamAverage").change(function() {
            let termId = $(this).find(":selected").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('hosData.filterTermExamAverageBySubject') }}",

                data: {
                    "_token": "{{ csrf_token() }}",
                    "term_id": termId,
                },

                success: function(data) {
                    examAverageMarksBarGraphData = JSON.parse(data);
                    drawExamAverageMarksBarChart(examAverageMarksBarGraphData);
                },
                error: function(xhr, status, error) {
                    console.log("error", xhr.responseText);
                }
            })
        })
</script>


{{-- Average Student Assignment Marks for each subject teacher --}}
<script>
    function drawStudentAssignmentAverageMarksBarChart(studentAverageMarksBarGraphData) {
            let data = google.visualization.arrayToDataTable(studentAverageMarksBarGraphData);

            let optionsBarChart = {
                "legend": {
                    "position": "none"
                },
                "hAxis": {
                    "title": "Marks",
                    "textStyle": {
                        "fontSize": 10,
                        "whitespace": "nowrap"
                    }
                },
                "vAxis": {
                    "textPosition": "out",
                    "textStyle": {
                        "fontSize": 10,
                    }
                },

            }



            let chart = new google.visualization.ColumnChart(document.getElementById(
                "assignmentAverageMarksStudentBarGraph"));
            chart.draw(data, optionsBarChart);


            google.visualization.events.addListener(chart, 'error', function(googleError) {
                google.visualization.errors.removeError(googleError.id);
                console.log(googleError.message);

            });
        }

        $("#studentIdAssignmentAverage").change(function() {

            $("#assignmentAverageMarksStudentBarGraph").show();

            let studentId = $(this).find(":selected").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('hosData.filterStudentAverageAssignmentBySubjectTeacher') }}",

                data: {
                    "_token": "{{ csrf_token() }}",
                    "student_id": studentId,
                },

                success: function(data) {
                    studentAverageMarksBarGraphData = JSON.parse(data);
                    drawStudentAssignmentAverageMarksBarChart(studentAverageMarksBarGraphData);
                },
                error: function(xhr, status, error) {
                    console.log("error", xhr.responseText);
                }
            })
        })
</script>


{{-- Average Student Exam Marks for each subject teacher --}}
<script>
    function drawStudentExamAverageMarksBarChart(studentAverageMarksBarGraphData) {
            let data = google.visualization.arrayToDataTable(studentAverageMarksBarGraphData);

            let optionsBarChart = {
                "legend": {
                    "position": "none"
                },
                "hAxis": {
                    "title": "Marks",
                    "textStyle": {
                        "fontSize": 10,
                        "whitespace": "nowrap"
                    }
                },

                "series": {
                    0: {
                        color: '#EF7634'
                    }
                },
                "vAxis": {
                    "textPosition": "out",
                    "textStyle": {
                        "fontSize": 10,
                    }
                },

            }




            let chart = new google.visualization.ColumnChart(document.getElementById(
                "examAverageMarksStudentBarGraph"));
            chart.draw(data, optionsBarChart);


            google.visualization.events.addListener(chart, 'error', function(googleError) {
                google.visualization.errors.removeError(googleError.id);
                console.log(googleError.message);

            });
        }

        $("#studentIdExamAverage").change(function() {

            $("#examAverageMarksStudentBarGraph").show();

            let studentId = $(this).find(":selected").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('hosData.filterStudentAverageExamBySubjectTeacher') }}",

                data: {
                    "_token": "{{ csrf_token() }}",
                    "student_id": studentId,
                },

                success: function(data) {
                    studentAverageMarksBarGraphData = JSON.parse(data);
                    drawStudentExamAverageMarksBarChart(studentAverageMarksBarGraphData);
                },
                error: function(xhr, status, error) {
                    console.log("error", xhr.responseText);
                }
            })
        })
</script>


{{-- Average Exam and Assignment Marks for each section --}}
<script>
    let overallAverageMarksBarGraphData = <?php echo $averageOverallMarksBySection; ?>;

        google.charts.setOnLoadCallback(function() {
            drawOverallAverageMarksBarChart(overallAverageMarksBarGraphData)
        });


        function drawOverallAverageMarksBarChart(data) {
            let jsonData = data;

            let barGraphData = google.visualization.arrayToDataTable(jsonData);

            let chartHeight = (data.length - 1) * 70;

            let optionsBarChart = {
                "legend": {
                    "position": "none"
                },
                "hAxis": {
                    "title": "Marks",
                    "textStyle": {
                        "fontSize": 10,
                        "whitespace": "nowrap"
                    }
                },
                "vAxis": {
                    "textPosition": "out",
                    "textStyle": {
                        "fontSize": 10,
                    }
                },
                "chartArea": {
                    "top": 20,
                    "bottom": 0
                },
                "height": chartHeight,
                "title": "Section Wise Average Assignment and Exam Marks"
            }



            let chart = new google.visualization.BarChart(document.getElementById("overallAverageMarksBarGraphData"));
            chart.draw(barGraphData, optionsBarChart);

            google.visualization.events.addListener(chart, 'error', function(googleError) {
                google.visualization.errors.removeError(googleError.id);
                console.log(googleError.message);

            });
        }

        $("#termIdOverallAverage").change(function() {
            let termId = $(this).find(":selected").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('hosData.filterTermOverallAverageBySection') }}",

                data: {
                    "_token": "{{ csrf_token() }}",
                    "term_id": termId,
                },

                success: function(data) {
                    console.log(data);
                    overallAverageMarksBarGraphData = JSON.parse(data);
                    drawOverallAverageMarksBarChart();
                },
                error: function(xhr, status, error) {
                    console.log("error", xhr.responseText);
                }
            })
        })
</script>

@endsection
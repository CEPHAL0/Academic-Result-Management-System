@extends('layouts.hos.app')

@section('Page Title', 'Student Profiler')

@section('title')
    <p>
        Student Profiler</p>
    <div class="relative text-sm font-normal" id="selectContainer">
        <select name="" id="studentSelect" class="*:text-sm">
            <option value="{{ null }}">--Select Student--</option>
            @foreach ($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }} -- {{ $student->roll_number }}</option>
            @endforeach
        </select>
    </div>
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


    <div class="flex flex-col w-full p-8 gap-10">
        <div id="initialMessage" class="text-center mt-4 text-gray-500">Please select a student</div>


        <div id="termSelectorContainer">
            <p class="text-sm text-gray-500 ml-1">Select Term</p>
            <select id="termSelector" class="w-fit px-3 py-1 border border-black rounded-sm">
            </select>
        </div>


        <div
                class="assignmentGraphContainer flex gap-4 w-full flex-wrap justify-center px-8 py-6 border border-black rounded-md">
            <p class="w-full text-center text-xl py-3">Individual Assignment Performance</p>
            @foreach ($subjects as $subject)
                <div id="{{ str_replace(' ', '', $subject->name) . '-' . str_replace(' ', '', $subject->subject_code) }}"
                     class="hidden">
                </div>
            @endforeach
        </div>


        <div
                class="assignmentCasTypeGraphContainer flex gap-4 w-full flex-wrap justify-center px-4 py-6 border border-black rounded-md">
            <p class="w-full text-center text-xl py-3">CAS-Type Performance</p>
            @foreach ($subjects as $subject)
                <div id="castype_{{ str_replace(' ', '', $subject->name) . '-' . $subject->subject_code }}" class="hidden">
                </div>
            @endforeach
        </div>


        <div class="examGraphContainer flex gap-8 w-full flex-wrap justify-center px-4 py-6 border border-black rounded-md">
            <p class="w-full text-center text-xl py-3">Exam Performance</p>
            @foreach ($subjects as $subject)
                <div id="exam_{{ str_replace(' ', '', $subject->name) . '-' . $subject->subject_code }}" class="hidden">
                </div>
            @endforeach
        </div>
    </div>
@endsection


@section('script')

    {{-- Select 2 initialization --}}
    <script>
        $(document).ready(function() {
            $("#studentSelect").select2();
        })
    </script>


    {{-- Accessing data --}}
    <script>
        function drawBarChart(context, myData, subjectName, colorHex, hAxisTitle) {


            let dataTable = google.visualization.arrayToDataTable(myData);

            let chartHeight = 100 + (myData.length - 1) * 40;

            let optionsBarChart = {
                "title": subjectName,
                "legend": {
                    "position": "none"
                },
                "bars": "vertical",
                "bar": {
                    "groupWidth": "80%",
                },
                "hAxis": {
                    "title": hAxisTitle,
                    "viewWindowMode": "explicit",
                    "viewWindow": {
                        "max": 100,
                        "min": 0,
                    }
                },
                "series": {
                    0: {
                        color: colorHex
                    }
                },
                "height": chartHeight,
                "orientation": "vertical",
            }
            let chart = new google.visualization.BarChart(context);

            google.visualization.events.addListener(chart, 'error', function(googleError) {
                google.visualization.errors.removeError(googleError.id);
                console.log(googleError.message);
                chart.getContainer().style.display = 'none';

            });


            chart.draw(dataTable, optionsBarChart);
        }

        $(document).ready(function() {
            $(".assignmentGraphContainer").hide();
            $(".assignmentCasTypeGraphContainer").hide();
            $(".examGraphContainer").hide();

            $("#termSelectorContainer").hide();

            $("#studentSelect").change(function() {

                let studentId = $(this).find(":selected").val();


                $("#initialMessage").hide();
                $(".assignmentGraphContainer").show();
                $(".assignmentCasTypeGraphContainer").show();
                $(".examGraphContainer").show();
                $("#selectContainer").hide();



                if (studentId == "") {
                    $("#initialMessage").show();
                    $(".assignmentGraphContainer").hide();
                    $(".assignmentCasTypeGraphContainer").hide();
                    $(".examGraphContainer").hide();
                    $("#termSelectorContainer").hide();
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });



                // Populating the terms select dropdown for the selected student
                $.ajax({
                    type: "POST",
                    url: "{{ route('hosData.getTermsForStudent') }}",

                    data: {
                        "_token": "{{ csrf_token() }}",
                        "student_id": studentId,
                    },
                    success: function(data) {
                        $("#termSelectorContainer").show();
                        const jsonData = JSON.parse(data);
                        var options = [];
                        options.push('<option value="' + null +
                            '" selected id="placeHolderOption">--Select--</option>')
                        for (var i = 0; i < jsonData.length; i++) {
                            options.push('<option value="' + jsonData[i].id + '">' + jsonData[i]
                                    .name +
                                '</option>');
                        }

                        $("#termSelector").html(options.join(''));
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                })


                // Populating the individual assignment marks for each subject
                $.ajax({
                    type: "POST",
                    url: "{{ route('hosData.getStudentData') }}",

                    data: {
                        "_token": "{{ csrf_token() }}",
                        "student_id": studentId,
                    },
                    success: function(data) {
                        const jsonData = JSON.parse(data);

                        for (var key in jsonData) {
                            if (jsonData.hasOwnProperty(key)) {
                                $("#" + key).show();
                                const context = document.getElementById(key);
                                let dataForGraph = jsonData[key];
                                drawBarChart(context, dataForGraph, key, "#0181cf",
                                    "Assignment Marks");
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("error", xhr.responseText);
                    }
                })


                // Populating the castype average marks of each subject
                $.ajax({
                    type: "POST",
                    url: "{{ route('hosData.getStudentAverageAssignmentMarksByCasTypeForEachSubject') }}",

                    data: {
                        "_token": "{{ csrf_token() }}",
                        "student_id": studentId,
                    },
                    success: function(data) {
                        const jsonData = JSON.parse(data);

                        for (var key in jsonData) {
                            if (jsonData.hasOwnProperty(key)) {
                                $("#castype_" + key).show();

                                const context = document.getElementById("castype_" + key);
                                let dataForGraph = jsonData[key];
                                drawBarChart(context, dataForGraph, key, "#109618",
                                    "Assignment Marks");
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("error", xhr.responseText);
                    }
                })




                // Populating the exam  marks of each subject
                $.ajax({
                    type: "POST",
                    url: "{{ route('hosData.getExamMarksForEachTerm') }}",

                    data: {
                        "_token": "{{ csrf_token() }}",
                        "student_id": studentId,
                    },
                    success: function(data) {
                        const jsonData = JSON.parse(data);

                        for (var key in jsonData) {
                            if (jsonData.hasOwnProperty(key)) {
                                $("#exam_" + key).show();


                                const context = document.getElementById("exam_" + key);
                                let dataForGraph = jsonData[key];
                                drawBarChart(context, dataForGraph, key, "#ef7634",
                                    "Exam Marks");
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("error", xhr.responseText);
                    }
                })
            });
        })


        // Redrawing the graph when the term is selected
        $("#termSelector").change(function() {

            $("#placeHolderOption").hide();
            var studentId = $("#studentSelect").find(":selected").val();

            var termId = $(this).find(":selected").val();


            // Repopulating the individual assignment data when term is selected
            $.ajax({
                type: "POST",
                url: "{{ route('hosData.filterTermForStudentAssignmentData') }}",

                data: {
                    "_token": "{{ csrf_token() }}",
                    "student_id": studentId,
                    "term_id": termId,
                },
                success: function(termData) {
                    const jsonData = JSON.parse(termData);

                    for (var key in jsonData) {
                        if (jsonData.hasOwnProperty(key)) {
                            $("#" + key).show();

                            const context = document.getElementById(key);
                            let dataForGraph = jsonData[key];
                            drawBarChart(context, dataForGraph, key, "#0181cf", "Assignment Marks");
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log("error", xhr.responseText);
                }
            })



            // Repopulating the casType assignment average data when term is selected
            $.ajax({
                type: "POST",
                url: "{{ route('hosData.filterStudentAverageAssignmentMarksByCasTypeForEachSubjectByTerm') }}",

                data: {
                    "_token": "{{ csrf_token() }}",
                    "student_id": studentId,
                    "term_id": termId,
                },
                success: function(termData) {
                    const jsonData = JSON.parse(termData);

                    for (var key in jsonData) {
                        if (jsonData.hasOwnProperty(key)) {
                            $("#castype_" + key).show();


                            const context = document.getElementById("castype_" + key);
                            let dataForGraph = jsonData[key];
                            drawBarChart(context, dataForGraph, key, "#109618", "Assignment Marks");
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log("error", xhr.responseText);
                }
            })


        })
    </script>
@endsection
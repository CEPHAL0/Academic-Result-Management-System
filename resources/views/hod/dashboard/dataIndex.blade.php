@extends('layouts.hod.app')


@section('Page Title', 'Analytics')



@section('title', 'Analytics')


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

    <div class="w-full flex flex-col py-4 px-3 gap-16">

        <div class="flex w-full justify-center gap-3 flex-wrap">

            <div class="flex flex-col items-center ">
                <p class="text-lg font-bold">Assignment Count</p>
                <div id="assignmentCountBarGraph"></div>
            </div>

            <div class="flex flex-col items-center">
                <p class="text-lg font-bold">Assignment Average</p>
                <div id="assignmentAverageMarksBarGraph"></div>
            </div>
        </div>

        <div class="flex w-full justify-center gap-3 flex-wrap">

            <div class="flex flex-col items-center ">
                <p class="text-lg font-bold">Exam Count</p>
                <div id="examCountBarGraph"></div>
            </div>

            <div class="flex flex-col items-center">
                <p class="text-lg font-bold">Exam Average</p>
                <div id="examAverageMarksBarGraph"></div>
            </div>
        </div>



    </div>

@endsection


@section('script')


    {{-- Assignment Counts --}}

    <script>
        let assignmentCountDataBarGraph = JSON.parse(`<?php echo $assignmentCountsBySubject; ?>`);

        google.charts.setOnLoadCallback(drawAssignmentCountBarGraph);


        function drawAssignmentCountBarGraph() {
            let data = google.visualization.arrayToDataTable(assignmentCountDataBarGraph);

            let options = {
                "legend": {
                    "position": "none"
                },
                "hAxis": {
                    "title": "Number of Assignments",
                },
                "vAxis": {
                    "title": "Subject"
                },

            }

            let chart = new google.visualization.BarChart(document.getElementById("assignmentCountBarGraph"));
            chart.draw(data, options);
        }
    </script>



    {{-- Assignment Average --}}
    <script>
        let assignmentAveraDataBarGraph = JSON.parse(`<?php echo $assignmentAverageMarksBySubject; ?>`);

        google.charts.setOnLoadCallback(drawAssignmentAverageBarGraph);


        function drawAssignmentAverageBarGraph() {
            let data = google.visualization.arrayToDataTable(assignmentAveraDataBarGraph);

            let options = {
                "legend": {
                    "position": "none"
                },
                "hAxis": {
                    "title": "Marks",
                },
                "vAxis": {
                    "title": "Subject"
                },

            }

            let chart = new google.visualization.BarChart(document.getElementById("assignmentAverageMarksBarGraph"));
            chart.draw(data, options);
        }
    </script>


    {{-- Exam Counts --}}
    <script>
        let examCountDataBarGraph = JSON.parse(`<?php echo $examCountsBySubject; ?>`);

        google.charts.setOnLoadCallback(drawExamCountBarGraph);


        function drawExamCountBarGraph() {
            let data = google.visualization.arrayToDataTable(examCountDataBarGraph);

            let options = {
                "legend": {
                    "position": "none"
                },
                "hAxis": {
                    "title": "Number of Exams",
                },
                "vAxis": {
                    "title": "Subject"
                },
                "series": {
                    0: {
                        color: '#EF7634'
                    }
                },

            }

            let chart = new google.visualization.BarChart(document.getElementById("examCountBarGraph"));
            chart.draw(data, options);
        }
    </script>



    {{-- Exam  Average Marks --}}
    <script>
        let examAverageDataBarGraph = JSON.parse(`<?php echo $examAverageMarksBySubject; ?>`);

        google.charts.setOnLoadCallback(drawExamAverageBarGraph);


        function drawExamAverageBarGraph() {
            let data = google.visualization.arrayToDataTable(examAverageDataBarGraph);

            let options = {
                "legend": {
                    "position": "none"
                },
                "hAxis": {
                    "title": "Marks",
                },
                "vAxis": {
                    "title": "Subject"
                },
                "series": {
                    0: {
                        color: '#EF7634'
                    }
                },
            }

            let chart = new google.visualization.BarChart(document.getElementById("examAverageMarksBarGraph"));
            chart.draw(data, options);
        }
    </script>

@endsection

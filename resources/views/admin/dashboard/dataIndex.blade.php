@extends('layouts.admin.app')

@section('Page Title', 'Home')


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

@section('title')
    <p>Analytics</p>
    <a href="{{ route('adminData.studentProfilerView') }}"
        class="bg-dark-orange text-white font-normal text-base px-3 py-2 rounded-md">Profiler</a>
@endsection

@section('content')


    <div class="w-full h-96 mt-4 flex items-stretch justify-center">
        <div id="assignmentCountByGradePieChart"></div>

    </div>
@endsection


@section('script')
    <script>
        let assignmentCountBySchoolData = JSON.parse(`<?php echo $assignmentCountBySchool; ?>`);

        google.charts.setOnLoadCallback(drawAssignmentCountBySchoolPieChart);

        function drawAssignmentCountBySchoolPieChart() {

            let data = google.visualization.arrayToDataTable(assignmentCountBySchoolData);

            let options = {
                title: "Assignment Distribution By School",
                is3D: true,
                chartArea: {
                    height: 300,
                    width: "100%"
                }
            }

            let chart = new google.visualization.PieChart(document.getElementById("assignmentCountByGradePieChart"));

            chart.draw(data, options);
        }
    </script>
@endsection

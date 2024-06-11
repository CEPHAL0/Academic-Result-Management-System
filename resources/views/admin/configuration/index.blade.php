@extends('layouts.admin.app')

@section('title', 'Configuration')

@section('content')

    <body>
        <div>
            <div class="content">
                <h1 class="config_title content-heading">Configuration</h1>

                <div class="card-div">
                    <div class="cards">
                        <button type="button" class="btn btn-primary btn-fullwidth" data-bs-toggle="modal"
                            data-bs-target="#casCutOffModal">
                            <div class="card-body">
                                Cut off date for CAS Backlog
                            </div>
                        </button>
                        <div class="modal fade" id="casCutOffModal" tabindex="-1" aria-labelledby="casCutOffModal"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content modal_container">
                                    <div class="modal-header border-0 align-self-end">
                                        <button type="button" class="btn-close " data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body  d-flex justify-content-center p-0">
                                        <div class="d-flex flex-column justify-content-evenly align-items-center gap-2 w-75">
                                            <p class="align-self-center w-100 text-center fs-4 fw-medium">Please enter the cut off dates of CAS backlog!</p>
                                            <form class="cut-off-form d-flex justify-content-center align-items-center w-100 " method="post" action="#">
                                                @csrf
                                                <div class="comments_input_wrapper w-100 d-flex justify-content-between align-items-center"><input type="number" class="comments_popup_input" /><span class="fw-semibold mx-5">weeks</span></div>
                                            </form>
                                            <div class="modal-footer border-0 p-0 w-100">
                                                <button type="button" class="btn btn-outline-success"
                                                data-bs-dismiss="modal">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="cards">
                        <button type="button" class="btn btn-primary btn-fullwidth" data-bs-toggle="modal"
                            data-bs-target="#marksheetComments">
                            <div class="card-body">
                                Marksheet Comment
                            </div>
                        </button>
                        <div class="modal fade" id="marksheetComments" tabindex="-1" aria-labelledby="casCutOffModal"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content gap-5 modal_container ">
                                    <div class="modal-header border-0 align-self-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body d-flex flex-column gap-3">
                                        <p class="fs-4 text-center fw-medium">Do you want the admins to
                                            add marksheet comments?</p>
                                        <div style="display: flex; justify-content:space-around">
                                            <button type="button" class="btn btn-outline-custom w-25 "
                                                data-bs-dismiss="modal">Yes</button>
                                            <button type="button" class="btn btn-outline-custom w-25 "
                                                data-bs-dismiss="modal">No</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cards">
                        <button type="button" class="btn btn-primary btn-fullwidth" data-bs-toggle="modal"
                            data-bs-target="#casEvaluation">
                            <div class="card-body">
                                CAS Evaluation
                            </div>
                        </button>
                        <div class="modal fade" id="casEvaluation" tabindex="-1" aria-labelledby="casCutOffModal"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content modal_container gap-5">
                                    <div class="modal-header border-0 align-self-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body d-flex flex-column gap-3">
                                        <p class="fs-4 text-center fw-medium">Do you want to add marksheet comments?</p>
                                        <div style="display: flex; justify-content:space-around">
                                            <button type="button" class="btn btn-outline-custom w-25"
                                                data-bs-dismiss="modal">Yes</button>
                                            <button type="button" class="btn btn-outline-custom w-25"
                                                data-bs-dismiss="modal">No</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script>
            function showHam() {
                document.getElementById("side-nav").style.left = "0";
            }

            function closeHam() {
                document.getElementById("side-nav").style.left = "-13rem";
            }

            function resetNavOnResize() {
                if (window.innerWidth > 1040) {
                    document.getElementById("side-nav").style.left = "0";
                } else {
                    document.getElementById("side-nav").style.left = "-13rem";
                }
            }
            window.addEventListener("resize", resetNavOnResize);
        </script>
    </body>
@endsection

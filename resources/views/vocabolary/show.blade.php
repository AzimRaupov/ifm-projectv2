@extends('layouts.app')

@section('content-main')
    <form class="js-step-form"
          style="margin-top: 30px;padding: 10px"
          data-hs-step-form-options='{
        "progressSelector": "#basicVerStepFormProgress",
        "stepsSelector": "#basicVerStepFormContent",
        "endSelector": "#basicVerStepFinishBtn"
      }'>
        <div class="row">
            <div class="col-lg-3">
                <!-- Step -->
                <ul id="basicVerStepFormProgress" class="js-step-progress step step-icon-sm mb-7">
                    <li class="step-item">
                        <a class="step-content-wrapper" href="javascript:;"
                           data-hs-step-form-next-options='{
              "targetSelector": "#step1"
            }'>
                            <span class="step-icon step-icon-soft-dark">1</span>
                            <div class="step-content pb-5">
                                <span class="step-title">Details</span>
                            </div>
                        </a>
                    </li>

                    <li class="step-item">
                        <a class="step-content-wrapper" href="javascript:;"
                           data-hs-step-form-next-options='{
              "targetSelector": "#step2"
            }'>
                            <span class="step-icon step-icon-soft-dark">2</span>
                            <div class="step-content pb-5">
                                <span class="step-title">Details</span>
                            </div>
                        </a>
                    </li>

                </ul>
                <!-- End Step -->
            </div>

            <div class="col-lg-9">
                <!-- Content Step Form -->
                <div id="basicVerStepFormContent">
                    <div id="step1" class="card card-body active" style="min-height: 15rem;">
                        <h4>Details content</h4>

                        <p>...</p>

                        <!-- Footer -->
                        <div class="d-flex align-items-center mt-auto">
                            <div class="ms-auto">
                                <button type="button" class="btn btn-primary"
                                        data-hs-step-form-next-options='{
                        "targetSelector": "#basicVerStepTerms"
                      }'>
                                    Next <i class="bi-chevron-right small"></i>
                                </button>
                            </div>
                        </div>
                        <!-- End Footer -->
                    </div>

                    <div id="step2" class="card card-body" style="display: none; min-height: 15rem;">
                        <h4>Terms content</h4>

                        <p>...</p>

                        <!-- Footer -->
                        <div class="d-flex align-items-center mt-auto">
                            <button type="button" class="btn btn-ghost-secondary me-2"
                                    data-hs-step-form-prev-options='{
                 "targetSelector": "#basicVerStepDetails"
               }'>
                                <i class="bi-chevron-left small"></i> Previous step
                            </button>

                            <div class="ms-auto">
                                <button type="button" class="btn btn-primary"
                                        data-hs-step-form-next-options='{
                        "targetSelector": "#basicVerStepMembers"
                      }'>
                                    Next <i class="bi-chevron-right small"></i>
                                </button>
                            </div>
                        </div>
                        <!-- End Footer -->
                    </div>

                    <div id="basicVerStepMembers" class="card card-body" style="display: none; min-height: 15rem;">
                        <h4>Members content</h4>

                        <p>...</p>

                        <!-- Footer -->
                        <div class="d-sm-flex align-items-center mt-auto">
                            <button type="button" class="btn btn-ghost-secondary mb-3 mb-sm-0 me-2"
                                    data-hs-step-form-prev-options='{
                 "targetSelector": "#basicVerStepTerms"
               }'>
                                <i class="bi-chevron-left small"></i> Previous step
                            </button>

                            <div class="d-flex justify-content-end ms-auto">
                                <button type="button" class="btn btn-white me-2" data-dismiss="modal" aria-label="Close">Cancel</button>
                                <button id="basicVerStepFinishBtn" type="button" class="btn btn-primary">Create project</button>
                            </div>
                        </div>
                        <!-- End Footer -->
                    </div>
                </div>
                <!-- End Content Step Form -->
            </div>
        </div>
        <!-- End Row -->

        <!-- Message Body -->
        <div id="basicVerStepSuccessMessage" class="js-success-message" style="display:none;">
            <div class="text-center">
                <img class="img-fluid mb-3" src="../assets/svg/illustrations/oc-hi-five.svg" alt="Image Description" style="max-width: 15rem;">

                <div class="mb-4">
                    <h2>Successful!</h2>
                    <p>New project has been successfully created.</p>
                </div>

                <div class="d-flex justify-content-center">
                    <a class="btn btn-white me-3" href="#">
                        <i class="bi-chevron-left small ms-1"></i> Back to projects
                    </a>
                    <a class="btn btn-primary" href="#">
                        <i class="tio-city me-1"></i> Add new project
                    </a>
                </div>
            </div>
        </div>
        <!-- End Message Body -->
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Инициализация step form
            var stepForm = new HSStepForm('.js-step-form', {
                progressSelector: "#basicVerStepFormProgress",
                stepsSelector: "#basicVerStepFormContent",
                endSelector: "#basicVerStepFinishBtn"
            }).init();
        });
    </script>
@endsection

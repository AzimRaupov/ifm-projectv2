@extends('layouts.app')

@section('content-main')
<!-- Step Form -->
<style>

</style>
<div class="js-step-form"
      style="margin: 20px"
      data-hs-step-form-options='{
        "progressSelector": "#basicVerStepFormProgress",
        "stepsSelector": "#basicVerStepFormContent",
        "endSelector": "#basicVerStepFinishBtn"
      }'>
    <div class="row">
        <div class="col-lg-3">
            <!-- Step -->
            <ul id="basicVerStepFormProgress" class="js-step-progress step step-icon-sm mb-7">
                @foreach($vocabularies as $index=>$item)

                    <li class="step-item">
                        <a class="step-content-wrapper" href="javascript:;"
                           data-hs-step-form-next-options='{
              "targetSelector": "#form_step{{$item->id}}"
            }'>
                            <span class="step-icon step-icon-soft-dark {{$item->status==1 ? 'bg-warning' : ''}}" >{{$index+1}}</span>
                            <div class="step-content pb-5">
                                <span class="step-title {{$item->status==1 ? 'text-warning' : ''}}">{{$item->title}}</span>
                            </div>
                        </a>
                    </li>

                @endforeach
            </ul>
        </div>

        <div class="col-lg-9">
            <!-- Content Step Form -->
            <div id="basicVerStepFormContent">
                @foreach($vocabularies as $index=>$item)
                    <div id="form_step{{$item->id}}" class="card card-body {{ $index === 0 ? 'active' : '' }}" style="min-height: 15rem;">
                        <h4>{{$item->title}}</h4>

                        <p>{!! $item->text !!}</p>

                         @foreach($item->links as $link)
                            <a href="{{$link->link}}">{{$link->link}}</a>
                         @endforeach
                        @if($item->status==0)
                        <button class="btn btn-warning" id="bt{{$item->id}}" onclick="rd({{$item->id}})" style="width: 100%;margin-top: 10px">Прочитал</button>
                        @endif

                    </div>

                @endforeach

            </div>
        </div>
    </div>

</div>
<!-- End Step Form -->

@endsection

@section('script')
    <script>
        function rd(vid){
            $.ajax({
                url: `{{ route('api.vocabulary.rd') }}`,
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                contentType: "application/json",
                data: JSON.stringify({
                    'id': vid,
                }),
                success: function (res) {
                    document.querySelector(`#bt${vid}`).style = 'display: none';
                    console.log();
                },
                error: function (xhr, status, error) {
                    console.error("Ошибка:", error);
                    console.error("Status:", status);
                    console.error("Response:", xhr.responseText);
                }
            });
        }
        document.addEventListener("DOMContentLoaded", function () {
            // Initialize HSStepForm
            new HSStepForm('.js-step-form', {
                finish: function ($el) {
                    const successMessageTemplate = $el.querySelector('.js-success-message').cloneNode(true);
                    successMessageTemplate.style.display = 'block';

                    $el.style.display = 'none';
                    $el.parentElement.appendChild(successMessageTemplate);
                }
            });
        });
    </script>
@endsection

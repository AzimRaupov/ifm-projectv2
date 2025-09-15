@extends('layouts.app')



@section('head')
    <script src="{{asset('js/main.js')}}"></script>
@endsection

@section('content-main')
    @if($vocabularies->count()>0)

    <style>
        .custom-checkbox {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            font-family: sans-serif;
            font-size: 16px;
            user-select: none;
        }

        .custom-checkbox input {
            display: none;
        }

        .custom-checkbox span {
            width: 20px;
            height: 20px;
            border: 2px solid rgb(245, 202, 153);
            border-radius: 4px;
            display: inline-block;
            margin-right: 8px;
            position: relative;
            transition: all 0.2s;
        }

        .custom-checkbox input:checked + span {
            background-color: rgb(245, 202, 153);
            border-color: rgb(245, 202, 153);
        }

        .custom-checkbox span::after {
            content: "";
            position: absolute;
            display: none;
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .custom-checkbox input:checked + span::after {
            display: block;
        }
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
                            <br>
                            <label class="custom-checkbox">
                                <input type="checkbox" onclick="readV({{$item->id}})">
                                <span></span>
                                Прочитано
                            </label>
                        @endif

                    </div>

                @endforeach

            </div>
        </div>
    </div>

</div>
    @else
     @include('components.my.spinner')
     <script>
         function while_check(){
             reqman("{{route('api.vocabulary.isset')}}", "POST", {id:{{$request->id}}}).then(rr => {
                 console.log(rr);
                 if(rr.count){
                     finish();
                     location.reload();
                 }
             });
         }

         setInterval(function() {
             while_check();
         }, 3700);
     </script>
    @endif


@endsection

@section('script')
    <script>
        function readV(vid){
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

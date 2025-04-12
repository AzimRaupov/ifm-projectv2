@extends('layouts.app')

@section('content-main')
    <style>

    </style>
    <br>
   <h5 style="text-align: center">Вердикты на решение</h5>
    <div class="text-center">
        <ul class="nav nav-segment nav-pills mb-7" role="tablist">
            @foreach($test as $index => $item)
                <li class="nav-item">
                    <a class="nav-link {{ $index === 0 ? 'active' : '' }}"
                       id="test_nav{{ $item->id }}"
                       href="#tab{{ $item->id }}"
                       data-bs-toggle="pill"
                       data-bs-target="#tab{{ $item->id }}"
                       role="tab"
                       aria-controls="tab{{ $item->id }}"
                       aria-selected="{{ $index === 0 ? 'true' : 'false' }}">Тест {{$index+1}}</a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- End Nav -->

    <!-- Tab Content -->
    <div class="tab-content">
        @foreach($test as $index => $item)
            <div class="tests_list card tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
                 id="tab{{ $item->id }}"
                 role="tabpanel"
                 style="width: 1000px;margin-left: 20px"
                 aria-labelledby="test_nav{{ $item->id }}">
                <div class="card-body" data-name="{{$item->id}}" data-value="{{$item->type_test}}">
                    <div class="alert {{$item->verdict=='2' ? 'alert-soft-success' : 'alert-soft-danger'}} text-center" role="alert">
                       {{$item->verdict=='2' ? 'Правилное ришение' : 'Неправильное решение'}}
                    </div>
                    <h2 style="text-align: center">{{$item->text }}</h2> <br>
                    @if ($item->type_test == "question_answer")
                        <textarea class="form-control" id="answer" name="answer_{{$item->id}}" placeholder="Textarea field" rows="4" readonly >{{$item->correct}}</textarea>
                    @elseif ($item->type_test == "one_correct" || $item->type_test == "list_correct")

                        @foreach($item->variants as $in => $variant)
                            @if(in_array($in, (array)$item->correct) && $item->type_test == "list_correct")
                                <!-- Если текущий вариант ($in) содержится в массиве правильных ответов -->
                                <p>
                                    <input type="{{ ($item->type_test == 'one_correct' ? 'radio' : 'checkbox') }}"
                                           id="variant-{{$in}}"
                                           checked
                                           disabled
                                           name="correct_{{$item->id}}[]"
                                           value="{{$in}}"
                                           class="form-check-input ms-2">
                                    <label for="variant-{{$in}}">{{$variant}}</label>
                                </p>
                            @elseif($in == $item->correct && $item->type_test == "one_correct")
                                <!-- Для типа "один правильный ответ" -->
                                <p>
                                    <input type="{{ ($item->type_test == 'one_correct' ? 'radio' : 'checkbox') }}"
                                           id="variant-{{$in}}"
                                           checked
                                           disabled
                                           name="correct_{{$item->id}}"
                                           value="{{$in}}"
                                           class="form-check-input ms-2">
                                    <label for="variant-{{$in}}">{{$variant}}</label>
                                </p>
                            @else
                                <!-- Для всех остальных случаев -->
                                <p>
                                    <input type="{{ ($item->type_test == 'one_correct' ? 'radio' : 'checkbox') }}"
                                           id="variant-{{$in}}"
                                           disabled
                                           name="correct_{{$item->id}}[]"
                                           value="{{$in}}"
                                           class="form-check-input ms-2">
                                    <label for="variant-{{$in}}">{{$variant}}</label>
                                </p>
                            @endif
                        @endforeach

                    @elseif($item->type_test=="matching" && $index!==9)
                        <div class="row">
                            <div class="col-md-6">
                                <div id="t1_list1" class="list-group js-sortable">
                                    @foreach($item->list1 as $in=>$list)
                                        <div class="list-group-item" id="{{$in}}">{{$list}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="t1_list2" class="list-group js-sortable">
                                    @foreach($item->list2 as $in=>$list)
                                        <div class="list-group-item bg-light list2" id="{{$in}}">{{$list}}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    @elseif($item->type_test=="true_false")
                        <p>
                            <input type="radio" id="true" name="true_false_{{$item->id}}" value="1" class="form-check-input ms-2" {{$item->correct==1 ? 'checked' : ''}} disabled>
                            <label for="true">Да</label>
                        </p>
                        <p>
                            <input type="radio" id="false" name="true_false_{{$item->id}}" value="0" class="form-check-input ms-2" {{$item->correct==0 ? 'checked' : ''}} disabled>
                            <label for="false">Нет</label>
                        </p>
                    @endif


                    @if($index===9)
                        <div class="row">
                            <div class="col-md-6">
                                <div id="t2_list1" class="list-group js-sortable">
                                    @foreach($item->list1 as $in=>$list)
                                        <div class="list-group-item" id="{{$in}}">{{$list}}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="t2_list2" class="list-group js-sortable">
                                    @foreach($item->list2 as $in=>$list)
                                        <div class="list-group-item bg-light list2" id="{{$in}}">{{$list}}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- End Tab Content -->

    <!-- End Step Form -->

@endsection



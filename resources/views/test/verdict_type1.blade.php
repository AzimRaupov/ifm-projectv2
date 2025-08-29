@extends('layouts.app')

@section('content-main')
    <br>

    <h2 class="text-center">Вердикт</h2>
    @foreach($tests as $index => $item)
        <div class="tests_list card tab-pane fade show {{ $index === 0 ? 'active' : '' }}"
             id="tab{{ $item->id }}"
             role="tabpanel"
             style="width: 1000px;margin-left: 20px"
             aria-labelledby="test_nav{{ $item->id }}">
            <div class="card-body" data-name="{{$item->id}}" data-value="{{$item->type_test}}">
                <div class="alert {{$verdict[$index]->verdict == '2' ? 'alert-soft-success' : 'alert-soft-danger'}} text-center" role="alert">
                    {{$verdict[$index]->verdict == '2' ? 'Правильное решение +'.$item->score.'exp' : 'Неправильное решение'}}
                </div>
                <h2 style="text-align: center">{{$item->text}}</h2> <br>

                @if ($item->type_test == "question_answer")
                    <textarea class="form-control" id="answer" name="answer_{{$item->id}}" placeholder="Ответ" rows="4" readonly>{{$item->corrects[0]->true}}</textarea>

                @elseif ($item->type_test == "one_correct" || $item->type_test == "list_correct")
                    @foreach($item->variantss as $in => $variant)
                        @if ($item->type_test == "list_correct" && in_array($in, $item->corrects->pluck('true')->toArray()))
                            <p>
                                <input type="checkbox"
                                       id="variant-{{$in}}"
                                       checked
                                       disabled
                                       name="correct_{{$item->id}}[]"
                                       value="{{$in}}"
                                       class="form-check-input ms-2">
                                <label for="variant-{{$in}}">{{$variant->variant}}</label>
                            </p>
                        @elseif ($item->type_test == "one_correct" && $in == $item->corrects[0]->true)
                            <p>
                                <input type="radio"
                                       id="variant-{{$in}}"
                                       checked
                                       disabled
                                       name="correct_{{$item->id}}"
                                       value="{{$in}}"
                                       class="form-check-input ms-2">
                                <label for="variant-{{$in}}">{{$variant->variant}}</label>
                            </p>
                        @else
                            <p>
                                <input type="{{ ($item->type_test == 'one_correct' ? 'radio' : 'checkbox') }}"
                                       id="variant-{{$in}}"
                                       disabled
                                       name="correct_{{$item->id}}[]"
                                       value="{{$in}}"
                                       class="form-check-input ms-2">
                                <label for="variant-{{$in}}">{{$variant->variant}}</label>
                            </p>
                        @endif
                    @endforeach

                @elseif ($item->type_test == "matching")
                    <div class="row">
                        <div class="col-md-6">
                            <div class="list-group js-sortable">
                                @foreach($item->lists1 as $in => $list)
                                    <div class="list-group-item" id="{{$in}}">{{$list->str}}</div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="list-group js-sortable">
                                @foreach($item->lists2 as $in => $list)
                                    <div class="list-group-item bg-light list2" id="{{$in}}">{{$list->str}}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                @elseif ($item->type_test == "true_false")
                    <p>
                        <input type="radio"
                               id="true"
                               name="true_false_{{$item->id}}"
                               value="1"
                               class="form-check-input ms-2"
                               {{$item->corrects[0]->true == 1 ? 'checked' : ''}}
                               disabled>
                        <label for="true">Да</label>
                    </p>
                    <p>
                        <input type="radio"
                               id="false"
                               name="true_false_{{$item->id}}"
                               value="0"
                               class="form-check-input ms-2"
                               {{$item->corrects[0]->true == 0 ? 'checked' : ''}}
                               disabled>
                        <label for="false">Нет</label>
                    </p>
                @endif
            </div>
        </div>
        <br>
    @endforeach

@endsection

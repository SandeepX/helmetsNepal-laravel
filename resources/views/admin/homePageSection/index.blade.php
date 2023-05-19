@php use App\Http\Enums\EStatus; @endphp
@extends('admin.master')

@section('title')
    Home Page Section
@stop
@section('page_title')
    List
@stop
@section('js')
    <script src="{{ asset('admin/assets/js/sortable.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
    <script src="{{ asset('admin/assets/changeStatus.js') }}"></script>
    <script>
        $('#items-1').sortable({
            group: 'list',
            animation: 200,
            ghostClass: 'ghost',
        });
    </script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                        {!! Form::open(['route'=>'admin.homePageSection.update','method'=>'POST','id'=>'homePageSection_submit']) !!}
                        <div id="items-1" class="list-group col items-drag-wrap pl-0 pr-0">
                            @foreach($_homePageSection as $value)
                                <div id="{{$value->id}}" data-id="{{$value->id}}" class="list-group-item nested-1">
                                    <input type="hidden" value="{{$value->id}}" name="homePageSection_id[]">
                                    <h5>{{$value->name}}</h5>
                                    <h5>{{++$value->position}}</h5>
                                    <span class="form-check form-switch">
                                        <input type="checkbox" href="{{route('admin.homePageSection.changeStatus',$value->id)}}" class="form-check-input change-status-toggle"
                                               @if($value->status === EStatus::active->value) checked @endif>
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        @if($_homePageSection->count() != 0)
                            <div class="text-right">
                                <button type="submit" class="btn btn-success">Update Position
                                    <i class="lab la-telegram-plane"></i>
                                </button>
                            </div>
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@extends('layouts.app')

@section('content')
<div class="done-process" id="done" style="">
    <div class="container">
        <div class="content">
          <p id="message-text">{{isset($status->status) ? $status->status : ''}}</p>
            <i class="fa fa-check"></i>
            <p id="message-text">{{isset($status->message) ? $status->message : ''}}</p>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection

@section('jslink')

@endsection

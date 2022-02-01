
@extends('layouts.app')
@section('css')
    <style>
        .bgp {
            border-radius: 5px;
            color: #ffffff !important;
            font-size: 10px;
            padding: 5px 0px;
            width: 150px;
            display: block;
            cursor: pointer;
            text-align: center;
            margin: 10px
        }

        .shadow-bgp-all{
            transition: box-shadow .10s;
        }
        .shadow-bgp-all:hover {
            box-shadow: 0.3rem 0.3rem black, -0.3rem -0.3rem
        }
        .bgp-01 {
            background-color: #b2b2b2;
            text-decoration:none !important;
        }
        .bgp-02 {
            background-color: #19967d;
            text-decoration:none !important;
        }
        .bgp-03 {
            background-color: #8b90ff;
            text-decoration:none !important;
        }
        .bgp-04 {
            background-color: #7ab648;
            text-decoration:none !important;
        }
        .bgp-05 {
            background-color: #fcc438;
            text-decoration:none !important;
        }

    </style>
@endsection
@section('content')
<div class="panel panel-inverse" data-sortable-id="table-basic-1">
    <div class="panel-heading ui-sortable-handle">
        <h4 class="panel-title">Diagrama de red Actual</h4>

    </div>
    <div class="panel-body">
        @foreach($teams as $item1)
            @if ($item1->team_id == null)
                <div class="bgp bgp-01 shadow-bgp-all">
                    {{ $item1->title }} <br /> {{ $item1->ip }}
                </div>
                <div class="ml-5 mb-5">
                    @foreach($teams as $item2)
                        @if ($item2->team_id == $item1->id )
                            <a href="@if( $item2->group != 1 ) http://{{ $item2->ip }} @endif" target="_blank" class="bgp bgp-02 shadow-bgp-all">
                                {{ $item2->title }} <br /> {{ $item2->ip }}
                            </a>
                            <div class="ml-5 mb-5 ">
                                @foreach($teams as $item3)
                                    @if ($item3->team_id == $item2->id )
                                        <div class="bgp bgp-03 shadow-bgp-all">
                                            {{ $item3->title }} <br /> {{ $item3->ip }}
                                        </div>
                                        <div class="ml-5 mb-5 row d-flex align-self-start">
                                            @foreach($teams as $item4)
                                                @if ($item4->team_id == $item3->id && $item4->group !== 0 )
                                                    <div class="d-inline-block">
                                                        <div class="bgp bgp-04 shadow-bgp-all">
                                                            {{ $item4->title }} <br /> {{ $item4->ip }}
                                                        </div>
                                                        <div class="ml-5 mb-5">
                                                            @foreach($teams as $item5)
                                                                @if ($item5->team_id == $item4->id )
                                                                    <a href="@if( $item5->group != 1 ) http://{{ $item5->ip }} @endif" target="_blank" class="bgp bgp-05 mb-3 shadow-bgp-all">
                                                                        {{ $item5->title }} <br /> {{ $item5->ip }}
                                                                    </a>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($item4->team_id == $item3->id && $item4->group === 0 )
                                                    <div class="d-inline-block">
                                                        <a href="@if( $item4->group != 1 ) http://{{ $item4->ip }} @endif" target="_blank" class="bgp bgp-05 shadow-bgp-all">
                                                            {{ $item4->title }} <br /> {{ $item4->ip }}
                                                        </a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection
@section('js')
<script>
    $('#diagrams_nav').removeClass("closed").addClass("active").addClass("expand")
</script>
@endsection





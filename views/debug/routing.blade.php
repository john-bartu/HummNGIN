@extends('template-box')

@section('article')
    <h1>
        Routing Table
    </h1>
    <table style="width:80%;">

        <tr>
            <th>Endpoint Name</th>
            <th>Path</th>
            <th>Methods</th>
        </tr>
        @foreach($routing as $route)
            <tr>
                <td>{{$route[0]}}</td>
                <td>{{$route[1]}}</td>
                <td>{{implode(" | ",$route[2])}}</td>
            </tr>
        @endforeach
    </table>
@endsection
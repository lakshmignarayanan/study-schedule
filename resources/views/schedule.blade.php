@extends('layout.mainlayout')
@section('content')
    <div class="album text-muted">
        <div class="container">
            @if(!empty($data["schedule"]))
                <h2>Index: </h2>
                @foreach ($data["schedule"] as $schedule_item)
                    @if(isset($schedule_item["name"]) && !empty($schedule_item["activities"]))
                        <a href="#{{$schedule_item['name']}}">{{$schedule_item["name"]}} ({{$schedule_item["totalTimeInWords"]??""}})</a>
                        <br>
                    @endif
                @endforeach
            @endif
            <div class="row">
                <h2>Schedule for the course: </h2>
                @if(!empty($data["schedule"]))
                    @foreach ($data["schedule"] as $schedule_item)
                        @if(isset($schedule_item["name"]) && !empty($schedule_item["activities"]))
                            <h3 id="{{$schedule_item['name']}}">{{$schedule_item["name"]}} ({{$schedule_item["totalTimeInWords"]??""}})</h3>
                            <ol>
                            @foreach ($schedule_item["activities"] as $activity_item)
                                @if(isset($activity_item["name"]))
                                    @php $name = $activity_item["name"]; @endphp
                                    @if(isset($activity_item["isComplete"]) && $activity_item["isComplete"] == true)
                                        @php $name = $name . " (Completed)"; @endphp
                                    @endif
                                    <li>{{$name}}</li>
                                @endif
                            @endforeach
                            </ol>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
   </div>
@endsection
<b></b>
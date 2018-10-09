@extends('app')

@section('title', 'ვის ტყნავს იუზერი')


@section('content')

    <a href="{{url('/list')}}" class="vinvis">.tk/navs</a>
    <a href="{{url('/')}}" class="vinvis">ახალი თამაში</a>


    <div class="general-stats" >
        <h2 style="margin-top:10px;">{{$user->name}}</h2>
        <p>სულ თამაშები : <span style="font-weight:bold">{{$user->games_played}}</span></p>
       <p>მოგებული თამაშები : <span style="font-weight:bold">{{$user->win}}</span></p>
       <p>წაგებული თამაშები : <span style="font-weight:bold">{{$user->lost}}</span></p>
       <p>ფრე თამაშები : <span style="font-weight:bold">{{$user->draw}}</span></p>
       <p>გატანილი გოლები : <span style="font-weight:bold">{{$user->goals_scored}}</span></p>
       <p>საშუალო გოლი თამაშში : <span style="font-weight:bold">{{round($user->goals_scored/$user->games_played,2)}}</span></p>
       <p>გაშვებული გოლები : <span style="font-weight:bold">{{$user->goals_conceded}}</span></p>
       <p>საშუალო გაშვებული გოლი თამაშში : <span style="font-weight:bold">{{round($user->goals_conceded/$user->games_played,2)}}</span></p>
       <p>ქულები : <span style="font-weight:bold">{{$user->points}}</span></p>
       <p>საშუალო ქულა : <span style="font-weight:bold">{{round($user->points/$user->games_played,2)}}</span></p>
       <p>რეიტინგი : <span style="font-weight:bold">{{round($user->score,2)}}</span></p>

    </div>

    <div class="matches-widget" >

        <?php
        $user_matches = [];
        ?>
        @foreach($matches as $match)

                <?php




                if($user->id == $match->first_user_id){
                    $userScore = $match->first_user_goal;
                    $oponentScore= $match->second_user_goal;
                    $oponentId = $match->second_user_id;
                    $oponent = $match->second_user;

                } else {
                    $oponent = $match->first_user;
                    $userScore = $match->second_user_goal;
                    $oponentScore= $match->first_user_goal;
                    $oponentId = $match->first_user_id;
                }

                $difference = $match->difference;



                if(isset( $user_matches[$oponent->name])){
                    array_push($user_matches[$oponent->name], $match);
                } else {
                    $user_matches[$oponent->name] = [];
                    array_push($user_matches[$oponent->name], $match);
                }

                $class = 'win';
                if($userScore == $oponentScore)$class = 'draw';
                if($userScore < $oponentScore) $class = 'lost';

                ?>

            <div class="tooltip match {{$class}}" data-oponent="{{$oponentId}}" data-userScore="{{$userScore}}" data-oponentScore="{{$oponentScore}}">
                <span>W</span>
                <span>D</span>
                <span>L</span>
                <span class="tooltiptext">vs {{$oponent->name}} {{$userScore}} - {{$oponentScore}} <br>  სხვაობა {{$difference}} </span>
            </div>

        @endforeach


    </div>


    <h2 style="margin-top: 2em;">ვის ტყნავს {{$user->name}}???</h2>
    <div class="user_matches">

        @foreach($user_matches as $oponent => $matches)


            <div class="oponent-container">


                <?php
                $win =0;
                $lose =0;
                $draw =0;




                if($user->id == $matches[0]->first_user_id){
                    $opId = $matches[0]->second_user_id;

                } else{
                    $opId = $matches[0]->first_user_id;

                }

                ?>
                <div class="name">
                    <a href="{{url("/user/{$opId}")}}}">
                {{$oponent}}
                    </a>
                </div>

                <div class="games">
                    @foreach($matches as $match)

                        <?php




                        if($user->id == $match->first_user_id){
                        $userScore = $match->first_user_goal;
                        $oponentScore= $match->second_user_goal;
                        $oponentId = $match->second_user_id;
                        $oponent = $match->second_user;

                        } else {
                        $oponent = $match->first_user;
                        $userScore = $match->second_user_goal;
                        $oponentScore= $match->first_user_goal;
                        $oponentId = $match->first_user_id;
                        }



                        $difference = $match->difference;

                        if($userScore == $oponentScore){
                            $class = 'draw';
                            $draw++;
                        } else if($userScore < $oponentScore) {
                            $class = 'lost';
                            $lose++;
                        } else {
                            $class = 'win';
                            $win++;
                        }

                        ?>

                        <div class="tooltip match {{$class}}" data-oponent="{{$oponentId}}" data-userScore="{{$userScore}}" data-oponentScore="{{$oponentScore}}">
                            <span>W</span>
                            <span>D</span>
                            <span>L</span>
                            <span class="tooltiptext">vs {{$oponent->name}} {{$userScore}} - {{$oponentScore}} <br> სხვაობა {{$difference}} </span>
                        </div>

                    @endforeach
                </div>

                <div class="results">
                    <span>{{$win}}-{{$draw}}-{{$lose}}</span>
                </div>

            </div>

        @endforeach


    </div>

</body>
</html>


@endsection

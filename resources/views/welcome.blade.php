@extends('app')

@section('title', 'ვინ ვის ტყნავს ')


@section('content')




    <a href="{{url('/list')}}" class="vinvis">.tk/navs</a>
    <form method="post" action="{{ action('MatchController@addMatch') }}">
        {{ csrf_field() }}


        <div class="">
            <select name="first_user_id">
                @foreach($users as $user)
                    <option value="{{$user->id}}">
                        {{$user->name}}
                    </option>
                @endforeach
            </select>
            <input type="number" name="first_user_goal" placeholder="პირველის გოლი">
        </div>
        <div class="">
            <select name="second_user_id">
                @foreach($users as $user)
                    <option value="{{$user->id}}">
                        {{$user->name}}
                    </option>
                @endforeach
            </select>
            <input type="number" name="second_user_goal" placeholder="მეორეს გოლი">
        </div>

        <input type="submit" value="დამატება">
    </form>

    <div class="last-matches">
        @foreach($matches as $match)

            <?php
            $firstUserChange = "";
            $secondUserChange = "";

            if($match->first_user_goal > $match->second_user_goal){
                $firstUserChange = "+";
                $secondUserChange = "-";
            }

            if($match->first_user_goal < $match->second_user_goal){
                $firstUserChange = "-";
                $secondUserChange = "+";
            }



            if($match->first_user_goal == $match->second_user_goal){
                if($match->first_user_score >  $match->second_user_score){
                    $firstUserChange = "-";
                    $secondUserChange = "+";
                } else {
                    $firstUserChange = "+";
                    $secondUserChange = "-";
                }
            }

            $difference = $match->difference;

            ?>

            <div class="last-match">
                <a href="{{url("/user/{$match->first_user->id}")}}" class="player ">
                    <span class="change<?php if($firstUserChange == '-') echo '-' ?>">{{$match->first_user_score}} {{$firstUserChange}} {{$difference}} </span>
                    {{$match->first_user->name}} </a>
            <span class="score">{{$match->first_user_goal}} - {{$match->second_user_goal}}</span>

            <a href="{{url("/user/{$match->second_user->id}")}}" class="player ">{{$match->second_user->name}} <span class="change<?php if($secondUserChange == '-') echo '-' ?>">{{$match->second_user_score}} {{$secondUserChange}} {{$difference}} </span></a>
            </div>


        @endforeach
    </div>
@endsection

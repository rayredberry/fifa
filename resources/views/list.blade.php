@extends('app')

@section('title', 'ვინ ვის ტყნავს სია')


@section('content')
    <a href="{{url('/')}}" class="vinvis">ახალი თამაში</a>


    <h2>ვინ ვის ტყნავს??</h2>
    <div class="table-wrapper">

        <table>
            <tr>
                <td>N</td>
                <th>სახელი</th>
                <th>თამაში</th>
                <th>მოგება</th>
                <th>ფრე</th>
                <th>წაგება</th>
                <th>გოლი +</th>
                <th>გოლი -</th>
                <th>საშუალო ქულა</th>
                <th>რეიტინგი</th>

            </tr>
            <?php $count=1; ?>
            @foreach($users as $user)
                @if($user->games_played > 3)
            <tr>
                <td>{{$count}}</td>
                <td><a href="{{url("/user/{$user->id}")}}">{{$user->name}}</a></td>
                <td>{{$user->games_played}}</td>
                <td>{{$user->win}}</td>
                <td>{{$user->draw}}</td>
                <td>{{$user->lost}}</td>
                <td>{{$user->goals_scored}}</td>
                <td>{{$user->goals_conceded}}</td>
                <td><?php if($user->games_played != 0){ echo round($user->points / $user->games_played,2);} else{  echo 0;}?></td>
                <td>{{$user->score}}</td>

            </tr>
                <?php $count++; ?>
                @endif

            @endforeach
        </table>
    </div>



@endsection

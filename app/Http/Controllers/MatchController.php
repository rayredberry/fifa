<?php

namespace App\Http\Controllers;

use App\Match;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();

        $matches = Match::orderBy('id', 'desc')->with(['first_user', 'second_user'])->take(10)->get();

        return view('welcome',['users' => $users, 'matches' => $matches]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $handle = fopen('http://localhost/fifa/public/fifa.csv', 'r');
        $header = 0;

        while ($csvLine = fgetcsv($handle, 1000, ",")) {

            if ($header < 2) {
                $header += 1;
            } else {
                if($csvLine[0] == '')break;
                $firstUser = User::where('name', $csvLine[0])->first();
                $secondUser = User::where('name', $csvLine[1])->first();
                $firstUserGoal = $csvLine[2];
                $secondUserGoal = $csvLine[3];

                $this->insertMatch($firstUser, $secondUser, $firstUserGoal, $secondUserGoal);
            }
        }
        exit();

    }


    public function updateHeisienberg(){

    }

    public function insertMatch($firstUser, $secondUser, $firstUserGoal, $secondUserGoal){

        $oldscore1 = $firstUser->score;
        $oldscore2 = $secondUser->score;





        $difference =  $secondUser->score - $firstUser->score ;
        $difference += 10;




        $firstUser->games_played += 1;
        $firstUser->goals_scored += $firstUserGoal;
        $firstUser->goals_conceded += $secondUserGoal;

        $secondUser->games_played += 1;
        $secondUser->goals_scored += $secondUserGoal;
        $secondUser->goals_conceded += $firstUserGoal;


        echo $firstUser->score . ' ' . $firstUser->name .' ' . $firstUserGoal . ' - ' .$secondUserGoal . ' ' . $secondUser->name .' ' . $secondUser->score  . '<br>';

        if($firstUserGoal > $secondUserGoal){
            $firstUser->win += 1;
            $secondUser->lost += 1;
            $firstUser->points += 3;
            $scale = 1;
            if($firstUserGoal - $secondUserGoal > 2){
                $scale = 1.5;
            }




            if($difference >= 20){
                $firstUser->score += 2*$scale;
                $secondUser->score -= 2*$scale;

            } else if ($difference > 0){
                $firstUser->score += $difference*$scale/10;
                $secondUser->score -= $difference*$scale/10;
            } else {

            }

        } elseif ($firstUserGoal == $secondUserGoal){
            $firstUser->draw += 1;
            $secondUser->draw += 1;
            $firstUser->points +=1;
            $secondUser->points +=1;


            $difference -= 10;
            if($difference >= 10){
                $firstUser->score += 1;
                $secondUser->score -= 1;

            } else if ($difference > -10){
                $firstUser->score += $difference/10;
                $secondUser->score -= $difference/10;
            } else {
                $firstUser->score -= 1;
                $secondUser->score += 1;
            }

        } else{
            $firstUser->lost += 1;
            $secondUser->win += 1;
            $secondUser->points += 3;

            $scale = 1;
            if($secondUserGoal - $firstUserGoal > 2){
                $scale = 1.5;
            }


            if($difference >= 20){


            } else if ($difference > 0){
                $secondUser->score += (20 - $difference)*$scale/10;
                $firstUser->score -= (20 - $difference)*$scale/10;
            } else {
                $firstUser->score -= 2*$scale;
                $secondUser->score += 2*$scale;

            }

        }

        if($secondUser->score > $secondUser->max_score){
            $secondUser->max_score = $secondUser->score;
        } else if($secondUser->score < $secondUser->min_score){
            $secondUser->min_score = $secondUser->score;
        }

        if($firstUser->score > $firstUser->max_score){
            $firstUser->max_score = $firstUser->score;
        } else if($firstUser->score < $firstUser->min_score){
            $firstUser->min_score = $firstUser->score;
        }

        echo $firstUser->score . ' ' . $firstUser->name  . ' - ' .$secondUser->name . ' ' . $secondUser->score  . '<br> <br>';

        Match::create([
            'first_user_id' => $firstUser->id,
            'second_user_id' => $secondUser->id,
            'first_user_goal' => $firstUserGoal,
            'second_user_goal' => $secondUserGoal,
            'first_user_score' => $oldscore1,
            'second_user_score' => $oldscore2,
            'difference' => abs($firstUser->score - $oldscore1)
        ]);

        $firstUser->save();
        $secondUser->save();

    }

    public function addMatch(Request $request){


        $firstUser = User::find($request->input('first_user_id'));
        $secondUser =User::find($request->input('second_user_id'));

        $firstUserGoal = $request->input('first_user_goal');
        $secondUserGoal = $request->input('second_user_goal');

        $this->insertMatch($firstUser, $secondUser, $firstUserGoal, $secondUserGoal);


        $users = User::orderBy('score', 'desc')->get();
        return view('list',['users' => $users]);
    }



    public function delete($id){
        $matches = Match::where('id', '!=' , $id)->get();
        $oldmatches = $matches;
        DB::table('users')->where('id', '>', 0)->update(array(
            'games_played' => 0,
            'goals_scored' => 0,
            'goals_conceded' => 0,
            'win' => 0,
            'lost' => 0,
            'draw' => 0,
            'points' => 0,
            'score' => 40));


        Match::where('id', '>', 0)->delete();
        foreach($oldmatches as $match){

            $firstUser = User::find($match->first_user_id);
            $secondUser =User::find($match->second_user_id);

            $this->insertMatch($firstUser, $secondUser, $match->first_user_goal, $match->second_user_goal);
        }

        exit();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function show(Match $match)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function edit(Match $match)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Match $match)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function destroy(Match $match)
    {
        //
    }
}

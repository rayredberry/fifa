<?php

namespace App\Http\Controllers;

use App\Match;
use Illuminate\Http\Request;
use App\User;


class HomeController extends Controller
{
    //
    public function index()
    {
        //
        return view('welcome');
    }

    public function list(){
        $users = User::orderBy('score', 'desc')->get();
        return view('list',['users' => $users]);
    }

    public function user($id){
        $user = User::find($id);
        $matches = Match::where('first_user_id' , $id)->orWhere('second_user_id', $id)->with(['first_user', 'second_user'])->get();
        return view('user',['user' => $user, 'matches' => $matches]);
    }


    public function addUsers(){
        $handle = fopen('http://localhost/fifa/public/fifaplayers.csv', 'r');
        $header = 0;

        while ($csvLine = fgetcsv($handle, 1000, ",")) {

            if ($header < 1) {
                $header += 1;
            } else {
                if($csvLine[0] == '')break;
                User::create([
                    'name' => $csvLine[0],
                    'games_played' => 0,
                    'goals_scored' => 0,
                    'goals_conceded' => 0,
                    'win' => 0,
                    'lost' => 0,
                    'draw' => 0,
                    'points' => 0,
                    'score' => 40,
                    'min_score' =>40,
                    'max_score' => 0,
                    'remember_token' => '',

                ]);
            }
        }
        exit();
    }




}

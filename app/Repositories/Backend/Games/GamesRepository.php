<?php

namespace App\Repositories\Backend\Games;

use App\Exceptions\GeneralException;
use App\Models\Games\Game;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class GamesRepository.
 */
class GamesRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Game::class;

    public function __construct()
    {
       
    }

    /**
     * @param array $input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return array
     */
    public function makeMove(array $input)
    {
        
        $gameId    = $input['game_id'];
        $userId    = $input['user_id'];
        $xPosition = $input['pos_x'];
        $yPosition = $input['pos_y'];

        $totalMoves = Game::where('id',$gameId)->count();

        if($totalMoves >= 9)
        {
            throw new GeneralException('Game is finished');
        }

        DB::transaction(function () use ($input) {

            $move = Game::create($input);
            $user = User::where('id',$input['user_id'])->first();

            //check is winner
            $winResult = $this->calculateWin($input['game_id'], $input['user_id']);
            if($winResult)
            {
                return [
                    'id'       => $input['game_id'],
                    'username' => $user->first_name.' '.$user->last_name,
                    'status'   => 'You Win'
                ];
            }
            
            //check is game over
            $totalMoves = Game::where('id',$gameId)->count();
            if($totalMoves >= 9)
            {
                return [
                    'id'       => $input['game_id'],
                    'username' => $user->first_name.' '.$user->last_name,
                    'status'   => 'Game Draw'
                ];
            }

            //default return
            return [
                'id'       => $input['game_id'],
                'username' => $user->first_name.' '.$user->last_name,
                'status'   => 'Your step recorded'
            ];
            

            throw new GeneralException('Some error occure please try again');
        });
    }


    /**
     * @param  $gameId, $userId
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function calculateWin($gameId, $userId)
    {

        // check horizontal
        $horizontalOne = Game::where('game_id',$gameId)->where('user_id',$userId)->where('x_position',1)->count();
        $horizontalTwo = Game::where('game_id',$gameId)->where('user_id',$userId)->where('x_position',2)->count();
        $horizontalThree = Game::where('game_id',$gameId)->where('user_id',$userId)->where('x_position',3)->count(); 

        // check vertical
        $verticalOne = Game::where('game_id',$gameId)->where('user_id',$userId)->where('y_position',1)->count();
        $verticalTwo = Game::where('game_id',$gameId)->where('user_id',$userId)->where('y_position',2)->count();
        $verticalThree = Game::where('game_id',$gameId)->where('user_id',$userId)->where('y_position',3)->count();

        // check diagonal
        $position_1_1 = Game::where('game_id',$gameId)->where('user_id',$userId)->where('x_position',1)->where('y_position',1)->count();

        $position_2_2 = Game::where('game_id',$gameId)->where('user_id',$userId)->where('x_position',2)->where('y_position',2)->count();

        $position_3_3 = Game::where('game_id',$gameId)->where('user_id',$userId)->where('x_position',3)->where('y_position',3)->count();

        $position_1_3 = Game::where('game_id',$gameId)->where('user_id',$userId)->where('x_position',1)->where('y_position',3)->count();

        $position_3_1 = Game::where('game_id',$gameId)->where('user_id',$userId)->where('x_position',3)->where('y_position',1)->count();

        $diagon1 = $position_1_1 + $position_2_2 + $position_3_3;
        $diagon2 = $position_1_3 + $position_2_2 + $position_3_1;


        if($horizontalOne == 3 || $horizontalTw0 == 3 || $horizontalThree==3 || $verticalOne==3 || $verticalTwo==3 || $verticalThree==3 || $diagon1==3 || $diagon2==3)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

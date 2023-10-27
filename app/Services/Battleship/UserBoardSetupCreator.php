<?php

namespace App\Services\Battleship;

use App\Http\Requests\SetupGameRequest;
use App\Models\GameBoard;
use App\Exceptions\RuntimeException;

class UserBoardSetupCreator
{
    const FREE_SPOT = 'O';
    const SHIP_SPOT = 'X';

    public function setupBoard(SetupGameRequest $request, GameBoard $game_board): GameBoard
    {
        $matrix = $this->createMatrix();

        if ($game_board->board_data) {
            throw new RuntimeException('Board is already setup');
        }

        foreach ($request->ships as $ship) {

            $ship_size = count($ship['position']);

            foreach ($ship['position'] as $position) {
                if ($this->checkShipCollision($matrix, $position, $ship_size)) {
                    throw new RuntimeException('Ship Collision detected');
                }
                $matrix[$position['row']][$position['column']] = self::SHIP_SPOT;
            }
        }

        $game_board->board_data = $matrix;

        $game_board->save();

        return $game_board;
    }

    private function createMatrix(): array
    {
        $matrix = [];

        for ($row = 1; $row <= 10; $row++) {
            for ($col = 1; $col <= 10; $col++) {
                $matrix[$row][$col] = self::FREE_SPOT;
            }
        }

        return $matrix;
    }

    private function checkShipCollision($matrix, $position, $ship_size): bool
    {
        $row = $position['row'];
        $col = $position['column'];

        if ($matrix[$row][$col] === self::SHIP_SPOT) {
            return true;
        }

        for ($i = 0; $i < $ship_size; $i++) {
            if (isset($matrix[$row][$col + $i]) && $matrix[$row][$col + $i] === self::SHIP_SPOT) {
                return true;
            }
        }

        for ($i = 0; $i < $ship_size; $i++) {
            if (isset($matrix[$row + $i][$col]) && $matrix[$row + $i][$col] === self::SHIP_SPOT) {
                return true;
            }
        }

        return false;
    }
}
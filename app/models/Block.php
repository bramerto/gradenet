<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $table = 'block';
    public $timestamps = false;
    protected $fillable = [
        'period',
        'schoolyearId',
        'date_start',
        'date_end'
    ];

    /*--------------------GRADENET METHODS------------------------*/

    public static function getAllBlocksInArray()
    {
        $blocks = Block::join('schoolyear', 'block.schoolyearId', '=', 'schoolyear.id')
                                    ->select('block.id AS blockId', 'block.period', 'schoolyear.year AS schoolYear')
                                    ->get();

        $blockarray = [];

        foreach($blocks as $block) {

            $blockarray += [
                $block->blockId => 'Periode: '. $block->period . ' - ' . $block->schoolYear
            ];
        }

        return $blockarray;
    }
}
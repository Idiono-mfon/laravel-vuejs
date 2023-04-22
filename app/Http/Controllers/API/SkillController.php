<?php

namespace App\Http\Controllers\API;

use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkillController extends Controller
{
    public function get_all_skill(Request $request) {
        $skills = Skill::with('service')->orderBy('id', 'DESC')->get();

        return response()->json(array('skills' => $skills), 200);
    }
}

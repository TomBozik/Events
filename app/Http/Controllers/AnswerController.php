<?php

namespace App\Http\Controllers;

use App\Services\AnswerService;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    protected $answerService;

    public function __construct(AnswerService $answerService)
    {
        $this->answerService = $answerService;
    }

    public function store(Request $request)
    {
        $personCode = $request->cookie('personCode');
        $data = request()->validate([
            'from' => ['required'],
            'to' => ['required'],
        ]);

        $isOverlapping = $this->answerService->createAnswer($data, $personCode);

        if ($isOverlapping) {
            abort(response()->json(['error' => 'Your dates are overlapping!'], 400));
        }
        return response()->json(['data' => 'CREATED']);
    }

    public function deleteAnswer(Request $request, $id)
    {
        $personCode = $request->cookie('personCode');
        $this->answerService->deleteAnswer($id, $personCode);
        return response()->json(['data' => 'OK']);
    }

}

<?php

namespace OperationGpt\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use OperationGpt\Services\OpenAIService;
use OperationGpt\Services\OperationParser;
use OperationGpt\Services\OperationExecutor;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Show the chat interface.
     */
    public function index()
    {
        return view('operation-gpt::chat');
    }

    /**
     * Handle the chat request.
     */
    public function chat(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            $message = $request->input('message');

            // 1. Get AI Response
            $openAIService = new OpenAIService();
            $aiResponse = $openAIService->sendMessage($message);

            // 2. Parse AI Response
            $parser = new OperationParser();
            $parsed = $parser->parse($aiResponse);

            if (isset($parsed['type']) && $parsed['type'] === 'error') {
                return response()->json($parsed, 422);
            }

            // 3. Execute Operations
            $executor = new OperationExecutor();
            $result = $executor->execute($parsed);

            return response()->json($result);

        } catch (\Throwable $e) {
            Log::error('OperationGpt Controller Error: ' . $e->getMessage());
            
            return response()->json([
                'type' => 'error',
                'message' => 'حدث خطأ غير متوقع: ' . $e->getMessage()
            ], 500);
        }
    }
}
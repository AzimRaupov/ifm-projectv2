<?php

namespace App\Helpers;

use App\Models\Course;
use App\Models\StudentCourse;
use Illuminate\Support\Facades\Log;
use Orhanerday\OpenAi\OpenAi;

class GlobalMethods
{
    static public function course_cm($course_id,$user_id)
    {
        $student_course=StudentCourse::query()->where('course_id',$course_id)
            ->where('user_id',$user_id)->first();
        $course=Course::find($course_id);

        if($course->step==$student_course->complete){
            $student_course->status=1;
            $student_course->save();
        }

    }

    static public function gpt($promt,$max_token=5000,$role="system",$cont="Ты обучающая платформа.Создай дарожную карту")
    {
        // Log the start of the GPT request.
        Log::info('Starting GPT request.', ['prompt' => $promt]);

        $open_ai_key = env('OPENAI_API_KEY');
        if (!$open_ai_key) {
            // Log an error if the API key is missing.
            Log::error('OPENAI_API_KEY not found in environment variables.');
            return null; // Or handle the error as needed.
        }

        try {
            $open_ai = new OpenAi($open_ai_key);

            $chat = $open_ai->chat([
                'model' => 'gpt-4o',
                'messages' => [
                    [
                        "role" => $role,
                        "content" => $cont
                    ],
                    ['role' => 'user', 'content' => $promt],
                ],
                'temperature' => 1.0,
                'max_tokens' => $max_token,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ]);
            // Log the raw response from the API.
            Log::info('Received raw response from OpenAI.', ['response' => $chat]);

            $text = json_decode($chat, true)['choices'][0]['message']['content'];
            $clean = str_replace(['```json', '```'], '', $text);
            $decoded = json_decode($clean, true);

            // Check for JSON decoding errors on the first attempt.
            if (json_last_error() === JSON_ERROR_NONE && isset($decoded['map'])) {
                // Log successful JSON parsing.
                Log::info('Successfully decoded JSON from GPT response.');
                return $decoded;
            }

            // Log the initial failure to decode JSON.
            Log::warning('Failed to decode JSON on first attempt. Trying to fix.', ['raw_text' => $text, 'error' => json_last_error_msg()]);

            // Attempt to fix JSON errors by removing trailing commas.
            $clean = preg_replace('/,\s*}/', '}', $clean);
            $clean = preg_replace('/,\s*]/', ']', $clean);

            $decoded = json_decode($clean, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                // Log successful fix and decoding.
                Log::info('Successfully fixed and decoded JSON.');
            } else {
                // Log the final failure to decode JSON after the fix attempt.
                Log::error('Failed to decode JSON even after fix.', ['cleaned_text' => $clean, 'error' => json_last_error_msg()]);
            }

            return $decoded;

        } catch (\Exception $e) {
            // Log any exceptions that occur during the process.
            Log::error('An exception occurred during GPT request.', ['error' => $e->getMessage()]);
            return null; // Or handle the error as appropriate for your application.
        }
    }
}

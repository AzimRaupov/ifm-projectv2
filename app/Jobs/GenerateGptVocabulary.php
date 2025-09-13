<?php

namespace App\Jobs;

use App\Helpers\GlobalMethods;
use App\Models\Link;
use App\Models\Step;
use App\Models\VocabularyStep;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateGptVocabulary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, \Illuminate\Bus\Queueable, SerializesModels;

    protected $step_id;
    public function __construct($step_id)
    {
        $this->step_id=$step_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Получаем шаг с курсом
        $step = Step::with('course')->find($this->step_id);
        if (!$step || !$step->course) {
            Log::error("Step or course not found for step_id: {$this->step_id}");
            return;
        }

        // Формируем prompt для GPT
        $prompt = "I am studying \"$step->course->topic\" in the step \"$step->title\". Break the step into several sub-steps without unnecessary information.

### Requirements for the sub-steps:
1. A title for each sub-step.
2. Pesponse in Rssia Lang.
2. Detailed information with examples and explanations in HTML format — **only the content inside the <body> tag**.
3. The number of sub-steps should depend on the complexity of the step.
4. Multiple links for further studying of each sub-step.
5. The experience from reading each sub-step should be rated based on the complexity of the content, with a maximum of 10 experience points for each sub-step.

### Response format (JSON):
Please respond **only** with a valid JSON array. Each item in the array should be a JSON object with the following structure:

```json
[
    {
        \"title\": \"Sub-step 1\",
        \"exp\": 3,
        \"info\": \"<p>This is detailed information for sub-step 1.</p>\",
        \"links\": [
            \"https://example.com/1\",
            \"https://example.com/2\"
        ]
    },
    {
        \"title\": \"Sub-step 2\",
        \"exp\": 5,
        \"info\": \"<p>This is detailed information for sub-step 2.</p>\",
        \"links\": [
            \"https://example.com/3\",
            \"https://example.com/4\"
        ]
    }
]";

        // Получаем ответ от GPT
        $decoded = GlobalMethods::gpt($prompt,9000);

        if ($decoded === null) {
            Log::error("Failed to get valid response from GPT for step_id: {$this->step_id}");
            return;
        }

        // Инициализация массива для ссылок
        $linksToInsert = [];

        foreach ($decoded as $item) {
            $vocabulary = VocabularyStep::create([
                'step_id' => $step->id,
                'course_id' => $step->course_id,
                'title' => $item['title'] ?? 'Без названия',
                'text' => $item['info'] ?? '',
                'exp' => $item['exp']
            ]);

            // Увеличиваем опыт на уровне курса
            $step->course->increment('ex', $item['exp']);

            if (!empty($item['links']) && is_array($item['links'])) {
                foreach ($item['links'] as $link) {
                    $linksToInsert[] = [
                        'vocabulary_step_id' => $vocabulary->id,
                        'link' => $link,
                        'step_id' => null,  // Это поле выглядит подозрительным, возможно, его стоит изменить на step_id
                    ];
                }
            }
        }

        // Вставляем ссылки в базу, если они есть
        if (!empty($linksToInsert)) {
            Link::insert($linksToInsert);
        }

        // Загружаем связанные данные
        $step->load('vocabularies.links');

        Log::info("Vocabulary successfully generated for step_id: {$step->id}");
    }

}

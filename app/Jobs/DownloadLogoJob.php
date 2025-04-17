<?php

namespace App\Jobs;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DownloadLogoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.

     */

    public function handle(): void
    {
        $course = Course::find($this->data->id);

        if (!$course) {
            Log::warning("Course with ID {$this->data->id} not found.");
            return;
        }

        // Создаём поисковый URL
        $query = urlencode($course->topic . ' иконка');
        $url = "https://www.google.com/search?tbm=isch&q={$query}";

        // Отправляем HTTP-запрос
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', // маскируемся под браузер
            'Accept-Language' => 'en-US,en;q=0.9',
        ])->get($url);

        if (!$response->successful()) {
            Log::error("Failed to fetch Google Images HTML for course ID {$course->id}");
            return;
        }

        // Парсим HTML
        $html = $response->body();
        libxml_use_internal_errors(true); // подавить предупреждения DOM
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        libxml_clear_errors();

        // Извлекаем изображения
        $images = [];
        $tags = $dom->getElementsByTagName('img');
        foreach ($tags as $index => $tag) {
            $src = $tag->getAttribute('src');
            if ($index === 0) continue; // пропускаем логотип Google
            if (filter_var($src, FILTER_VALIDATE_URL)) {
                $images[] = $src;
            }
            if (count($images) >= 1) break; // берём только первую нормальную ссылку
        }

        if (count($images) > 0) {
            $course->logo = $images[0];
            $course->save();
            Log::info("Logo parsed and updated for course ID {$course->id}");
        } else {
            Log::error("No image found while parsing for course ID {$course->id}");
        }
    }

}

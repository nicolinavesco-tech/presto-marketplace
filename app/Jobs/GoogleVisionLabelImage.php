<?php

namespace App\Jobs;

use App\Models\Image;
use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\BatchAnnotateImagesRequest;
use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\Image as VisionImage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GoogleVisionLabelImage implements ShouldQueue
{
    use Queueable;

    private $article_image_id;

    public function __construct($article_image_id)
    {
        $this->article_image_id = $article_image_id;
    }

    public function handle(): void
    {
        $i = Image::find($this->article_image_id);
        if (!$i) return;

        // 1) Recupera bytes immagine (locale o URL)
        $content = $this->getImageBytes($i->path);
        if ($content === null) return;

        // 2) Crea client Google Vision usando ENV JSON (Render-friendly)
        $credentials = json_decode(env('GOOGLE_CREDENTIALS_JSON', ''), true);
        if (empty($credentials)) {
            throw new \Exception('GOOGLE_CREDENTIALS_JSON mancante o non valido');
        }

        $googleVisionClient = new ImageAnnotatorClient([
            'credentials' => $credentials,
        ]);

        $google_image = new VisionImage([
            'content' => $content,
        ]);

        $googleFeature = new Feature();
        $googleFeature->setType(Type::LABEL_DETECTION);

        $request = new AnnotateImageRequest();
        $request->setImage($google_image);
        $request->setFeatures([$googleFeature]);

        $batchRequest = new BatchAnnotateImagesRequest();
        $batchRequest->setRequests([$request]);

        $responseBatch = $googleVisionClient->batchAnnotateImages($batchRequest);
        $response = $responseBatch->getResponses()[0];

        $labels = $response->getLabelAnnotations();

        if ($labels) {
            $result = [];
            foreach ($labels as $label) {
                $result[] = $label->getDescription();
            }

            $i->labels = $result;
            $i->save();
        }

        $googleVisionClient->close();
    }

    private function getImageBytes(string $path): ?string
    {
        // Se è URL (Cloudinary)
        if (preg_match('#^https?://#', $path)) {
            $data = @file_get_contents($path);
            return $data !== false ? $data : null;
        }

        // Locale (storage/app/public/...)
        $full = storage_path('app/public/' . $path);
        if (!file_exists($full)) return null;

        $data = @file_get_contents($full);
        return $data !== false ? $data : null;
    }
}

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

class GoogleVisionSafeSearch implements ShouldQueue
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
        $googleFeature->setType(Type::SAFE_SEARCH_DETECTION);

        $request = new AnnotateImageRequest();
        $request->setImage($google_image);
        $request->setFeatures([$googleFeature]);

        $batchRequest = new BatchAnnotateImagesRequest();
        $batchRequest->setRequests([$request]);

        $responseBatch = $googleVisionClient->batchAnnotateImages($batchRequest);
        $responses = $responseBatch->getResponses();
        $googleVisionClient->close();

        $safeSearch = $responses[0]->getSafeSearchAnnotation();

        $adult = $safeSearch->getAdult();
        $spoof = $safeSearch->getSpoof();
        $medical = $safeSearch->getMedical();
        $violence = $safeSearch->getViolence();
        $racy = $safeSearch->getRacy();

        $likeliHoodName = [
            "text-secondary bi bi-circle-fill",
            "text-success bi bi-check-circle-fill",
            "text-success bi bi-check-circle-fill",
            "text-warning bi bi-exclamation-circle-fill",
            "text-warning bi bi-exclamation-circle-fill",
            "text-success bi bi-dash-circle-fill",
        ];

        $i->adult = $likeliHoodName[$adult] ?? $likeliHoodName[0];
        $i->spoof = $likeliHoodName[$spoof] ?? $likeliHoodName[0];
        $i->medical = $likeliHoodName[$medical] ?? $likeliHoodName[0];
        $i->violence = $likeliHoodName[$violence] ?? $likeliHoodName[0];
        $i->racy = $likeliHoodName[$racy] ?? $likeliHoodName[0];

        $i->save();
    }

    private function getImageBytes(string $path): ?string
    {
        if (preg_match('#^https?://#', $path)) {
            $data = @file_get_contents($path);
            return $data !== false ? $data : null;
        }

        $full = storage_path('app/public/' . $path);
        if (!file_exists($full)) return null;

        $data = @file_get_contents($full);
        return $data !== false ? $data : null;
    }
}

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
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Image as SpatieImage;

class RemoveFaces implements ShouldQueue
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

        // ⚠️ Questo job lavora SOLO su file locale
        if (preg_match('#^https?://#', $i->path)) {
            return;
        }

        $src = storage_path('app/public/' . $i->path);
        if (!file_exists($src)) return;

        $bytes = file_get_contents($src);

        // ✅ Credenziali da ENV (Render-friendly)
        $credentials = json_decode(env('GOOGLE_CREDENTIALS_JSON', ''), true);
        if (empty($credentials)) {
            throw new \Exception('GOOGLE_CREDENTIALS_JSON mancante o non valido');
        }

        $googleVisionClient = new ImageAnnotatorClient([
            'credentials' => $credentials,
        ]);

        $google_image = new VisionImage(['content' => $bytes]);

        $googleFeature = new Feature();
        $googleFeature->setType(Type::FACE_DETECTION);

        $request = new AnnotateImageRequest();
        $request->setImage($google_image);
        $request->setFeatures([$googleFeature]);

        $batchRequest = new BatchAnnotateImagesRequest();
        $batchRequest->setRequests([$request]);

        $responseBatch = $googleVisionClient->batchAnnotateImages($batchRequest);
        $response = $responseBatch->getResponses()[0];
        $faces = $response->getFaceAnnotations();

        foreach ($faces as $face) {
            $vertices = $face->getBoundingPoly()->getVertices();
            $bounds = [];
            foreach ($vertices as $vertex) {
                $bounds[] = [$vertex->getX(), $vertex->getY()];
            }

            $w = $bounds[2][0] - $bounds[0][0];
            $h = $bounds[2][1] - $bounds[0][1];

            $img = SpatieImage::load($src);

            $img->watermark(
                base_path('resources/img/face.jpg'),
                AlignPosition::TopLeft,
                paddingX: $bounds[0][0],
                paddingY: $bounds[0][1],
                width: $w,
                height: $h,
                fit: Fit::Stretch
            );

            $img->save($src);
        }

        $googleVisionClient->close();
    }
}
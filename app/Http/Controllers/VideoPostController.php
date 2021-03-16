<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Validator;

use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;

use App\VideoPost;
use App\Http\Resources\AudioPostCollection;
use App\Traits\Interactable;
use App\VideoSrc;

class VideoPostController extends Controller
{
    use Interactable;
    public $shouldTransrcibe = false;

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|max:255',
            // 'src_url' => 'string|required|max:255',
            'full_text' => 'nullable|string',
            'description' => 'nullable|string|max:255',
            'author_id' => 'nullable|integer|exists:users,id',
            'church_id' => 'nullable|integer|exists:churches,id',
            'size' => 'nullable|integer',
            'length' => 'nullable|integer',
            'language' => 'nullable|string',
            'address_id' => 'nullable|integer|exists:addresses,id',
            'video' => 'required',
            'video.*' => 'mimes:mp4,mkv,avi,mov'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $data['uploader_id'] = Auth::user()->id;
        $video  = $request['video'];
        // $videoFile = Storage($video);
        //TODO: parse the video extension from the base64encoded file
        $name = time() . '.mp4';
        $videoPost = VideoPost::create($data);
        $fileMoved = Storage::put('public/video/full' . $name, $video);

        $pp = '/storage/video/full/' . $name;
        $src = VideoSrc::create(['src' => $pp, 'quality' => 1, 'size' => 22333, 'video_post_id' => $videoPost->id,]);

        $interacted = $this->saveRelated($data, $videoPost);
        //obtain length,size and details of audio
        $result = $this->getTrackDetails($videoPost);
        $result = $this->getTrackFullText($result);

        if ($result) {
            return response()->json(['data' => true], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }

    public function getTrackDetails(VideoPost $video): VideoPost
    {
        //here use libmp3 to get track details and update it
        //then return the object back
        return $video;
    }

    public function related(Request $request)
    {
        $audio = VideoPost::find($request['id']);
        //TODO: here use search plugin to list advanced related
        $names = explode(' ', $audio->name);
        $audia = VideoPost::where('name', 'like', $audio->name);
        foreach ($names as $key => $name) {
            $audia->orWhere('name', 'like', "%$name%");
            $audia->orWhere('description', 'like', "%$name%");
        }
        $data = $audia->with('author')
            ->whereNot('audio_posts.id', $audio->id)->paginate();
        return response()->json($data);
    }


    public function getTrackFullText(VideoPost $audio): VideoPost
    {
        if ($this->shouldTransrcibe) {
            //connect to google
            $content = file_get_contents($audio->src_url);
            $googleAudio = (new RecognitionAudio())->setContent($content);

            # The audio file's encoding, sample rate and language
            $config = new RecognitionConfig([
                'encoding' => AudioEncoding::LINEAR16,
                'sample_rate_hertz' => 32000,
                'language_code' => 'en-US'
            ]);

            # Instantiates a client
            $client = new SpeechClient();
            # Detects speech in the audio file
            $response = $client->recognize($config, $googleAudio);
            # Print most likely transcription
            foreach ($response->getResults() as $result) {
                $alternatives = $result->getAlternatives();
                $mostLikely = $alternatives[0];
                $transcript = $mostLikely->getTranscript();
                printf('Transcript: %s' . PHP_EOL, $transcript);
            }
            $client->close();
            //change audio to text
            //save it then return object
        }
        return $audio;
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'integer|required|exists:audio_posts,id',
            'name' => 'string|required|max:255',
            // 'src_url' => 'string|required|max:255',
            'full_text' => 'nullable|string',
            'description' => 'nullable|string|max:255',
            'author_id' => 'nullable|integer|exists:users,id',
            'church_id' => 'nullable|integer|exists:churches,id',
            'size' => 'nullable|integer',
            'length' => 'nullable|integer',
            'language' => 'nullable|string',
            'address_id' => 'nullable|integer|exists:addresses,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $data['user_id'] = Auth::user()->id;
        $id = $request->route('id');
        $result = VideoPost::find($id);
        //update result
        $result = $this->getTrackDetails($result);
        $result = $this->getTrackFullText($result);
        $result = $result->update($data);


        if ($result) {
            return response()->json(['data' => true], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }

    public function get(Request $request)
    {
        $id = (int)$request->route('id');
        $userId = Auth::user()->id;
        if ($audio = VideoPost::with(['srcs', 'comments', 'images', 'author', 'user', 'churches', 'addresses'])
            ->withCount([
                'comments',
                'likes',
                'likes as liked' => function (Builder $query) use ($userId) {
                    $query->where('user_id', $userId);
                },
                'views',
                'views as viewed' => function (Builder $query) use ($userId) {
                    $query->where('user_id', $userId);
                },
            ])
            ->find($id)
        ) {
            return response()->json([
                'data' => $audio
            ], 200);
        } else {
            return response()->json([
                'data' => false
            ], 404);
        }
    }

    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'q' => 'nullable|string|min:3'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $userId = Auth::id();

        $query = $request['q'];
        $audia = VideoPost::with(['images', 'author', 'user'])
            ->withCount([
                'comments',
                'likes',
                'likes as liked' => function (Builder $query) use ($userId) {
                    $query->where('user_id', $userId);
                },
                'views',
                'views as viewed' => function (Builder $query) use ($userId) {
                    $query->where('user_id', $userId);
                },
            ]);
        if ($query) {
            $audia = $audia->search($query);
        }
        //here insert search parameters and stuff
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
        $audia = $audia->paginate($length);
        $data = new AudioPostCollection($audia);
        return response()->json($data);
    }


    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($audio = VideoPost::find($id)) {
            $audio->delete();
            return response()->json([
                'data' => true
            ], 200);
        } else {
            return response()->json([
                'data' => false
            ], 404);
        }
    }
}

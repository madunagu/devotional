<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Validator;

use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;

use App\AudioPost;
use App\Traits\Interactable;
use App\Http\Resources\AudioPostCollection;
use wapmorgan\Mp3Info\Mp3Info;

class AudioPostController extends Controller
{
    use Interactable;

    public $shouldTransrcibe = false;

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|max:255',
            'src_url' => 'string|required|max:255',
            'full_text' => 'nullable|string',
            'description' => 'nullable|string|max:255',
            'author_id' => 'nullable|integer|exists:users,id',
            'church_id' => 'nullable|integer|exists:churches,id',
            'profile_media_id' => 'nullable|integer|exists:profile_media,id',
            'size' => 'nullable|integer',
            'length' => 'nullable|integer',
            'language' => 'nullable|string',
            'address_id' => 'nullable|integer|exists:addresses,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }


        $data = collect($request->all())->toArray();

        $data['uploader_id'] = Auth::user()->id;
        $audio = AudioPost::create($data);
        $interacted = $this->saveRelated($data, $audio);
        //obtain length,size and details of audio
        $audio = $this->getTrackDetails($audio);
        $audio = $this->getTrackFullText($audio);


        if ($audio) {
            return response()->json(['data' => true], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }

    public function getTrackDetails(AudioPost $audio): AudioPost
    {
        if (!empty($request['audio'])) {
            $audioInfo = new Mp3Info($request['audio']);
            $audio->length = $audioInfo->duration;
            $audio->size = $audioInfo->audioSize;
        }
        return $audio;
    }

    public function getTrackFullText(AudioPost $audio): AudioPost
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
            'src_url' => 'string|required|max:255',
            'full_text' => 'nullable|string',
            'description' => 'nullable|string|max:255',
            'author_id' => 'nullable|integer|exists:users,id',
            'church_id' => 'nullable|integer|exists:churches,id',
            'profile_media_id' => 'nullable|integer|exists:profile_media,id',
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
        $result = AudioPost::find($id);
        $result = $this->getTrackDetails($result);
        $result = $this->getTrackFullText($result);
        //update result
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
        if ($audio = AudioPost::with(['comments', 'images', 'author', 'user', 'churches', 'addresses'])
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
            ])->find($id)
        ) {
            $audio->views()->create([
                'user_id' => $userId,
                'viewable_id' => $id,
                'viewable_type' => 'audio'
            ]);
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

        $query = $request['q'];
        $audia = AudioPost::with('author', 'user');
        if ($query) {
            $audia = $audia->search($query);
        }
        //here insert search parameters and stuff
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
        $audia = $audia->paginate($length);
        $data = new AudioPostCollection($audia);
        return response()->json($data);
    }

    public function related(Request $request)
    {

        $audio = AudioPost::find((int)$request['id']);
        //TODO: here use search plugin to list advanced related
        $names = explode(' ', $audio->name);
        $audia = AudioPost::where('name', 'like', $audio->name);
        foreach ($names as $key => $name) {
            $audia->orWhere('name', 'like', "%$name%");
            $audia->orWhere('description', 'like', "%$name%");
        }
        $data = $audia->with('author')
            ->whereNot('audio_posts.id', $audio->id)->paginate();

            return response()->json($data);
    }


    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($audio = AudioPost::find($id)) {
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

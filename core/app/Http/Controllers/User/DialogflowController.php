<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DialogflowConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DialogflowController extends Controller
{
    public function index()
    {
        $pageTitle = "Dialogflow Integration";
        $user = getParentUser();
        $config = DialogflowConfig::where('user_id', $user->id)->first();
        return view('Template::user.automation.dialogflow', compact('pageTitle', 'config'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'credentials_file' => 'required', // json file
            'status' => 'required|boolean'
        ]);

        $user = getParentUser();

        $config = DialogflowConfig::where('user_id', $user->id)->first();
        if (!$config) {
            $config = new DialogflowConfig();
            $config->user_id = $user->id;
        }

        if ($request->hasFile('credentials_file')) {
            $file = $request->file('credentials_file');
            $extension = $file->getClientOriginalExtension();
            if ($extension != 'json') {
                $notify[] = ['error', 'Only JSON files are allowed for credentials.'];
                return back()->withNotify($notify);
            }

            $jsonContent = file_get_contents($file->getRealPath());
            $credentials = json_decode($jsonContent, true);

            if (!$credentials || !isset($credentials['project_id'])) {
                $notify[] = ['error', 'Invalid JSON credentials file.'];
                return back()->withNotify($notify);
            }

            $config->credentials_json = $jsonContent;
            $config->project_id = $credentials['project_id'];
        }

        $config->status = $request->status;
        $config->save();

        $notify[] = ['success', 'Dialogflow configuration updated successfully.'];
        return back()->withNotify($notify);
    }

    public function delete()
    {
        $user = getParentUser();
        $config = DialogflowConfig::where('user_id', $user->id)->first();

        if ($config) {
            $config->delete();
            $notify[] = ['success', 'Dialogflow configuration removed.'];
        } else {
            $notify[] = ['error', 'Configuration not found.'];
        }

        return back()->withNotify($notify);
    }
}

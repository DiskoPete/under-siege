<?php

namespace App\Http\Controllers\Sieges;

use App\Enums\SiegeStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSiegeRequest;
use App\Jobs\RunSiege;
use App\Models\Siege;
use App\Support\SiegeConfiguration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class CreateController extends Controller
{

    public function __invoke(CreateSiegeRequest $request): RedirectResponse
    {
        $siege                = new Siege();
        $siege->status        = SiegeStatus::Queued;
        $siege->configuration = new SiegeConfiguration($request->validated());
        $siege->uuid          = Str::uuid();
        $siege->save();

        RunSiege::dispatch($siege);

        return response()->redirectToRoute('sieges.details', $siege);
    }
}

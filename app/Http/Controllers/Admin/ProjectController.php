<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projects = Project::all();
        return view("admin.projects.index", compact("projects"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view("admin.projects.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            "title" => "required|string",
            "description" => "required|string",
            "thumb" => "nullable|string",
            "release" => "required|date",
            "language" => "nullable|string",
            "link" => "required|string",
        ]);

        $data["language"] = json_encode([$data["language"]]);

        $project = Project::create($data);

        return redirect()->route("admin.projects.show", $project->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $title): View
    {
        $project = Project::where("title", $title)->first();

        return view("admin.projects.show", compact("project"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $project = Project::findOrFail($id);
        
        return view("admin.projects.edit", compact("project"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $data = $request->validate([
            "title" => "required|string",
            "description" => "required|string",
            "thumb" => "nullable|string",
            "release" => "required|date",
            "language" => "nullable|string",
            "link" => "required|string",
        ]);

        $data["language"] = json_encode([$data["language"]]);

        $project->update($data);

        return redirect()->route("admin.projects.show", $project->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $project = Project::findOrFail($id);

        $project->delete();

        return redirect()->route("admin.projects.index");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Symfony\Component\Mailer\Exception\TransportException;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        //
        $projects = Project::paginate(10);
        return View::make('project.list',['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        //
        return View::make('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        //
        $validated = $request->validate([
            'projectName' => 'required|max:255',
            'projectStart' => 'required',
            'projectEnd' => 'required',
            'projectFile' => 'file|mimes:jpg,png,pdf|max:2048',
        ]);

        $path = $request->file('projectFile')->store('projects');
        $newProject = Project::updateOrCreate([
            'id' => $request->id
        ], [
            'projectName' => $request->projectName,
            'projectStart' => $request->projectStart,
            'projectEnd' => $request->projectEnd,
            'projectDescription' => $request->projectDescription,
            'projectFile' => $request->$path,
        ]);


        return redirect('/project/list');
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Project $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        //

        $projectItem = Project::where('id', $id)->get();

        return View::make('project.edit')->with([
            'project' => $projectItem
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Project $project
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, Project $project)
    {
        $projectToUpdate = $project->find($request->get('id'));
        $this->validate($request, [
            $validated = $request->validate([
                'projectName' => 'required|max:255',
                'projectStart' => 'required',
                'projectEnd' => 'required',
                'projectFile' => 'file|mimes:jpg,png,pdf|max:2048',
            ], $request->all())
        ]);

        $projectToUpdate->update($request->all());

        return redirect('/project/list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(Project $project, $id)
    {
        //
        $project::destroy($id);
        return redirect('/project/list');
    }


    /**
     * Send project via email
     */

    public function send(Project $project, Request $request)
    {
//check file
        $filePathFromDatabase = Project::where('id', $request->get('projectId'))->value('projectFile');

// Check if the file exists


        $email = $request->get('projectEmail');
        $projectToSend = $project->find($request->get('projectId'));

        $html = '<h1>' . $projectToSend->projectName . '</h1>';
        $html .= '<p>początek:' . $projectToSend->projectStart . '</p>';
        $html .= '<p>koniec:' . $projectToSend->projectEnd . '</p>';
        $html .= '<p>opis:' . $projectToSend->projectDescription . '</p>';

        try {
            $mailable = new Mailable();

            $mailable
                ->from('hello@example.com')
                ->to($email)
                ->subject('test subject')
                ->html($html);
            if ($filePathFromDatabase && Storage::exists($filePathFromDatabase)) {
                // The file exists
                $mailable ->attach(Storage::path($filePathFromDatabase));
            }
            $result = Mail::send($mailable);
        } catch (TransportException $exception) {
            var_dump($exception);
        }

        return Response::json(array(
            'success' => true,
            'data' => 'udało się',
        ));
    }

    public function filter(Request $request)
    {


        $projectName = $request->input('projectName');
        $projectStartFrom = $request->input('startDateFrom');
        $projectStartTo = $request->input('startDateTo');
        $projectEndFrom = $request->input('endDateFrom');
        $projectEndTo = $request->input('endDateTo');


        $projects = Project::query()
            ->when($projectName, function ($query) use ($projectName) {
                $query->where('projectName', 'like', "%$projectName%");
            })
            ->when($projectStartFrom, function ($query) use ($projectStartFrom) {
                $query->where('projectStart', '>=', $projectStartFrom);
            })
            ->when($projectStartTo, function ($query) use ($projectStartTo) {
                $query->where('projectStart', '<=', $projectStartTo);
            })
            ->when($projectEndFrom, function ($query) use ($projectEndFrom) {
                $query->where('projectEnd', '>=', $projectEndFrom);
            })
            ->when($projectEndTo, function ($query) use ($projectEndTo) {
                $query->where('projectEnd', '<=', $projectEndTo);
            })
            ->paginate(10);


        // Return the filtered data to a view or perform further actions
        return view('project.list', ['projects' => $projects, 'queryString' => request()->getQueryString()]);
    }


}

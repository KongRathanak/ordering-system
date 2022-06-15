<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Prologue\Alerts\Facades\Alert;
use Backpack\LogManager\app\Classes\LogViewer;

class LogController extends Controller
{
    /**
     * Lists all log files.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->data['files'] = LogViewer::getFiles(true, true);
        $this->data['title'] = trans('backpack::logmanager.log_manager');

        return view('logs', $this->data);
    }

    /**
     * Previews a log file.
     *
     * @throws \Exception
     */
    public function preview($file_name)
    {
        LogViewer::setFile(decrypt($file_name));

        $logs = LogViewer::all();

        if (count($logs) <= 0) {
            abort(404, trans('backpack::logmanager.log_file_doesnt_exist'));
        }

        $this->data['logs'] = $logs;
        $this->data['title'] = trans('backpack::logmanager.preview').' '.trans('backpack::logmanager.logs');
        $this->data['file_name'] = decrypt($file_name);

        return view('log_item', $this->data);
    }

    /**
     * Downloads a log file.
     *
     * @param $file_name
     *
     * @throws \Exception
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($file_name)
    {
        return response()->download(LogViewer::pathToLogFile(decrypt($file_name)));
    }

    /**
     * Deletes a log file.
     *
     * @param $file_name
     *
     * @throws \Exception
     *
     * @return string
     */
    public function delete($file_name)
    {
        if (!config('backpack.logmanager.allow_delete')) {
            abort(403);
        }

        if (app('files')->delete(LogViewer::pathToLogFile(decrypt($file_name)))) {
            return 'success';
        }

        abort(404, trans('backpack::logmanager.log_file_doesnt_exist'));
    }
    public function deleteAll()
    {
        collect(LogViewer::getFiles(true, true))->each(function($v) {
            $deleted = app('files')->delete(LogViewer::pathToLogFile($v['file_name']));
            if (!$deleted) {
                Alert::error(trans('Something Went Wrong'))->flash();
                return redirect()->back();
            }
        });
        Alert::success(trans('Message Deleted All'))->flash();
        return redirect()->back();
    }
}

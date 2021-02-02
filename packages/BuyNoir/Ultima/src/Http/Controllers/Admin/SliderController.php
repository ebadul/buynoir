<?php

namespace BuyNoir\Ultima\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Webkul\Core\Repositories\SliderRepository;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SliderController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Locale
     */
    protected $locale;

    /**
     * Channel
     */
    protected $channel;

    public $ultimaMetadataRepository;

    /**
     * Create a new controller instance.
     * 
     * @param  \Webkul\Core\Repositories\SliderRepository  $sliderRepository
     * @return void
     */
    public function __construct
    (
        SliderRepository $sliderRepository
    ) {
        $this->middleware('admin');

        $this->_config = request('_config');

        $this->sliderRepository = $sliderRepository;
    }
    
    /**
     * Loads the index for the sliders settings.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    /**
     * Loads the form for creating slider.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $channels = core()->getAllChannels();

        $locale = request()->get('locale') ?: core()->getCurrentLocale();
        
        return view($this->_config['view'])->with("locale", $locale);
    }

    /**
     * Creates the new sider item.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'title'      => 'string|required',
            'channel_id' => 'required',
            'image.*'    => 'required|mimes:jpeg,bmp,png,jpg',
        ]);

        $result = $this->sliderRepository->save(request()->all());

        if ($result) {
            session()->flash('success', trans('admin::app.settings.sliders.created-success'));
        } else {
            session()->flash('success', trans('admin::app.settings.sliders.created-fail'));
        }

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Edit the previously created slider item.
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $slider = $this->sliderRepository->findOrFail($id);

        return view($this->_config['view'])->with('slider', $slider);
    }

    /**
     * Edit the previously created slider item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
            'title'      => 'string|required',
            'channel_id' => 'required',
            'image.*'    => 'sometimes|mimes:jpeg,bmp,png,jpg',
        ]);

        if ( is_null(request()->image)) {
            session()->flash('error', trans('admin::app.settings.sliders.update-fail'));
            
            return redirect()->back();
        }

        $result = $this->sliderRepository->updateItem(request()->all(), $id);

        if ($result) {
            session()->flash('success', trans('admin::app.settings.sliders.update-success'));
        } else {
            session()->flash('error', trans('admin::app.settings.sliders.update-fail'));
        }

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Delete a slider item and preserve the last one from deleting
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = $this->sliderRepository->findOrFail($id);

        try {
            $this->sliderRepository->delete($id);

            session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Slider']));

            return response()->json(['message' => true], 200);
        } catch(\Exception $e) {
            session()->flash('error', trans('admin::app.response.delete-failed', ['name' => 'Slider']));
        }

        return response()->json(['message' => false], 400);
    }
}
?>
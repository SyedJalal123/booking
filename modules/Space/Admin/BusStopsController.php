<?php


    namespace Modules\Space\Admin;


    use Auth;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Validation\Rule;
    use Modules\AdminController;
    use Modules\Space\Models\BusStops;
    use Modules\Space\Models\Bus;
    use Modules\Space\Models\BusSeatType;
    use Modules\Location\Models\Location;

    class BusStopsController extends AdminController
    {
        /**
         * @var string
         */
        private $airport;
        /**
         * @var string
         */
        private $location;

        /**
         * @var string
         */

        public function __construct()
        {
            parent::__construct();
            $this->setActiveMenu(route('space.admin.index'));
            $this->location = Location::class;
            $this->airport = BusStops::class;
        }

        public function callAction($method, $parameters)
        {
            if (!Bus::isEnable()) {
                return redirect('/');
            }
            return parent::callAction($method, $parameters); // TODO: Change the autogenerated stub
        }

        public function index(Request $request)
        {
            $this->checkPermission('space_view');
            $query = $this->airport::query();
            $query->orderBy('id', 'desc');

            if (!empty($flight_name = $request->input('s'))) {
                $query->where('name', 'LIKE', '%'.$flight_name.'%');
            }
            if ($this->hasPermission('space_manage_others')) {
                if (!empty($author = $request->input('vendor_id'))) {
                    $query->where('create_user', $author);
                }
            } else {
                $query->where('create_user', Auth::id());
            }
            $data = [
                'rows'                 => $query->with(['author'])->paginate(20),
                'row'                  => new $this->airport,
                'locations'   => $this->location::get()->toTree(),
                'space_manage_others' => $this->hasPermission('space_manage_others'),
                'breadcrumbs'          => [
                    [
                        'name' => __('Bus Services'),
                        'url'  => route('space.admin.bus_stops.index')
                    ],
                    [
                        'name'  => __('All'),
                        'class' => 'active'
                    ],
                ],
                'page_title'           => __("Bus Services Management")
            ];
            return view('Space::admin.bus_stops.index', $data);
        }

        public function edit(Request $request, $id)
        {
            $this->checkPermission('space_update');
            $row = $this->airport::find($id);
            if (empty($row)) {
                return redirect(route('space.admin.bus_stops.index'));
            }
            if (!$this->hasPermission('space_manage_others')) {
                if ($row->create_user != Auth::id()) {
                    return redirect(route('space.admin.index'));
                }
            }
            $data = [
                'row'         => $row,
                'locations'   => $this->location::get()->toTree(),
                'breadcrumbs' => [
                    [
                        'name' => __('Bus Services'),
                        'url'  => route('space.admin.bus_stops.index')
                    ],
                    [
                        'name'  => __('Edit Bus Service'),
                        'class' => 'active'
                    ],
                ],
                'page_title'  => __("Edit: :name", ['name' => $row->code])
            ];
            return view('Space::admin.bus_stops.detail', $data);
        }

        public function store(Request $request, $id)
        {

            if ($id > 0) {
                $this->checkPermission('space_update');
                $row = $this->airport::find($id);
                if (empty($row)) {
                    return redirect(route('space.admin.bus_stops.index'));
                }

                if ($row->create_user != Auth::id() and !$this->hasPermission('space_manage_others')) {
                    return redirect(route('space.admin.bus_stops.index'));
                }
            } else {
                $this->checkPermission('space_create');
                $row = new $this->airport();
            }
            $validator = Validator::make($request->all(), [
                'name'=>'required',
                'code'=>[
                    'required',
                    Rule::unique('bravo_bus_seat_types')->ignore($row),
                ]
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with(['errors' => $validator->errors()]);
            }
            $dataKeys = [
                'name',
                'code',
                'location_id',
                'description',
                'address',
                'map_lat',
                'map_lng',
                'map_zoom'
            ];
            if ($this->hasPermission('space_manage_others')) {
                $dataKeys[] = 'create_user';
            }
            $row->fillByAttr($dataKeys, $request->input());
            $res = $row->save();
            if ($res) {
                return redirect(route('space.admin.bus_stops.edit', $row))->with('success', __('Bus Stop saved'));
            }
        }


        public function bulkEdit(Request $request)
        {

            $ids = $request->input('ids');
            $action = $request->input('action');
            if (empty($ids) or !is_array($ids)) {
                return redirect()->back()->with('error', __('No items selected!'));
            }
            if (empty($action)) {
                return redirect()->back()->with('error', __('Please select an action!'));
            }

            switch ($action) {
                case "delete":
                    foreach ($ids as $id) {
                        $query = $this->airport::where("id", $id);
                        if (!$this->hasPermission('space_manage_others')) {
                            $query->where("create_user", Auth::id());
                            $this->checkPermission('space_delete');
                        }
                        $row = $query->first();
                        if (!empty($row)) {
                            $row->delete();
                        }
                    }
                    return redirect()->back()->with('success', __('Deleted success!'));
                    break;
                case "permanently_delete":
                    foreach ($ids as $id) {
                        $query = $this->airport::where("id", $id);
                        if (!$this->hasPermission('space_manage_others')) {
                            $query->where("create_user", Auth::id());
                            $this->checkPermission('space_delete');
                        }
                        $row = $query->first();
                        if ($row) {
                            $row->delete();
                        }
                    }
                    return redirect()->back()->with('success', __('Permanently delete success!'));
                    break;
                case "clone":
                    $this->checkPermission('space_create');
                    foreach ($ids as $id) {
                        (new $this->airport())->saveCloneByID($id);
                    }
                    return redirect()->back()->with('success', __('Clone success!'));
                    break;
                default:
                    // Change status
                    foreach ($ids as $id) {
                        $query = $this->airport::where("id", $id);
                        if (!$this->hasPermission('space_manage_others')) {
                            $query->where("create_user", Auth::id());
                            $this->checkPermission('space_update');
                        }
                        $row = $query->first();
                        $row->status = $action;
                        $row->save();
                    }
                    return redirect()->back()->with('success', __('Update success!'));
                    break;
            }


        }
        public function getForSelect2(Request $request)
        {
            $pre_selected = $request->query('pre_selected');
            $selected = $request->query('selected');

            if($pre_selected && $selected){
                $item = $this->airport::find($selected);
                if(empty($item)){
                    return response()->json([
                        'text'=>''
                    ]);
                }else{
                    return response()->json([
                        'text'=>$item->name
                    ]);
                }
            }
            $q = $request->query('q');
            $query = $this->airport::select('id', 'name as text');
            if ($q) {
                $query->where('name', 'like', '%' . $q . '%');
            }
            $res = $query->orderBy('id', 'desc')->limit(20)->get();
            return response()->json([
                'results' => $res
            ]);
        }

    }

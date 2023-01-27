<?php
namespace Modules\Space\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Space\Models\Bus;
use Modules\Space\Models\BusSeat;
use Modules\Space\Models\BusSeatType;
use Modules\FrontendController;

class ManageBusSeatController extends FrontendController
{
    protected $flight;
    protected $currentFlight;
    /**
     * @var string
     */
    private $flightSeat;

    public function __construct()
    {
        parent::__construct();
        $this->flight = Bus::class;
        $this->flightSeat = BusSeat::class;
    }

    protected function hasFlightPermission($flight_id = false){
        if(empty($flight_id)) return false;
        $flight = $this->flight::find($flight_id);
        if(empty($flight)) return false;
        if(!$this->hasPermission('space_update') and $flight->create_user != Auth::id()){
            return false;
        }
        $this->currentFlight = $flight;
        return true;
    }
    public function index(Request $request,$flight_id)
    {
        $this->checkPermission('space_view');

        if(!$this->hasFlightPermission($flight_id))
        {
            abort(403);
        }
        $query = $this->flightSeat::query() ;
        $query->orderBy('id', 'desc');
        if (!empty($flight_name = $request->input('s'))) {
            $query->where('title', 'LIKE', '%' . $flight_name . '%');
            $query->orderBy('title', 'asc');
        }
        $query->where('flight_id',$flight_id);
        $data = [
            'rows'               => $query->with(['author'])->paginate(20),
            'breadcrumbs'        => [
                [
                    'name' => __('Buses'),
                    'url'  => route('space.vendor.index')
                ],
                [
                    'name' => __('Bus: :name',['name'=>$this->currentFlight->title]),
                    'url'  => route('space.vendor.edit',[$this->currentFlight->id])
                ],
                [
                    'name'  => __('All Bus seats'),
                    'class' => 'active'
                ],
            ],
            'page_title'=>__("Bus seat Management"),
            'currentFlight'=>$this->currentFlight,
            'row'=> new $this->flightSeat(),
        ];
        return view('Space::frontend.manageSpace.seat.index', $data);
    }

    public function create($flight_id)
    {
        $this->checkPermission('space_update');

        if(!$this->hasFlightPermission($flight_id))
        {
            abort(403);
        }
        $row = new $this->flightSeat();
        $data = [
            'row'            => $row,
            'translation'    => $row,
            'seatType'=>BusSeatType::all(),
            'enable_multi_lang'=>true,
            'breadcrumbs'    => [
                [
                    'name' => __('Buses'),
                    'url'  => route('space.vendor.index')
                ],
                [
                    'name' => __('Bus: :name',['name'=>$this->currentFlight->title]),
                    'url'  => route('space.vendor.edit',[$this->currentFlight->id])
                ],
                [
                    'name' => __('All Bus seats'),
                    'url'  => route("space.vendor.seat.index",['flight_id'=>$this->currentFlight->id])
                ],
                [
                    'name'  => __('Create'),
                    'class' => 'active'
                ],
            ],
            'page_title'         => __("Create Bus seat"),
            'currentFlight'=>$this->currentFlight
        ];
        return view('Space::frontend.manageSpace.seat.detail', $data);
    }

    public function edit(Request $request, $flight_id,$id)
    {
        $this->checkPermission('space_update');

        if(!$this->hasFlightPermission($flight_id))
        {
            abort(403);
        }

        $row = $this->flightSeat::find($id);
        if (empty($row) or $row->flight_id != $flight_id) {
            return redirect(route('space.vendor.seat.index',['flight_id'=>$flight_id]));
        }


        $data = [
            'row'            => $row,
            'translation'    => $row,
            'seatType'=>BusSeatType::all(),
            'enable_multi_lang'=>false,
            'breadcrumbs'    => [
                [
                    'name' => __('Buses'),
                    'url'  => route('space.vendor.index')
                ],
                [
                    'name' => __('Bus: :name',['name'=>$this->currentFlight->title]),
                    'url'  => route('space.vendor.edit',[$this->currentFlight->id])
                ],
                [
                    'name' => __('All Bus seats'),
                    'url'  => route("space.vendor.seat.index",['flight_id'=>$this->currentFlight->id])
                ],
                [
                    'name' => __('Edit  :name',['name'=>$row->title]),
                    'class' => 'active'
                ],
            ],
            'page_title'=>__("Edit: :name",['name'=>$row->title]),
            'currentFlight'=>$this->currentFlight
        ];
        return view('Space::frontend.manageSpace.seat.detail', $data);
    }

    public function store( Request $request, $flight_id,$id ){

        if(!$this->hasFlightPermission($flight_id))
        {
            abort(403);
        }
        if($id>0){
            $this->checkPermission('space_update');
            $row = $this->flightSeat::find($id);
            if (empty($row)) {
                return redirect(route('space.vendor.index'));
            }
            if($row->flight_id != $flight_id)
            {
                return redirect(route('space.vendor.seat.index'));
            }
        }else{
            $this->checkPermission('space_create');
            $row = new $this->flightSeat();
        }
        $validator = Validator::make($request->all(), [
            'seat_type'=>[
                'required',
                Rule::unique('bravo_bus_seats')->where(function ($query)use($flight_id){
                    return $query->where('flight_id',$flight_id);
                })->ignore($row)
            ],
            'price'=>'required',
            'max_passengers'=>'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $dataKeys = [
            'seat_type','price','max_passengers','person','baggage_check_in','baggage_cabin'
        ];

        $row->fillByAttr($dataKeys,$request->input());

        if(!empty($id) and $id == "-1"){
            $row->flight_id = $flight_id;
        }

        $res = $row->save();

        if ($res) {
            if($id > 0 ){
                return redirect()->back()->with('success',  __('Bus seat updated') );
            }else{
                return redirect(route('space.vendor.seat.edit',['flight_id'=>$flight_id,'id'=>$row->id]))->with('success', __('Bus seat created') );
            }
        }
    }


    public function delete($flight_id,$id )
    {
        $this->checkPermission('space_delete');
        $user_id = Auth::id();
        $query = $this->flightSeat::where("flight_id", $flight_id)->where("id", $id)->first();
        if(!empty($query)){
            $query->delete();
        }
        return redirect()->back()->with('success', __('Delete room success!'));
    }

    public function bulkEdit(Request $request , $flight_id)
    {
        // dd($request->all());
        $ids = $request->input('ids');

        $this->checkPermission('space_update');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('No items selected!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }
        switch ($action){
            case "delete":
                foreach ($ids as $id) {
                    $query = $this->flightSeat::where("id", $id);
                    $query->where("create_user", Auth::id());
                    $this->checkPermission('space_delete');
                    $row  =  $query->first();
                    if(!empty($row)){
                        $row->delete();
                    }
                }
                return redirect()->back()->with('success', __('Deleted success!'));
                break;
            case "permanently_delete":
                foreach ($ids as $id) {
                    $query = $this->flightSeat::where("id", $id);
                    if (!$this->hasPermission('space_manage_others')) {
                        $query->where("create_user", Auth::id());
                        $this->checkPermission('space_delete');
                    }
                    $row  =  $query->first();
                    if($row){
                        $row->delete();
                    }
                }
                return redirect()->back()->with('success', __('Permanently delete success!'));
                break;

            default:
                // Change status
                foreach ($ids as $id) {
                    $query = $this->flightSeat::where("id", $id);
                    $query->where("create_user", Auth::id());
                    $this->checkPermission('space_update');
                    $row = $query->first();
                    $row->status  = $action;
                    $row->save();
                }
                return redirect()->back()->with('success', __('Update success!'));
                break;
        }
    }
}
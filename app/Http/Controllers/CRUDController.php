<?php 
    namespace App\Http\Controllers;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Student;
    class CRUDController extends Controller
    {
        /*
         * Mostra todos os registros
         */
	    public function index()
	    {
            $data = Student::all();
            return view('crud.index')->with('data',$data);
	    }

        /*
         * Cadastra um estudante no banco de dados
         */
        public function add(Request $request)
        {
            $data = new Student;
            $data -> first_name = $request -> first_name;
            $data -> last_name = $request -> last_name;
            $data -> email = $request -> email;
            $data -> save();
            return back()
                    ->with('success','Record Added successfully.');
        }

        /*
         * Busca estudante por Id
         */
        public function view(Request $request)
        {
            if($request->ajax()){
                $id = $request->id;
                $info = Student::find($id);
                //echo json_decode($info);
                return response()->json($info);
            }
        }

        /*
        *   Atualiza os registros
        */
        public function update(Request $request)
        {
            $id = $request -> edit_id;
            $data = Student::find($id);
            $data -> first_name = $request -> edit_first_name;
            $data -> last_name = $request -> edit_last_name;
            $data -> email = $request -> edit_email;
            $data -> save();
            return back()
                    ->with('success','Record Updated successfully.');
        }

        /*
        *   Remove o registro
        */
        public function delete(Request $request)
        {
            $id = $request -> id;
            $data = Student::find($id);
            $response = $data -> delete();
            if($response)
                echo "Record Deleted successfully.";
            else
                echo "There was a problem. Please try again later.";
        }
    }
?>
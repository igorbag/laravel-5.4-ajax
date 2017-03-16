<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation give you tools you need to build any application with which you are tasked.

## Learning Laravel

Laravel has the most extensive and thorough documentation and video tutorial library of any modern web application framework. The [Laravel documentation](https://laravel.com/docs) is thorough, complete, and makes it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 900 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
"# laravel-5.4-ajax" 


## -Tutorial do Projeto - ##

Criação de Crud Usando Jquery e Ajax no Laravel 5.4

As funcionalidades CRUD (Criar, Ler, Atualizar e Excluir) são usadas na maioria das aplicações web. Aprender operações CRUD são passos muito básicos para aprender qualquer linguagem de programação. Neste artigo eu gostaria de explicar operações básicas CRUD no laravel 5.4 usando jQuery e Ajax. 
Utilizaremos o banco de dados MySQL, e o primeiro passo é criar a tabela student e users para autenticacao do laravel.

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

Modelo (app / Student.php)

<?php
namespace App;
 use Illuminate\Database\Eloquent\Model;
    class Student extends Model
    {
        protected $table = 'student';
    }
?>
Roteamento (routes/web.php)
<?php


Route::get('/', function () {
    return view('welcome');
});




Auth::routes();

	Route::get('/home', 'CRUDController@index');
	//Rotas da aplicacao WEB do CRUD
  	Route::get('crud', 'CRUDController@index');
    Route::post('crud', 'CRUDController@add');
    Route::get('crud/view', 'CRUDController@view');
    Route::post('crud/update', 'CRUDController@update');
    Route::post('crud/delete', 'CRUDController@delete');

Controllers (App / Http / Controladores / CRUDController.Php)
<?php 
    namespace App\Http\Controllers;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Student;
    class CRUDController extends Controller
    {
        /*
         * Display all data
         */
	    public function index()
	    {
            $data = Student::all();
            return view('crud.index')->with('data',$data);
	    }

        /*
         * Add student data
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
         * View data
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
        *   Update data
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
        *   Delete record
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


Modelo CRUD
Crie o arquivo blade template ie, resources / views / crud / index.blade.php 

  <!DOCTYPE html>
<html lang="en">
  <head>
    <title>CRUD operations in Laravel 5.3</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  </head>
  <body>
<div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
   
</body>
  <div class="container">
    <h2>CRUD and Login in Laravel 5.4 With Ajax</h2> 
    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
      </div>
    @endif
    <button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#addModal">Add</button>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      @foreach($data as $x)
        <tr>
          <td>{{$x -> first_name}}</td>
          <td>{{$x -> last_name}}</td>
          <td>{{$x -> email}}</td>
          <td>
              <input type="hidden" name="idHidden" id="idHidden" value="{{$x -> id}}" />
              <button class="btn btn-info" data-toggle="modal" data-target="#viewModal" id="btnView">View</button>
              <button class="btn btn-warning" data-toggle="modal" data-target="#editModal" id="btnEdit">Edit</button>
              <button class="btn btn-danger" id="btnDelete">Delete</button>
          </td>
        </tr>
       @endforeach
      </tbody>
    </table>
    <input type="hidden" name="hidden_view" id="hidden_view" value="{{url('crud/view')}}">
    <input type="hidden" name="hidden_delete" id="hidden_delete" value="{{url('crud/delete')}}">
    <!-- Add Modal start -->
    <div class="modal fade" id="addModal" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Record</h4>
          </div>
          <div class="modal-body">
            <form action="{{ url('crud') }}" method="post">
              {{ csrf_field() }}
              <div class="form-group">
                <div class="form-group">
                  <label for="first_name">First Name:</label>
                  <input type="text" class="form-control" id="first_name" name="first_name">
                </div>
                <div class="form-group">
                  <label for="last_name">Last Name:</label>
                  <input type="text" class="form-control" id="last_name" name="last_name">
                </div>
                <label for="email">Email address:</label>
                <input type="email" class="form-control" id="email" name="email">
              </div>
              
              <button type="submit" class="btn btn-default">Submit</button>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        
      </div>
    </div>
    <!-- add code ends -->

    <!-- View Modal start -->
    <div class="modal fade" id="viewModal" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">View</h4>
          </div>
          <div class="modal-body">
            <p><b>First Name : </b><span id="view_fname" class="text-success"></span></p>
            <p><b>Last Name : </b><span id="view_lname" class="text-success"></span></p>
            <p><b>Email : </b><span id="view_email" class="text-success">bhaskar.panja@quadone.com</span></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        
      </div>
    </div>
    <!-- view modal ends -->

    <!-- Edit Modal start -->
    <div class="modal fade" id="editModal" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit</h4>
          </div>
          <div class="modal-body">
            <form action="{{ url('crud/update') }}" method="post">
              {{ csrf_field() }}
              <div class="form-group">
                <div class="form-group">
                  <label for="edit_first_name">First Name:</label>
                  <input type="text" class="form-control" id="edit_first_name" name="edit_first_name">
                </div>
                <div class="form-group">
                  <label for="edit_last_name">Last Name:</label>
                  <input type="text" class="form-control" id="edit_last_name" name="edit_last_name">
                </div>
                <label for="edit_email">Email address:</label>
                <input type="email" class="form-control" id="edit_email" name="edit_email">
              </div>
              
              <button type="submit" class="btn btn-default">Update</button>
              <input type="hidden" id="edit_id" name="edit_id">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          
        </div>
        
      </div>
    </div>
    <!-- Edit code ends -->
  </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="{!! asset('js/crud.js') !!}"></script>
  </body>
</html>
	


Criando Requisições AJAX com Laravel e Jquery
Criar em Public/js/crud.js
var GerenciamentoCrud = {
buscarPorId: function () {
       var view_url = $("#hidden_view").val();
          $.ajax({
        url: view_url,
        type:"GET", 
        data: {"id":$("#idHidden").val()}, 
        success: function(result){
          $("#view_fname").text(result.first_name);
          $("#view_lname").text(result.last_name);
          $("#view_email").text(result.email);
        }
      });
    },


    editar: function(){
    	var view_url = $("#hidden_view").val();

    	$.ajax({
        url: view_url,
        type:"GET", 
        data: {"id":$("#idHidden").val()}, 
        success: function(result){
          //console.log(result);
          $("#edit_id").val(result.id);
          $("#edit_first_name").val(result.first_name);
          $("#edit_last_name").val(result.last_name);
          $("#edit_email").val(result.email);
        }
      });
    },

    deletar: function(){
 	  var conf = confirm("Are you sure want to delete??");
     

      if(conf){
        var delete_url = $("#hidden_delete").val();
          
        $.ajax({
          url: delete_url,
          type:"POST", 
          data: {"id":$("#idHidden").val(),_token:  $('input[name="_token"]').val()}, 
          success: function(response){
            alert(response);
            location.reload(); 
          }
        });
      }
      else{
        return false;
      }

      }

};


$(document).ready(function() {
    $("body").on("click", "#btnView", GerenciamentoCrud.buscarPorId)
    $("body").on("click", "#btnEdit", GerenciamentoCrud.editar);
    $("body").on("click", "#btnDelete", GerenciamentoCrud.deletar);
     
});




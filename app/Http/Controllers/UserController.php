<?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Contracts\Pagination\LengthAwarePaginator;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;

    /**
     * Class UserController
     *
     * @package App\Http\Controllers
     * This class handles the user related operations such as registration and listing users.
     */
    class UserController extends Controller {

        /**
         * Register a new user.
         * This method validates the request data and creates a new user.
         *
         * @param  Request  $request  The incoming HTTP request.
         *
         * @return Model|User The newly created user.
         */
        public function register(Request $request): Model|User {

            $request->validate([
                'name'     => 'required|string',
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'type'     => 'user',
                'password' => Hash::make($request->password),
            ]);

            return $user;
        }

        /**
         * List the users.
         * This method retrieves the users from the database and returns a paginated list.
         *
         * @param  Request  $request  The incoming HTTP request.
         *
         * @return LengthAwarePaginator The paginated list of users.
         */
        public function list(Request $request): LengthAwarePaginator {

            $page = $request->query('page', 1);

            return User::where('type', 'user')->paginate(10, ['*'], 'page', $page);
        }

    }
